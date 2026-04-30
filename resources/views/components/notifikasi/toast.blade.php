{{-- 
    =====================================================
    PANDUAN PENGGUNAAN NOTIFIKASI DISDUKCAPIL
    =====================================================
    
    File ini berisi panduan lengkap penggunaan sistem notifikasi
    SweetAlert2 yang telah diintegrasikan ke seluruh aplikasi.
    
    LAYOUT YANG SUDAH TERINTEGRASI:
    - layouts/admin.blade.php ✅
    - layouts/user.blade.php ✅
    - layouts/keagaan.blade.php ✅
    - layouts/app.blade.php ✅
    
    FILE JAVASCRIPT YANG TERSEDIA:
    - public/js/sweetalert-disdukcapil.js
    - public/js/notifikasi-disdukcapil.js
    
    =====================================================
    CARA PENGGUNAAN
    =====================================================
--}}

{{-- =====================================================
     1. NOTIFIKASI TOAST SEDERHANA
     ===================================================== --}}
{{-- 
     notifToast(icon, judul, pesan, durasi)
     
     Icon: 'success', 'error', 'warning', 'info'
     Durasi: dalam milidetik (default: 4000ms)
     
     Contoh:
--}}
<button onclick="notifToast('success', 'Berhasil!', 'Data berhasil disimpan')">
    Toast Success
</button>

<button onclick="notifToast('error', 'Gagal!', 'Terjadi kesalahan')">
    Toast Error
</button>

<button onclick="notifToast('warning', 'Peringatan!', 'Periksa kembali data')">
    Toast Warning
</button>

<button onclick="notifToast('info', 'Info', 'Ini adalah informasi')">
    Toast Info
</button>


{{-- =====================================================
     2. NOTIFIKASI SUKSES (SIMPAN/UPDATE)
     ===================================================== --}}
{{-- 
     notifSuksesRegistrasi(nomorRegistrasi, callback)
     
     Untuk: Notifikasi setelah data berhasil disimpan
     Contoh:
--}}
<button onclick="notifSuksesRegistrasi('#REG-2024-001234')">
    Simpan Berhasil
</button>


{{-- =====================================================
     3. NOTIFIKASI ERROR
     ===================================================== --}}
{{-- 
     notifError(pesanError, callback)
     
     Untuk: Notifikasi error (simpan gagal, koneksi error, dll)
     Contoh:
--}}
<button onclick="notifError('NIK sudah terdaftar dalam sistem')">
    Tampilkan Error
</button>


{{-- =====================================================
     4. NOTIFIKASI VALIDASI
     ===================================================== --}}
{{-- 
     notifValidasiError(arrayErrors, callback)
     
     Untuk: Menampilkan daftar kesalahan validasi form
     Contoh:
--}}
<button onclick="notifValidasiError([
     'NIK wajib diisi (16 digit)',
     'Format tanggal tidak valid',
     'KTP scan wajib diunggah'
])">
    Validasi Gagal
</button>


{{-- =====================================================
     5. KONFIRMASI HAPUS
     ===================================================== --}}
{{-- 
     notifKonfirmasiHapus(namaData, onHapus, onBatal)
     
     Untuk: Konfirmasi sebelum menghapus data
     Contoh:
--}}
<button onclick="notifKonfirmasiHapus('Budi Santoso', hapusData)">
    Konfirmasi Hapus
</button>

<script>
function hapusData() {
    // Logic hapus di sini
    fetch('/api/hapus/' + id, { method: 'DELETE' })
        .then(r => r.json())
        .then(data => {
            notifHapusBerhasil('Budi Santoso');
            location.reload();
        });
}
</script>


{{-- =====================================================
     6. CARI DATA
     ===================================================== --}}
{{-- 
     notifCariDitemukan(jumlah, keyword)
     notifCariTidakDitemukan(keyword)
     
     Untuk: Notifikasi hasil pencarian
     Contoh:
--}}
<button onclick="notifCariDitemukan(5, 'Sitorus')">
    Cari Berhasil
</button>

<button onclick="notifCariTidakDitemukan('Sitoruss')">
    Cari Kosong
</button>


{{-- =====================================================
     7. NOMOR ANTRIAN
     ===================================================== --}}
{{-- 
     notifNomorAntrian(nomor, layanan, estimasi)
     
     Untuk: Menampilkan nomor antrian
     Contoh:
--}}
<button onclick="notifNomorAntrian('A-015', 'KTP', '± 15 menit')">
    Tampilkan Antrian
</button>


{{-- =====================================================
     8. LOADING
     ===================================================== --}}
{{-- 
     notifLoading(pesan)
     
     Untuk: Menampilkan modal loading
     Contoh:
--}}
<button onclick="testLoading()">
    Test Loading
