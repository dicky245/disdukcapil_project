#!/usr/bin/env python3
"""KTP OCR Service - Flask API + CLI Mode v3.1"""

import os, sys, re, json, base64, io
from flask import Flask, request, jsonify
from werkzeug.utils import secure_filename

try:
    import easyocr, cv2, numpy as np
    from PIL import Image
    EASYOCR_AVAILABLE = True
except ImportError as e:
    EASYOCR_AVAILABLE = False
    print(f"# Warning: {e}", file=sys.stderr)

app = Flask(__name__)
app.config['UPLOAD_FOLDER'] = "uploads"
app.config['MAX_CONTENT_LENGTH'] = 16 * 1024 * 1024
os.makedirs(app.config['UPLOAD_FOLDER'], exist_ok=True)

_reader = None

def get_reader():
    global _reader
    if _reader is None and EASYOCR_AVAILABLE:
        _reader = easyocr.Reader(["id", "en"], gpu=False, verbose=False)
    return _reader

def allowed_file(fn):
    return "." in fn and fn.rsplit(".", 1)[1].lower() in {"png", "jpg", "jpeg", "webp", "bmp"}

def preprocess_image(path):
    if not EASYOCR_AVAILABLE: return path
    img = cv2.imread(path)
    if img is None: return path
    try:
        h, w = img.shape[:2]
        if w < 800:
            img = cv2.resize(img, None, fx=800/w, fy=800/w, interpolation=cv2.INTER_CUBIC)
        gray = cv2.cvtColor(img.copy(), cv2.COLOR_BGR2GRAY)
        clahe = cv2.createCLAHE(clipLimit=2.0, tileGridSize=(8, 8))
        enhanced = clahe.apply(gray)
        denoised = cv2.fastNlMeansDenoising(enhanced, None, h=5, templateWindowSize=7)
        out = path.replace(".", "_proc.")
        cv2.imwrite(out, denoised, [cv2.IMWRITE_PNG_COMPRESSION, 0])
        return out
    except: return path

class KtpOcrParser:
    def __init__(self, text):
        self.raw = text
        self.lines = [l.strip() for l in text.replace('\r\n','\n').replace('\r','\n').split('\n') if l.strip()]
        self.upper = [l.upper() for l in self.lines]
    
    def _label_idx(self, kws):
        for i, l in enumerate(self.upper):
            for kw in kws:
                if kw.upper() in l: return i
        return -1
    
    def _is_label(self, t):
        if not t: return True
        u = t.upper().strip()
        for l in ['NIK','NAMA','TEMPAT','LAHIR','TTL','TANGGAL','ALAMAT','RT','RW','KEL','DESA','KELURAHAN','KECAMATAN','KEC','KABUPATEN','KOTA','KAB','PROVINSI','AGAMA','STATUS','PERKAWINAN','PEKERJAAN','KEWARGANEGARAAN','BERLAKU','HINGGA','JENIS','KELAMIN','GOL','DARAH','PEKERJAAN','KAR','KARYAWAN','WNI','WNA','ISLAM','KRISTEN','KATOLIK','HINDU','BUDDHA','KONGHUCU']:
            if u == l or u.startswith(l + ' ') or u.startswith(l + ':'): return True
        return False
    
    def _near_label(self, kws, max_l=3):
        idx = self._label_idx(kws)
        if idx < 0: return '', 0.0
        for kw in kws:
            for ln in [self.lines[idx], self.upper[idx]]:
                for p in [rf'{kw}\s*[:.\-]?\s*(.+)', rf'{kw}\s+([A-Z0-9].+)']:
                    m = re.search(p, ln, re.IGNORECASE)
                    if m:
                        v = re.sub(r'\s+', ' ', m.group(1).strip())
                        if len(v) >= 2 and not self._is_label(v): return v.upper(), 0.9
        for i in range(idx+1, min(idx+max_l, len(self.lines))):
            ln = self.lines[i]
            if self._is_label(ln): continue
            u = ln.upper()
            stops = ['NIK','NAMA','JENIS','GOL','RT','RW','KEL','KEC','KAB','PROV','AGAMA','STATUS','PEKERJAAN','KEWARGAN','BERLAKU']
            if any(s in u for s in stops) and any(s == u or u.startswith(s+' ') for s in stops): continue
            if re.search(r'^\d{1,2}[-/.]\d{1,2}[-/.]\d{2,4}$', ln): continue
            return ln.upper(), 0.8
        return '', 0.0
    
    def extract_nik(self):
        for m in re.findall(r'\b(\d{16})\b', self.raw): return m, 1.0
        idx = self._label_idx(['NIK'])
        if idx >= 0:
            m = re.search(r'NIK\s*[:.\-]?\s*(\d+)', self.upper[idx], re.I)
            if m:
                n = m.group(1)
                if len(n) == 16: return n, 0.9
                n = re.sub(r'[^\d]', '', n)
                if len(n) == 16: return n, 0.9
            for i in range(idx, min(idx+3, len(self.lines))):
                m = re.search(r'\b(\d{16})\b', self.lines[i])
                if m: return m.group(1), 0.9
        return '', 0.0
    
    def extract_nama(self):
        idx = self._label_idx(['NAMA'])
        if idx >= 0:
            ln = self.upper[idx]
            # Name BEFORE label: "JOHN Nama"
            m = re.search(r'([A-Z][A-Z\s]{2,})\s+Nama\b', ln)
            if m:
                v = m.group(1).strip()
                if len(v) >= 2: return v.upper(), 0.9
            # Name AFTER label: "Nama JOHN"
            for p in [r'NAMA\s*[:.\-]?\s*(.+)', r'NAMA\s+([A-Z][A-Z\s]+.+)']:
                m = re.search(p, ln, re.I)
                if m:
                    v = re.sub(r'\s+', ' ', m.group(1).strip())
                    if not any(x in v.upper() for x in ['TGL','TEMPAT','LAHIR']) and len(v) >= 2 and not self._is_label(v): return v.upper(), 0.9
            # Next line
            for i in range(idx+1, min(idx+2, len(self.lines))):
                nl = self.lines[i]
                nu = nl.upper()
                if any(x in nu for x in ['JL','JL.','KP','PERUM','DUSUN','RT','RW','NO ','NOMOR','NIK','JENIS','GOL']): continue
                if re.search(r'^\d{1,2}[-/.]\d{1,2}[-/.]\d{2,4}', nl): continue
                if len(nl) >= 2 and not self._is_label(nl): return nl.upper(), 0.8
        return '', 0.0
    
    def extract_tempat_lahir(self):
        idx = self._label_idx(['TEMPAT','TTL'])
        if idx >= 0:
            ln = self.upper[idx]
            # City BEFORE TTL: "CITY TempauTgl Lahir"
            m = re.search(r'([A-Z][A-Z\s]+)\s+(?:TempauTgl|TEMPATTGL|Tgl\s+Lahir)', ln)
            if m:
                v = m.group(1).strip()
                if len(v) >= 2: return v.upper(), 1.0
            # CITY, DD-MM-YYYY
            m = re.search(r'([A-Z][A-Z\s]+)[,\s]+\d{1,2}[-/.]\d{1,2}[-/.]\d{2,4}', ln)
            if m:
                v = m.group(1).strip()
                if len(v) >= 2: return v.upper(), 1.0
            # After TEMPAT label
            m = re.search(r'TEMPAT\s*[:.\-]?\s*(.+)', ln, re.I)
            if m:
                v = re.sub(r'\s+', ' ', m.group(1).strip())
                v = re.sub(r'\s*(?:TempauTgl|TEMPATTGL|TGL|LAHIR|TEMPAT).*', '', v, flags=re.I)
                v = re.sub(r'[,\s]+\d{1,2}[-/.]\d{1,2}[-/.]\d{2,4}.*', '', v)
                if len(v) >= 2: return v.upper(), 0.9
            # Next lines (skip dates)
            for i in range(idx+1, min(idx+2, len(self.lines))):
                nl = self.lines[i]
                if re.search(r'^\d{1,2}[-/.]\d{1,2}[-/.]\d{2,4}$', nl): continue
                if any(x in nl.upper() for x in ['TGL','LAHIR','TEMPAT']): continue
                if len(nl) >= 2 and not self._is_label(nl): return nl.upper(), 0.8
        return '', 0.0
    
    def extract_tanggal_lahir(self):
        p = [r'(\d{1,2})[-/.](\d{1,2})[-/.](\d{4})', r'(\d{1,2})\s+(\d{1,2})\s+(\d{4})']
        idx = self._label_idx(['TEMPAT','TTL','LAHIR','TANGGAL'])
        if idx >= 0:
            for i in range(idx, min(idx+3, len(self.lines))):
                for pp in p:
                    m = re.search(pp, self.lines[i])
                    if m:
                        d,mo,y = m.groups()
                        if 1 <= int(mo) <= 12: return f"{d.zfill(2)}-{mo.zfill(2)}-{y}", 1.0
        for ln in self.lines:
            for pp in p:
                m = re.search(pp, ln)
                if m:
                    d,mo,y = m.groups()
                    if 1 <= int(mo) <= 12: return f"{d.zfill(2)}-{mo.zfill(2)}-{y}", 1.0
        return '', 0.0
    
    def extract_jenis_kelamin(self):
        for ln in self.upper:
            if 'LAKI' in ln: return 'LAKI-LAKI', 1.0
            if 'PEREMPUAN' in ln: return 'PEREMPUAN', 1.0
        return '', 0.0
    
    def extract_gol_darah(self):
        idx = self._label_idx(['GOL','DARAH'])
        if idx >= 0:
            for i in range(idx, min(idx+2, len(self.lines))):
                m = re.search(r'\b(A|B|AB|O)[+-]?\b', self.lines[i], re.I)
                if m: return m.group(1).upper(), 0.9
        for ln in self.lines:
            m = re.search(r'\b(A|B|AB|O)[+-]?\b', ln, re.I)
            if m: return m.group(1).upper(), 0.7
        return '', 0.0
    
    def extract_alamat(self):
        idx = self._label_idx(['ALAMAT'])
        if idx >= 0:
            parts = []
            for i in range(idx, min(idx+5, len(self.lines))):
                ln = self.lines[i]
                u = ln.upper()
                if 'RT' in u and 'RW' in u: break
                if re.search(r'\d{1,3}\s*[/:]\s*\d{1,3}', ln): break
                if any(x in u for x in ['KEL','DESA','KELURAHAN','KEC','KECAMATAN','NIK']): break
                if i == idx:
                    m = re.search(r'ALAMAT\s*[:.\-]?\s*(.+)', u, re.I)
                    if m and len(m.group(1).strip()) >= 2: parts.append(m.group(1).strip())
                elif len(ln) >= 2 and not self._is_label(ln): parts.append(ln)
            if parts: return ' '.join(parts).upper(), 0.9
        for ln in self.lines:
            for p in [r'JL\.?\s+(.+)',r'JALAN\s+(.+)',r'KP\.?\s+(.+)',r'PERUM\s+(.+)',r'DUSUN\s+(.+)']:
                m = re.search(p, ln, re.I)
                if m and len(m.group(1).strip()) >= 3: return m.group(1).strip().upper(), 0.8
        return '', 0.0
    
    def extract_rt_rw(self):
        for ln in self.lines:
            m = re.search(r'RT\s*(\d{1,3})\s*[/:]\s*RW\s*(\d{1,3})', ln, re.I)
            if m: return f"RT {m.group(1).zfill(3)}/RW {m.group(2).zfill(3)}", 1.0
            m = re.search(r'(?<![RT\s])(\d{1,3})\s*[/:]\s*(\d{1,3})(?!\s*/\s*\d)', ln)
            if m: return f"RT {m.group(1).zfill(3)}/RW {m.group(2).zfill(3)}", 0.9
        return '', 0.0
    
    def extract_kel_desa(self): return self._near_label(['KEL','DESA','KELURAHAN'])
    def extract_kecamatan(self): return self._near_label(['KECAMATAN','KEC'])
    def extract_provinsi(self): return self._near_label(['PROVINSI'])
    
    def extract_kab_kota(self):
        idx = self._label_idx(['KABUPATEN','KOTA'])
        if idx >= 0:
            ln = self.upper[idx]
            for p in [r'KABUPATEN\s*[:.\-]?\s*(.+)',r'KOTA\s*[:.\-]?\s*(.+)',r'KABUPATEN/KOTA\s*[:.\-]?\s*(.+)']:
                m = re.search(p, ln, re.I)
                if m and len(m.group(1).strip()) >= 2: return m.group(1).strip().upper(), 0.9
            for i in range(idx+1, min(idx+2, len(self.lines))):
                nl = self.lines[i]
                if len(nl) >= 2 and not self._is_label(nl): return nl.upper(), 0.8
        return '', 0.0
    
    def extract_agama(self):
        for ln in self.upper:
            for p,n in [('ISLAM','Islam'),('KRISTEN','Kristen'),('KATOLIK','Katolik'),('HINDU','Hindu'),('BUDDHA','Buddha'),('KONGHUCU','Konghucu')]:
                if p in ln: return n, 1.0
        return '', 0.0
    
    def extract_status_kawin(self):
        for ln in self.upper:
            for p,n in [('BELUM KAWIN','Belum Kawin'),('KAWIN','Kawin'),('CERAI HIDUP','Cerai Hidup'),('CERAI MATI','Cerai Mati')]:
                if p in ln: return n, 1.0
        return '', 0.0
    
    def extract_pekerjaan(self): return self._near_label(['PEKERJAAN'])
    
    def extract_kewarganegaraan(self):
        for ln in self.upper:
            if 'WNI' in ln: return 'WNI', 1.0
            if 'WNA' in ln: return 'WNA', 1.0
        return 'WNI', 0.5
    
    def extract_berlaku(self):
        for ln in self.upper:
            if 'BERLAKU' in ln:
                if 'SEUMUR' in ln or 'SEPANJANG' in ln: return 'SEUMUR HIDUP', 1.0
                m = re.search(r'(\d{1,2})[-/.](\d{1,2})[-/.](\d{4})', ln)
                if m: return f"{m.group(1).zfill(2)}-{m.group(2).zfill(2)}-{m.group(3)}", 1.0
        return '', 0.0
    
    def parse(self):
        field_map = {
            'nik': 'nik', 'nama_lengkap': 'nama', 'tempat_lahir': 'tempat_lahir',
            'tanggal_lahir': 'tanggal_lahir', 'jenis_kelamin': 'jenis_kelamin',
            'gol_darah': 'gol_darah', 'alamat': 'alamat', 'rt_rw': 'rt_rw',
            'kel_desa': 'kel_desa', 'kec': 'kecamatan', 'kab_kota': 'kab_kota',
            'provinsi': 'provinsi', 'agama': 'agama', 'status_perkawinan': 'status_kawin',
            'pekerjaan': 'pekerjaan', 'kewarganegaraan': 'kewarganegaraan',
            'berlaku_hingga': 'berlaku'
        }
        data = {}
        conf = {}
        for f, m in field_map.items():
            val, c = getattr(self, 'extract_'+m)()
            data[f] = val
            conf[f] = c
        valid = [c for c in conf.values() if c > 0]
        avg = sum(valid)/len(valid) if valid else 0.0
        return {**data, '_raw_text': self.raw, '_confidence_avg': round(avg,4), '_field_confidence': conf}