</button>

<script>
async function testLoading() {
    const loading = notifLoading('Menyimpan data...');
    
    await fetch('/api/simpan', {
        method: 'POST',
        body: JSON.stringify(data)
    });
    
    Swal.close(); // Tutup loading
    notifSuksesRegistrasi('#REG-2024-001234');
}
</script>


{{-- =====================================================
     9. KONFIRMASI AKSI
     ===================================================== --}}
{{-- 
     notifKonfirmasiAksi(pesan, onSetuju, onBatal)
     
     Untuk: Konfirmasi umum (verifikasi, ACC, dll)
     Contoh:
--}}
<button onclick="notifKonfirmasiAksi(
    'Apakah Anda yakin ingin memverifikasi data ini?',
    () => { /* logic verifikasi */ },
    () => { /* logic cancel */ }
)">
    Konfirmasi Aksi
</button>


{{-- =====================================================
     10. NOTIFIKASI DISETUJUI
     ===================================================== --}}
{{-- 
     notifDisetujui(namaPemohon)
     
     Untuk: Notifikasi setelah data disetujui/ACC
     Contoh:
--}}
<button onclick="notifDisetujui('Budi Santoso')">
    Tampilkan Disetujui
</button>


{{-- =====================================================
     11. FORM BELUM LENGKAP
     ===================================================== --}}
{{-- 
     notifFormBelumLengkap()
     
     Untuk: Notifikasi saat form belum lengkap
     Contoh:
--}}
<button onclick="notifFormBelumLengkap()">
    Form Belum Lengkap
</button>


{{-- =====================================================
     12. UPLOAD FILE
     ===================================================== --}}
{{-- 
     notifUploadFile(namaFile, onSuccess, onError)
     
     Untuk: Notifikasi proses upload file
     Contoh:
--}}
<button onclick="testUpload()">
    Test Upload
</button>

<script>
async function testUpload() {
    const formData = new FormData();
    formData.append('file', fileInput.files[0]);
    
    notifUploadFile(
        'KTP_Scan.pdf',
        () => fetch('/api/upload', { method: 'POST', body: formData }),
        () => { /* retry logic */ }
    );
}
</script>


{{-- =====================================================
     13. WRAPPER (ALTERNATIF)
     ===================================================== --}}
{{-- 
     Menggunakan Notifikasi wrapper untuk backward compatibility:
--}}
<button onclick="Notifikasi.success('Data berhasil disimpan!')">
    Notifikasi.success()
</button>

<button onclick="Notifikasi.error('Terjadi kesalahan!')">
    Notifikasi.error()
</button>

<button onclick="Notifikasi.warning('Periksa kembali data!')">
    Notifikasi.warning()
</button>

<button onclick="Notifikasi.info('Ini informasi!')">
    Notifikasi.info()
</button>

<button onclick="Notifikasi.confirm('Yakin?', () => alert('Ya!'))">
    Notifikasi.confirm()
</button>


{{-- =====================================================
     14. CONTOH INTEGRASI PHP
     ===================================================== --}}
{{-- 
     Di dalam Controller PHP:
--}}
{{-- 
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|size:16',
            'nama' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'validasi',
                'errors' => $validator->errors()->all()
            ]);
        }

        $data = Model::create($request->all());
        
        return response()->json([
            'status' => 'success',
            'noReg' => '#REG-' . date('Y') . '-' . str_pad($data->id, 6, '0', STR_PAD_LEFT)
        ]);
    }
--}}

{{-- 
     Di dalam View Blade:
--}}
{{-- 
    <form id="formSimpan" onsubmit="submitForm(event)">
        <!-- form fields -->
    </form>

    <script>
    async function submitForm(e) {
        e.preventDefault();
        
        const formData = new FormData(e.target);
        
        notifLoading('Menyimpan data...');
        
        try {
            const response = await fetch('/api/simpan', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            Swal.close();
            
            if (result.status === 'success') {
                notifSuksesRegistrasi(result.noReg);
                e.target.reset();
            } else if (result.status === 'validasi') {
                notifValidasiError(result.errors);
            } else {
                notifError(result.message || 'Terjadi kesalahan');
            }
        } catch (error) {
            Swal.close();
            notifError('Koneksi gagal. Periksa jaringan Anda.');
        }
    }
    </script>
--}}


{{-- =====================================================
     TABEL REFERENSI WARNA
     =====================================================
     
     SUCCESS (Hijau): #22c55e / #16a34a
     ERROR (Merah):   #ef4444 / #dc2626
     WARNING (Kuning): #f59e0b / #d97706
     INFO (Biru):     #3b82f6 / #2563eb
     
--}}