def process_ocr(path):
    if not EASYOCR_AVAILABLE: return {'success':False,'message':'EasyOCR not available','data':None}
    try:
        reader = get_reader()
        if not reader: return {'success':False,'message':'Failed to init reader','data':None}
        proc = preprocess_image(path)
        results = reader.readtext(proc, detail=1)
        if proc != path and os.path.exists(proc): os.remove(proc)
        # Sort by Y position
        sorted_r = sorted(results, key=lambda x: sum(p[1] for p in x[0])/len(x[0]))
        # Group into lines
        lines, cur, last_y = [], [], None
        for (bbox,text,conf) in sorted_r:
            text = text.strip()
            if not text: continue
            avg_y = sum(p[1] for p in bbox)/len(bbox)
            if last_y and abs(avg_y-last_y) > 20:
                if cur: lines.append(' '.join(cur))
                cur = []
            cur.append(text)
            last_y = avg_y
        if cur: lines.append(' '.join(cur))
        raw = '\n'.join(lines)
        parser = KtpOcrParser(raw)
        return {'success':True,'message':'OCR berhasil','data':parser.parse()}
    except Exception as e:
        import traceback
        print(f"Error: {e}\n{traceback.format_exc()}", file=sys.stderr)
        return {'success':False,'message':f'Error: {e}','data':None}


# Flask Routes
@app.route("/health")
def health(): return jsonify({"status":"ok","service":"KTP OCR","version":"3.1","easyocr":EASYOCR_AVAILABLE})

@app.route("/api/ocr/ktp", methods=["POST"])
def ocr_ktp():
    try:
        path = None
        if "image" in request.files:
            f = request.files["image"]
            if not f.filename: return jsonify({"success":False,"message":"No file"}),400
            if not allowed_file(f.filename): return jsonify({"success":False,"message":"Invalid format"}),400
            path = os.path.join(app.config['UPLOAD_FOLDER'], secure_filename(f.filename))
            f.save(path)
        elif request.is_json and "image_base64" in request.json:
            b64 = request.json["image_base64"]
            if "," in b64: b64 = b64.split(",")[1]
            img = Image.open(io.BytesIO(base64.b64decode(b64)))
            path = os.path.join(app.config['UPLOAD_FOLDER'], "temp.jpg")
            img.save(path)
        else:
            return jsonify({"success":False,"message":"Send as 'image' or JSON with 'image_base64'"}),400
        result = process_ocr(path)
        if path and os.path.exists(path):
            try: os.remove(path)
            except: pass
        return jsonify(result) if result['success'] else jsonify(result),500
    except Exception as e:
        return jsonify({"success":False,"message":str(e)}),500

@app.route("/api/ocr/batch", methods=["POST"])
def ocr_batch():
    key = "images[]" if "images[]" in request.files else "images"
    if key not in request.files: return jsonify({"success":False,"message":"No files"}),400
    results = []
    for f in request.files.getlist(key):
        if f and allowed_file(f.filename):
            path = os.path.join(app.config['UPLOAD_FOLDER'], secure_filename(f.filename))
            f.save(path)
            r = process_ocr(path)
            r['filename'] = f.filename
            results.append(r)
            if os.path.exists(path):
                try: os.remove(path)
                except: pass
    return jsonify({"success":True,"total":len(results),"results":results})

if __name__ == "__main__":
    if len(sys.argv) > 1 and sys.argv[1] not in ["-h","--help"]:
        path = sys.argv[1]
        if not os.path.exists(path):
            print(json.dumps({'status':'error','error':f'Not found: {path}'}), file=sys.stderr)
            sys.exit(1)
        if not EASYOCR_AVAILABLE:
            print(json.dumps({'status':'error','error':'EasyOCR not installed'}), file=sys.stderr)
            sys.exit(1)
        import contextlib
        with contextlib.redirect_stderr(open(os.devnull, 'w')):
            result = process_ocr(path)
        if result['success']:
            out = {'status':'success','raw':result['data']['_raw_text'],
                   'data':{k:v for k,v in result['data'].items() if not k.startswith('_')},
                   'conf':result['data']['_confidence_avg']}
            print(json.dumps(out, ensure_ascii=False))
        else:
            print(json.dumps({'status':'error','error':result['message']}), file=sys.stderr)
        sys.exit(0)
    port = int(os.environ.get('PORT', 5000))
    print(f"KTP OCR Service di http://localhost:{port} | EasyOCR: {EASYOCR_AVAILABLE}")
    app.run(host="0.0.0.0", port=port, debug=False)
