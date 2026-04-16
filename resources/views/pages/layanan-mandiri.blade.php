@extends('layouts.user')

@section('content')
@php
$serviceConfig = [
    // KK
    1 => [
        'icon'         => 'fa-address-card',
        'color'        => 'blue',
        'id'           => 'kk',
        'persyaratan'  => [
            'Kartu Keluarga Lama',
            'Fotokopi surat keterangan/bukti perubahan Peristiwa Kependudukan (cth: Paspor, SKPWNI) dan Peristiwa Penting.',
            'Dasar Hukum Pasal 12 Perpres 96/2018',
        ],
        'penjelasan'   => [
            'Penduduk mengisi F1.02',
            'Penduduk melampirkan KK lama',
            'Penduduk mengisi F1.06 karena perubahan elemen data dalam KK',
            'Penduduk melampirkan fotokopi bukti peristiwa kependudukan dan peristiwa penting',
            'Dinas menerbitkan KK Baru',
        ],
        'fields'       => [
            ['name' => 'layanan_id', 'value' => '1',  'type' => 'hidden'],
            
            ['type' => 'heading', 'label' => 'Informasi Pendaftaran'],
            ['name' => 'nomor_antrian', 'label' => 'Nomor Antrian (Opsional)', 'placeholder' => 'Nomor Antrian', 'type' => 'text', 'required' => false],
            
            ['type' => 'heading', 'label' => 'Data Kepala Keluarga'],
            ['name' => 'nama', 'label' => 'Nama Kepala Keluarga', 'placeholder' => 'Nama Kepala Keluarga', 'type' => 'text'],
            ['name' => 'nik', 'label' => 'Nomor Induk Kependudukan', 'placeholder' => '16 Digit NIK Kepala Keluarga', 'type' => 'text'],
            ['name' => 'alamat', 'label' => 'Alamat', 'placeholder' => 'Alamat Lengkap', 'type' => 'textarea'],
        ],
        'files' => [
            ['name' => 'formulir_f102', 'label' => 'Formulir F1.02'],
            ['name' => 'kk_lama', 'label' => 'Kartu Keluarga Sebelumnya'],
            ['name' => 'formulir_f106', 'label' => 'Formulir F1.06'],
            ['name' => 'surat_keterangan_perubahan', 'label' => 'Surat Keterangan Bukti Peristiwa Kependudukan dan Peristiwa Penting'],
            ['name' => 'pernyataan_pindah_kk', 'label' => 'Surat Pernyataan Pengasuhan/Wali (Diwajibkan Jika Pindah KK)', 'required' => false],
        ],
    ],

    6 => [
        'icon'         => 'fa-user-edit',
        'color'        => 'blue',
        'id'           => 'ganti_kepala_kk',
        'persyaratan'  => [
            'Fotokopi KK lama',
            'Fotokopi Akta kematian (Pasal 10 ayat (3) Permendagri 108/2019)',
        ],
        'penjelasan'   => [
            'Penduduk mengisi formulir F-1.02',
            'Melampirkan fotokopi akta kematian jika kepala keluarga meninggal;',
            'Melampirkan fotokopi KK lama',
            'Dinas menerbitkan KK Baru.Catatan:Untuk pelayanan online/Daring, persyaratan yang discan/difoto untuk diunggah harus aslinya'
        ],
        'fields'       => [
            ['name' => 'layanan_id',       'value' => '6',  'type' => 'hidden'],
            
            ['type' => 'heading', 'label' => 'Informasi Pendaftaran'],
            ['name' => 'nomor_antrian', 'label' => 'Nomor Antrian (Opsional)', 'placeholder' => 'Nomor Antrian', 'type' => 'text', 'required' => false],
            
            ['type' => 'heading', 'label' => 'Data Kepala KK Baru'],
            ['name' => 'nama', 'label' => 'Nama Kepala KK Baru',   'placeholder' => 'Nama sesuai KTP',           'type' => 'text'],
            ['name' => 'nik',  'label' => 'NIK Kepala KK Baru',    'placeholder' => '16 digit NIK',              'type' => 'text'],
            ['name' => 'alamat', 'label' => 'Alamat',   'placeholder' => 'Alamat Lengkap',           'type' => 'textarea'],
        ],
        'files' => [
            ['name' => 'formulir_f102', 'label' => 'Formulir F-1.02 yang Telah Diisi'],
            ['name' => 'fotokopi_akta_kematian', 'label' => 'Akte Kematian Kepala Keluarga Sebelumnya'],
            ['name' => 'kk_lama', 'label' => 'Kartu Keluarga Lama'],
            ['name' => 'surat_pernyataan_wali', 'label' => 'Surat Pernyataan Wali (Jika semua anggota < 17 tahun)','required'=> false]
        ],
    ],
    
    7 => [
        'icon'         => 'fa-file-medical-alt',
        'color'        => 'blue',
        'id'           => 'kk_hilang_rusak',
        'persyaratan'  => [
            'Surat kehilangan dari kepolisian (jika hilang) atau KK yang rusak',
            'KTP',
            'Fotokopi kartu izin tinggal tetap (untuk Orang Asing)',
        ],
        'penjelasan'   => [
            'Penduduk mengisi F.1.02 dan tidak perlu melampirkan fotokopi KTP-el <a href="'.route('unduh-formulir').'" class="text-blue-600 font-bold hover:underline ml-1" target="_blank"><i class="fas fa-download mr-1"></i>Unduh di Sini</a>',
            'Penduduk menyerahkan dokumen KK yang rusak/surat keterangan kehilangan dari kepolisian'
        ],
        'fields'       => [
            ['name' => 'layanan_id',       'value' => '7',  'type' => 'hidden'],
            
            ['type' => 'heading', 'label' => 'Informasi Pengajuan'],
            ['name' => 'nomor_antrian', 'label' => 'Nomor Antrian (Opsional)', 'placeholder' => 'Nomor Antrian', 'type' => 'text', 'required' => false],
            
            ['type' => 'heading', 'label' => 'Data Pemohon'],
            ['name' => 'nama', 'label' => 'Nama Pemohon',   'placeholder' => 'Nama sesuai KTP',           'type' => 'text'],
            ['name' => 'nik',  'label' => 'NIK Pemohon',    'placeholder' => '16 digit NIK',              'type' => 'text'],
            ['name' => 'alamat', 'label' => 'Alamat',   'placeholder' => 'Alamat Lengkap',           'type' => 'textarea'],
        ],
        'files' => [
            ['name' => 'suket_hilang_rusak', 'label' => 'Surat Kehilangan Kepolisian / Foto KK Rusak'],
            ['name' => 'fotokopi_ktp', 'label' => 'Scan/Foto KTP Asli'],
            ['name' => 'fotokopi_izin_tinggal', 'label' => 'Fotokopi kartu izin tinggal tetap (untuk OA)','required'=> false]
        ],
    ],

    8 => [
        'icon'         => 'fa-people-arrows',
        'color'        => 'blue',
        'id'           => 'pisah_kk',
        'persyaratan'  => [
            'KK lama',
            'Berumur sekurang-kurangnya 17 (tujuh belas) tahun atau sudah kawin.',
        ],
        'penjelasan'   => [
            'Penduduk mengisi F-1.02 <a href="'.route('unduh-formulir').'" class="text-blue-600 font-bold hover:underline ml-1" target="_blank"><i class="fas fa-download mr-1"></i>Unduh di Sini</a>'',
            'Penduduk melampirkan fotokopi buku nikah atau akta perceraian (jika disebabkan pernikahan atau perceraian)',
            'Penduduk melampirkan KK lama',
        ],
        'fields'       => [
            ['name' => 'layanan_id',    'value' => '8',  'type' => 'hidden'],
            
            ['type' => 'heading', 'label' => 'Informasi Pengajuan'],
            ['name' => 'nomor_antrian', 'label' => 'Nomor Antrian (Opsional)', 'placeholder' => 'Nomor Antrian', 'type' => 'text', 'required' => false],
            
            ['type' => 'heading', 'label' => 'Data Kepala KK Baru'],
            ['name' => 'nama',          'label' => 'Nama Kepala KK Baru', 'placeholder' => 'Nama sesuai KTP', 'type' => 'text'],
            ['name' => 'nik',           'label' => 'NIK Kepala KK Baru', 'placeholder' => '16 digit NIK', 'type' => 'text'],
            ['name' => 'alamat',        'label' => 'Alamat Baru', 'placeholder' => 'Masukkan alamat domisili baru', 'type' => 'textarea'],
        ],
        'files' => [
            ['name' => 'formulir_f102', 'label' => 'Formulir F1.02 yang Telah Diisi'],
            ['name' => 'fotokopi_buku_nikah', 'label' => 'Buku nikah / akta cerai (Jika karena pernikahan/perceraian)', 'required'=> false],
            ['name' => 'kk_lama', 'label' => 'Scan/Foto Asli KK Lama'],
        ],
    ],

    // AKTE KELAHIRAN 
    2 => [
        'icon'         => 'fa-baby',
        'color'        => 'green',
        'id'           => 'akte_kelahiran',
        'persyaratan'  => [
            'Formulir F-2.01 (Wajib diisi)',
            'Surat keterangan kelahiran dari rumah sakit/Puskesmas/bidan/kepala desa.',
            'Buku nikah/kutipan akta perkawinan orang tua',
            'KK dan KTP orang tua',
        ],
        'penjelasan'   => [
            'Mengisi formulir F-2.01',
            'Untuk pelayanan online/daring, persyaratan yang discan/ difoto untuk diunggah harus aslinya',
        ],
        'fields'       => [
            ['name' => 'layanan_id',       'value' => '2',  'type' => 'hidden'],
            
            ['type' => 'heading', 'label' => 'Informasi Registrasi'],
            ['name' => 'nomor_antrian', 'label' => 'Nomor Antrian (Opsional)', 'placeholder' => 'Masukkan Nomor Antrian',   'type' => 'text', 'required' => false],

            ['type' => 'heading', 'label' => 'Data Pelapor'],
            ['name' => 'nama_pelapor', 'label' => 'Nama Pelapor','placeholder' => 'Masukkan Nama Pelapor','type' => 'text'],
            ['name' => 'nik_pelapor','label' => 'NIK Pelapor','placeholder' => '16 digit NIK','type' => 'text'],
            ['name' => 'nomor_dokumen','label' => 'Nomor Dokumen Perjalanan (Opsional)', 'placeholder' => 'Hanya untuk WNA', 'type' => 'text', 'required' => false],
            ['name' => 'nomor_kk','label' => 'Nomor Kartu Keluarga', 'placeholder' => '16 digit Nomor KK', 'type' => 'text'],
            ['name' => 'kewarganegaraan_pelapor','label' => 'Kewarganegaraan', 'placeholder' => 'Misal: WNI / WNA', 'type' => 'text'],

            ['type' => 'heading', 'label' => 'Data Ayah'],
            ['name' => 'nama_ayah','label' => 'Nama Ayah', 'placeholder' => 'Nama Ayah', 'type' => 'text'],
            ['name' => 'nik_ayah','label' => 'NIK Ayah', 'placeholder' => '16 digit NIK', 'type' => 'text'],
            ['name' => 'tempat_lahir_ayah','label' => 'Tempat Lahir Ayah', 'placeholder' => 'Masukkan Kota/Kab', 'type' => 'text'],
            ['name' => 'tanggal_lahir_ayah','label' => 'Tanggal Lahir Ayah', 'placeholder' => '', 'type' => 'date'],
            ['name' => 'kewarganegaraan_ayah','label' => 'Kewarganegaraan Ayah', 'placeholder' => 'Misal: WNI', 'type' => 'text'],
            
            ['type' => 'heading', 'label' => 'Data Ibu'],
            ['name' => 'nama_ibu','label' => 'Nama Ibu', 'placeholder' => 'Nama Ibu', 'type' => 'text'],
            ['name' => 'nik_ibu','label' => 'NIK Ibu', 'placeholder' => '16 digit NIK', 'type' => 'text'],
            ['name' => 'tempat_lahir_ibu','label' => 'Tempat Lahir Ibu', 'placeholder' => 'Masukkan Kota/Kab', 'type' => 'text'],
            ['name' => 'tanggal_lahir_ibu','label' => 'Tanggal Lahir Ibu', 'placeholder' => '', 'type' => 'date'],
            ['name' => 'kewarganegaraan_ibu','label' => 'Kewarganegaraan Ibu', 'placeholder' => 'Misal: WNI', 'type' => 'text'],

            ['type' => 'heading', 'label' => 'Data Anak (Bayi)'],
            ['name' => 'nama_anak','label' => 'Nama Anak', 'placeholder' => 'Nama Anak Lengkap', 'type' => 'text'],
            ['name' => 'jenis_kelamin','label' => 'Jenis Kelamin Anak', 'type' => 'select', 'options' => ['Laki-laki', 'Perempuan']],
            ['name' => 'tempat_dilahirkan','label' => 'Tempat Dilahirkan', 'placeholder' => 'Mis: RS/RB, Puskesmas, Rumah', 'type' => 'text'],
            ['name' => 'tempat_kelahiran','label' => 'Kota/Kab Kelahiran', 'placeholder' => 'Mis: Toba', 'type' => 'text'],
            ['name' => 'hari_tanggal_lahir','label' => 'Hari/Tanggal Lahir', 'placeholder' => '', 'type' => 'date'],
            ['name' => 'pukul','label' => 'Pukul Lahir Anak', 'placeholder' => 'Mis: 08:30', 'type' => 'time'],
            ['name' => 'jenis_kelahiran','label' => 'Jenis Kelahiran', 'type' => 'select', 'options' => ['Tunggal', 'Kembar 2', 'Kembar 3', 'Lainnya']],
            ['name' => 'kelahiran_ke','label' => 'Anak Keberapa?', 'placeholder' => 'Mis: 1', 'type' => 'number'],
            ['name' => 'penolong','label' => 'Penolong Kelahiran', 'placeholder' => 'Mis: Dokter, Bidan, Dukun', 'type' => 'text'],
            ['name' => 'berat_bayi','label' => 'Berat Bayi (Kg)', 'placeholder' => 'Mis: 3.5', 'type' => 'text'],
            ['name' => 'panjang_bayi','label' => 'Panjang Bayi (cm)', 'placeholder' => 'Mis: 50', 'type' => 'number'],

            ['type' => 'heading', 'label' => 'Data Saksi (Opsional)'],
            ['name' => 'nama_saksi1','label' => 'Nama Saksi 1', 'placeholder' => 'Nama Saksi 1', 'type' => 'text', 'required' => false],
            ['name' => 'nik_saksi1','label' => 'NIK Saksi 1', 'placeholder' => '16 digit NIK', 'type' => 'text', 'required' => false],
            ['name' => 'nomor_kk_saksi1','label' => 'Nomor KK Saksi 1', 'placeholder' => '16 digit Nomor KK', 'type' => 'text', 'required' => false],
            ['name' => 'kewarganegaraan_saksi1','label' => 'Kewarganegaraan Saksi 1', 'placeholder' => 'Misal: WNI', 'type' => 'text', 'required' => false],
            
            ['name' => 'nama_saksi2','label' => 'Nama Saksi 2', 'placeholder' => 'Nama Saksi 2', 'type' => 'text', 'required' => false],
            ['name' => 'nik_saksi2','label' => 'NIK Saksi 2', 'placeholder' => '16 digit NIK', 'type' => 'text', 'required' => false],
            ['name' => 'nomor_kk_saksi2','label' => 'Nomor KK Saksi 2', 'placeholder' => '16 digit Nomor KK', 'type' => 'text', 'required' => false],
            ['name' => 'kewarganegaraan_saksi2','label' => 'Kewarganegaraan Saksi 2', 'placeholder' => 'Misal: WNI', 'type' => 'text', 'required' => false],
        ],
        'files' => [
            ['name' => 'file_surat_lahir', 'label' => 'Surat Keterangan Lahir (RS/Bidan/Desa)'],
            ['name' => 'file_buku_nikah', 'label' => 'Buku Nikah / Akta Perkawinan'],
            ['name' => 'file_kk', 'label' => 'Kartu Keluarga Orang Tua (Asli/Scan)'],
            ['name' => 'file_sptjm_kelahiran', 'label' => 'SPTJM Data Kelahiran (F-2.03) - Jika tidak ada surat lahir','required'=>false],
            ['name' => 'file_sptjm_pasutri', 'label' => 'SPTJM Pasangan Suami Istri (F-2.04) - Jika tidak ada buku nikah','required'=>false],
            ['name' => 'file_berita_acara_polisi', 'label' => 'Berita Acara Kepolisian - Jika tidak diketahui ortunya','required'=>false],
        ],
    ],

    // AKTE KEMATIAN 
    3 => [
            'icon' => 'fa-user-times',
            'color' => 'blue',
            'id' => 'akte_kematian',
            'persyaratan' => [
                'Formulir F-2.01 (Wajib diisi) <a href="'.route('unduh-formulir').'" class="text-blue-600 font-bold hover:underline ml-1" target="_blank"><i class="fas fa-download mr-1"></i>Unduh di Sini</a>',
                'Fotokopi surat kematian dari dokter atau kepala desa/lurah',
                'Fotokopi KTP & KK Pemohon.',
                'Fotokopi KTP yang meninggal dunia.',
                'Fotokopi KTP Saksi.'
            ],
            'penjelasan' => [
                'WNI melampirkan fotokopi KK untuk verifikasi data.',
                'Untuk pelayanan online/Daring, persyaratan yang discan/ difoto untuk diunggah harus aslinya.',
                'Seluruh informasi terkait jenazah dan saksi dilampirkan melalui isian Formulir F-2.01.', 
            ],
            'template_url' => '#',
            'fields' => [ 
                ['name' => 'layanan_id', 'value' => '3', 'type' => 'hidden'],
                
                ['type' => 'heading', 'label' => 'Informasi Pengajuan'],
                ['name' => 'nomor_antrian', 'label' => 'Nomor Antrian', 'placeholder' => 'Masukkan Nomor Antrian', 'type' => 'text', 'required' => false],
                
                
                ['type' => 'heading', 'label' => 'Data Pemohon'],
                ['name' => 'nik_pemohon', 'label' => 'NIK Pemohon', 'placeholder' => '16 digit NIK Pemohon', 'type' => 'text'],
                ['name' => 'nomor_kk_pemohon', 'label' => 'Nomor KK Pemohon', 'placeholder' => '16 digit Nomor KK', 'type' => 'text'],
                ['name' => 'nama_pemohon', 'label' => 'Nama Lengkap Pemohon', 'placeholder' => 'Masukkan Nama Lengkap Pemohon', 'type' => 'text'],
                ['name' => 'alamat_pemohon', 'label' => 'Alamat Pemohon', 'placeholder' => 'Alamat Domisili', 'type' => 'textarea'],
                ['name' => 'hubungan_pemohon', 'label' => 'Hubungan dengan Jenazah', 'placeholder' => 'Contoh: Anak / Suami / Istri / Ketua RT', 'type' => 'text'],
            ],
            
            'files' => [
                ['name' => 'formulir_f201', 'label' => 'Scan/Foto Asli Formulir F-2.01 yang telah diisi'],
                ['name' => 'surat_keterangan_kematian', 'label' => 'Scan/Foto Asli Surat Keterangan Kematian (Dokter/Kades)'],
                ['name' => 'ktp_pemohon', 'label' => 'Scan/Foto Asli KTP Pemohon'],
                ['name' => 'kartu_keluarga_pemohon', 'label' => 'Scan/Foto Asli KK Pemohon'],
                ['name' => 'ktp_almarhum', 'label' => 'Scan/Foto Asli KTP Almarhum '],
                ['name' => 'ktp_saksi1', 'label' => 'Scan/Foto Asli KTP Saksi 1 '],
                ['name' => 'ktp_saksi2', 'label' => 'Scan/Foto Asli KTP Saksi 2 '],
            ],
    ],

    // LAHIR MATI
    4 => [
            'icon' => 'fa-exclamation-triangle',
            'color' => 'blue',
            'id' => 'lahir_mati',
            'persyaratan' => [
                'Formulir F-2.01 (Wajib diisi) <a href="'.route('unduh-formulir').'" class="text-blue-600 font-bold hover:underline ml-1" target="_blank"><i class="fas fa-download mr-1"></i>Unduh di Sini</a>',
                'Pemohon Merupakan Orang Tua Kandung dari Bayi yang Lahir Mati.',
                'Fotokopi surat keterangan lahir mati (RS/Bidan/Kades).',
                'Fotokopi KTP & KK Orang Tua.',
                'Fotokopi KTP Saksi.',
            ],
            'penjelasan' => [
                'WNI melampirkan fotokopi KK untuk verifikasi data.',
                'Untuk pelayanan online/Daring, persyaratan yang discan/ difoto untuk diunggah harus aslinya.',
                'Seluruh informasi terkait jenazah (bayi) dan orang tua dilampirkan melalui isian Formulir F-2.01.',
            ],
            'template_url' => '#',
            'fields' => [
                ['name' => 'layanan_id', 'value' => '4', 'type' => 'hidden'],
                
                ['type' => 'heading', 'label' => 'Informasi Pengajuan'],
                ['name' => 'nomor_antrian', 'label' => 'Nomor Antrian', 'placeholder' => 'Masukkan Nomor Antrian', 'type' => 'text', 'required' => false],
                
                ['type' => 'heading', 'label' => 'Data Pemohon'],
                ['name' => 'nik_pemohon', 'label' => 'NIK Pemohon', 'placeholder' => '16 digit NIK Pemohon', 'type' => 'text'],
                ['name' => 'nomor_kk_pemohon', 'label' => 'Nomor KK Pemohon', 'placeholder' => '16 digit Nomor KK', 'type' => 'text'],
                ['name' => 'nama_pemohon', 'label' => 'Nama Lengkap Pemohon', 'placeholder' => 'Masukkan Nama Lengkap Pemohon', 'type' => 'text'],
                ['name' => 'alamat_pemohon', 'label' => 'Alamat Pemohon', 'placeholder' => 'Alamat Domisili', 'type' => 'textarea'],
                ['name' => 'hubungan_pemohon', 'label' => 'Hubungan dengan Jenazah Bayi', 'placeholder' => 'Contoh: Ayah / Ibu / Bidan', 'type' => 'text'],
            ],
            'files' => [
                ['name' => 'formulir_f201', 'label' => 'Scan/Foto Asli Formulir F-2.01 yang telah diisi'],
                ['name' => 'surat_keterangan_lahir_mati', 'label' => 'Scan/Foto Asli Surat Ket. Lahir Mati (RS/Bidan/Kades)'],
                ['name' => 'ktp_pemohon', 'label' => 'Scan/Foto Asli KTP Pemohon'],
                ['name' => 'kartu_keluarga_pemohon', 'label' => 'Scan/Foto Asli KK Pemohon'],
                ['name' => 'ktp_saksi1', 'label' => 'Scan/Foto Asli KTP Saksi 1 '],
                ['name' => 'ktp_saksi2', 'label' => 'Scan/Foto Asli KTP Saksi 2 '],
            ],
        ],

    // PERKAWINAN
    5 => [
            'icon' => 'fa-ring',
            'color' => 'blue',
            'id' => 'layanan-pernikahan',
            'persyaratan' => [
                'Kutipan akta kelahiran masing-masing pihak',
                'Surat keterangan belum pernah kawin dari Kepala Desa/Lurah',
                'KTP dan KK kedua calon mempelai',
                'Pas foto berdampingan 4x6 sebanyak 5 lembar',
            ],
            'penjelasan' => [
                'Penduduk mengisi formulir permohonan pencatatan perkawinan',
                'Melampirkan semua persyaratan yang ditentukan',
                'Dinas menerbitkan Kutipan Akta Perkawinan',
            ],
            'template_url' => '#',
            'fields' => [
                ['name' => 'layanan_id', 'value' => '5', 'type' => 'hidden'],
                
                ['type' => 'heading', 'label' => 'Informasi Pendaftaran'],
                ['name' => 'nomor_antrian', 'label' => 'Kode Antrian', 'type' => 'text', 'placeholder' => 'Masukkan kode antrian'],
                ['name' => 'tanggal_perkawinan', 'label' => 'Tanggal Perkawinan', 'type' => 'date'],
                
                ['type' => 'heading', 'label' => 'Data Mempelai Pria (Suami)'],
                ['name' => 'nama_lengkap_suami', 'label' => 'Nama Suami Lengkap', 'type' => 'text', 'placeholder' => 'Nama sesuai KTP'],
                ['name' => 'nik_suami', 'label' => 'NIK Suami', 'type' => 'text', 'placeholder' => '16 digit NIK Suami'],
                
                ['type' => 'heading', 'label' => 'Data Mempelai Wanita (Istri)'],
                ['name' => 'nama_lengkap_istri', 'label' => 'Nama Istri Lengkap', 'type' => 'text', 'placeholder' => 'Nama sesuai KTP'],
                ['name' => 'nik_istri', 'label' => 'NIK Istri', 'type' => 'text', 'placeholder' => '16 digit NIK Istri'],
            ],
            'files' => [
                ['name' => 'akta_pernikahan', 'label' => 'Upload Akta Pernikahan (Opsional)', 'required' => false],
            ],
        ],
];

$kategoriLayanan = [
    'Kartu Keluarga (KK)' => [
        'icon'    => 'fa-id-card',
        'color'   => 'blue',
        'layanan' => [1, 6, 7, 8],
    ],
    'Akte Kelahiran' => [
        'icon'    => 'fa-baby',
        'color'   => 'green',
        'layanan' => [2],
    ],
    'Akte Kematian' => [
        'icon'    => 'fa-file-medical',
        'color'   => 'orange',
        'layanan' => [3, 4],
    ],
    'Akte Perkawinan' => [
        'icon'    => 'fa-ring',
        'color'   => 'purple',
        'layanan' => [5],
    ],
];

$colorMap = [
    'blue'   => ['bg' => '#EFF6FF', 'text' => '#1D4ED8', 'border' => '#93C5FD', 'badge_bg' => '#DBEAFE', 'badge_text' => '#1E40AF'],
    'green'  => ['bg' => '#F0FDF4', 'text' => '#15803D', 'border' => '#86EFAC', 'badge_bg' => '#DCFCE7', 'badge_text' => '#166534'],
    'orange' => ['bg' => '#FFF7ED', 'text' => '#C2410C', 'border' => '#FDB97D', 'badge_bg' => '#FFEDD5', 'badge_text' => '#9A3412'],
    'purple' => ['bg' => '#FAF5FF', 'text' => '#7E22CE', 'border' => '#D8B4FE', 'badge_bg' => '#F3E8FF', 'badge_text' => '#6B21A8'],
    'red'    => ['bg' => '#FFF1F2', 'text' => '#BE123C', 'border' => '#FDA4AF', 'badge_bg' => '#FFE4E6', 'badge_text' => '#9F1239'],
];

$layananById = \App\Models\Layanan_Model::whereIn('layanan_id', collect($kategoriLayanan)->pluck('layanan')->flatten()->toArray())->get()->keyBy('layanan_id');
@endphp
<main class="pt-0">
    <div id="pageLoading" class="page-loading">
        <div class="loading-logo bg-white rounded-2xl shadow-2xl overflow-hidden flex items-center justify-center">
            <img src="{{ asset('images/logo_toba.jpeg') }}" alt="Logo Kabupaten Toba" class="w-full h-full object-contain p-3">
        </div>
        <div class="loading-spinner"></div>
        <div class="loading-text">Disdukcapil Kabupaten Toba</div>
        <div class="loading-subtext">Memuat layanan mandiri...</div>
        <div class="loading-dots"><span></span><span></span><span></span></div>
    </div>
    <section class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-cyan-800 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm text-sm font-medium mb-4">
                    <i class="fas fa-rocket"></i> Layanan Mandiri
                </div>
                <h1 class="text-3xl md:text-4xl font-extrabold mb-4">Pilih Jenis Layanan</h1>
                <p class="text-base text-blue-100 mb-6">
                    Pilih jenis layanan yang Anda butuhkan dan isi form pendaftaran secara online.
                </p>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="#f9fafb"/>
            </svg>
        </div>
    </section>
    <section class="py-12 bg-gray-50 -mt-6 relative z-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-10 bg-blue-50 border border-blue-200 rounded-2xl p-5 reveal shadow-sm">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-blue-200">
                        <i class="fas fa-info-circle text-xl text-white"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-base mb-1">Panduan Pengajuan</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Silakan pilih kategori layanan, lalu klik layanan yang sesuai dengan kebutuhan Anda.
                            Pastikan dokumen pendukung sudah disiapkan sebelum mengisi formulir.
                        </p>
                    </div>
                </div>
            </div>
            @foreach($kategoriLayanan as $namaKategori => $kategoriConfig)
                @php
                    $c      = $colorMap[$kategoriConfig['color']] ?? $colorMap['blue'];
                    $delay  = $loop->index * 80;
                @endphp
                <div class="mb-10 reveal" style="animation-delay: {{ $delay }}ms">
                    {{-- Header Kategori --}}
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                             style="background: {{ $c['badge_bg'] }}">
                            <i class="fas {{ $kategoriConfig['icon'] }} text-base" style="color: {{ $c['text'] }}"></i>
                        </div>
                        <h2 class="text-lg font-bold text-gray-800">{{ $namaKategori }}</h2>
                        <div class="flex-1 h-px" style="background: {{ $c['border'] }}"></div>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        @foreach($kategoriConfig['layanan'] as $lid)
                            @php
                                $layanan = $layananById[$lid] ?? null;
                                $config  = $serviceConfig[$lid] ?? null;
                                if (!$layanan || !$config) continue;
                                $configJson = json_encode([
                                    'id'           => $config['id'],
                                    'icon'         => $config['icon'],
                                    'color'        => $config['color'],
                                    'persyaratan'  => $config['persyaratan'],
                                    'penjelasan'   => $config['penjelasan'],
                                    'fields'       => $config['fields'],
                                    'files'        => $config['files'],
                                ]);
                                $serviceName = $layanan->nama_layanan;
                                $shortDesc   = $layanan->keterangan ?? str_replace('Penerbitan ', '', $serviceName);
                            @endphp
                            <button onclick='openServiceModal({{ $configJson }}, {{ json_encode($serviceName) }})'
                                class="group bg-white rounded-2xl p-5 text-left hover:shadow-xl transition-all duration-300
                                    hover:-translate-y-1 border-2 border-gray-100 flex flex-col min-h-[160px] 
                                    w-full sm:w-[220px] lg:w-[200px] xl:w-[210px]" 
                                style="--hover-border: {{ $c['border'] }}"
                                    onmouseover="this.style.borderColor='{{ $c['border'] }}'"
                                    onmouseout="this.style.borderColor='#F3F4F6'">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-3 transition-all duration-300 flex-shrink-0"
                                     style="background: {{ $c['badge_bg'] }}"
                                     data-icon-wrap>
                                    <i class="fas {{ $config['icon'] }} text-xl transition-colors duration-300"
                                       style="color: {{ $c['text'] }}"
                                       data-icon></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-gray-800 text-sm mb-1 leading-tight line-clamp-2">{{ $serviceName }}</h3>
                                    <p class="text-xs text-gray-400 leading-relaxed line-clamp-2">{{ $shortDesc }}</p>
                                </div>
                                <div class="mt-3">
                                    <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold transition-all duration-300"
                                          style="background: {{ $c['badge_bg'] }}; color: {{ $c['badge_text'] }}">
                                        <i class="fas fa-plus text-[10px]"></i> Pilih
                                    </span>
                                </div>
                            </button>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    <section class="py-12 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10 reveal">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Keuntungan Layanan Mandiri</h2>
            </div>
            <div class="grid md:grid-cols-3 gap-6 reveal">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 text-center border border-blue-200">
                    <div class="w-14 h-14 bg-blue-600 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-clock text-2xl text-white"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2">Hemat Waktu</h3>
                    <p class="text-gray-600 text-sm">Tanpa antri di kantor dukcapil</p>
                </div>
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 text-center border border-purple-200">
                    <div class="w-14 h-14 bg-purple-600 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-home text-2xl text-white"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2">Dari Mana Saja</h3>
                    <p class="text-gray-600 text-sm">Proses online 24 jam</p>
                </div>
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 text-center border border-green-200">
                    <div class="w-14 h-14 bg-green-600 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-check-circle text-2xl text-white"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2">Pantau Status</h3>
                    <p class="text-gray-600 text-sm">Update status secara real-time</p>
                </div>
            </div>
        </div>
    </section>
</main>
<div id="serviceModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full max-h-[92vh] overflow-y-auto transform transition-all relative z-10" id="modalContent">
            <div id="modalHeader" class="sticky top-0 z-20 bg-white p-5 border-b border-gray-100 rounded-t-3xl">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div id="modalIcon" class="w-11 h-11 rounded-xl flex items-center justify-center"></div>
                        <div>
                            <h3 id="modalTitle" class="text-lg font-bold text-gray-800"></h3>
                            <p id="modalStepLabel" class="text-xs text-gray-400 font-medium"></p>
                        </div>
                    </div>
                    <button onclick="closeModal()" class="w-9 h-9 rounded-xl flex items-center justify-center bg-gray-100 hover:bg-gray-200 transition flex-shrink-0">
                        <i class="fas fa-times text-gray-500 text-sm"></i>
                    </button>
                </div>
                <div class="flex items-center gap-1">
                    @foreach(['Informasi','Data','Berkas','Verifikasi','Konfirmasi'] as $i => $stepName)
                    <div class="flex-1 flex flex-col items-center">
                        <div class="step-indicator w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold mb-1 transition-all duration-300"
                             id="stepDot{{ $i+1 }}" data-step="{{ $i+1 }}">{{ $i+1 }}</div>
                        <span class="text-[9px] font-semibold step-label text-gray-400" id="stepLabel{{ $i+1 }}">{{ $stepName }}</span>
                    </div>
                    @if($i < 4)
                    <div class="flex-1 h-0.5 bg-gray-200 rounded mb-5" id="stepLine{{ $i+1 }}"></div>
                    @endif
                    @endforeach
                </div>
            </div>
            @if($errors->any())
            <div class="mx-5 mt-4 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl">
                <div class="flex items-center mb-2">
                    <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                    <span class="text-red-800 font-bold text-sm">Terjadi Kesalahan Validasi:</span>
                </div>
                <ul class="list-disc list-inside text-xs text-red-600 space-y-1">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
            @endif
            <form id="serviceForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div id="step1" class="step-content p-5 space-y-5">
                    <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fas fa-info-circle text-blue-600"></i>
                            <h4 class="font-bold text-blue-800 text-sm">Informasi Layanan</h4>
                        </div>
                        <p id="infoLayanan" class="text-sm text-blue-700 leading-relaxed"></p>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-6 h-6 bg-orange-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-list-check text-orange-600 text-xs"></i>
                            </div>
                            <h4 class="font-bold text-gray-800 text-sm">Persyaratan</h4>
                        </div>
                        <ul id="listPersyaratan" class="space-y-2"></ul>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-6 h-6 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-route text-green-600 text-xs"></i>
                            </div>
                            <h4 class="font-bold text-gray-800 text-sm">Alur Pengajuan</h4>
                        </div>
                        <ol id="listPenjelasan" class="space-y-2"></ol>
                    </div>
                    <button type="button" onclick="goToStep(2)"
                            class="w-full py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-bold hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg flex items-center justify-center gap-2">
                        Selanjutnya <i class="fas fa-arrow-right text-sm"></i>
                    </button>
                </div>
                <div id="step2" class="step-content p-5 space-y-4 hidden">
                    <p class="text-sm text-gray-500 mb-1">Lengkapi data Anda dengan benar sesuai dokumen resmi.</p>
                    <div id="formFields" class="grid grid-cols-1 md:grid-cols-2 gap-4"></div>
                    <div class="flex gap-3 mt-6 pt-4 border-t border-gray-100">
                        <button type="button" onclick="goToStep(1)"
                                class="flex-1 py-3 border-2 border-gray-200 text-gray-600 rounded-xl font-bold hover:bg-gray-50 transition flex items-center justify-center gap-2">
                            <i class="fas fa-arrow-left text-sm"></i> Kembali
                        </button>
                        <button type="button" onclick="validateAndGoStep3()"
                                class="flex-1 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-bold hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg flex items-center justify-center gap-2">
                            Selanjutnya <i class="fas fa-arrow-right text-sm"></i>
                        </button>
                    </div>
                </div>
                <div id="step3" class="step-content p-5 space-y-4 hidden">
                    <p class="text-sm text-gray-500 mb-1">Upload berkas persyaratan dalam format <strong>PDF</strong>. Pastikan dokumen terbaca dengan jelas.</p>
                    <div id="fileFields" class="space-y-4"></div>
                    <div class="flex gap-3 mt-6 pt-4 border-t border-gray-100">
                        <button type="button" onclick="goToStep(2)"
                                class="flex-1 py-3 border-2 border-gray-200 text-gray-600 rounded-xl font-bold hover:bg-gray-50 transition flex items-center justify-center gap-2">
                            <i class="fas fa-arrow-left text-sm"></i> Kembali
                        </button>
                        <button type="button" onclick="goToStep(4)"
                                class="flex-1 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-bold hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg flex items-center justify-center gap-2">
                            Selanjutnya <i class="fas fa-arrow-right text-sm"></i>
                        </button>
                    </div>
                </div>
                <div id="step4" class="step-content p-5 space-y-4 hidden">
                    <h3 class="font-bold text-lg text-gray-800">Verifikasi Wajah</h3>
                    <p class="text-sm text-gray-500">
                        Kedipkan mata <strong>2 kali</strong> di depan kamera untuk membuktikan Anda bukan robot.
                    </p>
                    <div class="relative rounded-2xl overflow-hidden border-2 border-gray-200 bg-black">
                        <video id="video" autoplay playsinline muted class class="w-full rounded-xl" style="max-height:260px; object-fit:cover;"></video>
                        <canvas id="canvas" class="hidden"></canvas>
                        <div id="liveness-overlay"
                            class="absolute bottom-0 left-0 right-0 bg-black/50 text-white text-center py-2 text-sm font-semibold">
                            Tekan "Mulai Verifikasi" untuk mengaktifkan kamera
                        </div>
                    </div>
                    <div class="flex items-center gap-3 bg-blue-50 border border-blue-200 rounded-xl px-4 py-3">
                        <div class="flex gap-2">
                            <span id="blink-dot-1"
                                class="w-8 h-8 rounded-full border-2 border-gray-300 flex items-center justify-center text-xs font-bold text-gray-400">1</span>
                            <span id="blink-dot-2"
                                class="w-8 h-8 rounded-full border-2 border-gray-300 flex items-center justify-center text-xs font-bold text-gray-400">2</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-700">
                                Kedipan terdeteksi: <span id="blinkCount">0</span>/2
                            </p>
                            <p class="text-xs text-gray-400">Kedipkan secara natural, jangan terlalu cepat</p>
                        </div>
                    </div>
                    <input type="hidden" name="liveness_passed" id="liveness_passed" value="0">
                    <div id="liveness-error" class="hidden bg-red-50 border border-red-200 rounded-xl px-4 py-3 text-sm text-red-700"></div>
                    <div class="flex gap-3 pt-4 border-t border-gray-100">
                        <button type="button" onclick="goToStep(3); stopCamera();"
                                class="flex-1 py-3 border-2 border-gray-200 text-gray-600 rounded-xl font-bold hover:bg-gray-50 transition flex items-center justify-center gap-2">
                            <i class="fas fa-arrow-left text-sm"></i> Kembali
                        </button>
                        <button type="button" id="btnStartLiveness" onclick="startLiveness()"
                                class="flex-1 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-bold hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg flex items-center justify-center gap-2">
                            <i class="fas fa-camera text-sm"></i> Mulai Verifikasi
                        </button>
                    </div>
                </div>
                <div id="step5" class="step-content p-5 space-y-4 hidden">
                    <div class="bg-green-50 border border-green-200 rounded-2xl p-4 text-center">
                        <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                        </div>
                        <h4 class="font-bold text-green-800 text-base mb-1">Data Siap Dikirim</h4>
                        <p class="text-green-700 text-sm">Pastikan semua data dan berkas yang Anda isi sudah benar sebelum mengirim pengajuan.</p>
                    </div>
                    <div class="bg-gray-50 border border-gray-200 rounded-2xl p-4">
                        <h5 class="font-bold text-gray-700 text-sm mb-3 flex items-center gap-2">
                            <i class="fas fa-clipboard-list text-blue-500"></i> Ringkasan Pengajuan
                        </h5>
                        <div id="summaryData" class="space-y-2 text-sm text-gray-600"></div>
                    </div>
                    <div class="flex gap-3 mt-6 pt-4 border-t border-gray-100">
                        <button type="button" onclick="goToStep(4)"
                                class="flex-1 py-3 border-2 border-gray-200 text-gray-600 rounded-xl font-bold hover:bg-gray-50 transition flex items-center justify-center gap-2">
                            <i class="fas fa-arrow-left text-sm"></i> Kembali
                        </button>
                        <button type="submit" id="btnSubmit"
                                class="flex-1 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl font-bold hover:from-green-700 hover:to-green-800 transition-all shadow-lg flex items-center justify-center gap-2">
                            <i class="fas fa-paper-plane text-sm"></i> Kirim Pengajuan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@push('styles')
<style>
    .reveal { opacity: 0; transform: translateY(30px); transition: all 0.6s ease-out; }
    .reveal.active { opacity: 1; transform: translateY(0); }
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .step-indicator { background: #e5e7eb; color: #9ca3af; }
    .step-indicator.active { background: #2563eb; color: #fff; box-shadow: 0 0 0 3px #bfdbfe; }
    .step-indicator.done { background: #16a34a; color: #fff; }
    .step-label.active { color: #2563eb !important; }
    .step-label.done { color: #16a34a !important; }
    #stepLine1.done, #stepLine2.done, #stepLine3.done { background: #16a34a; }
    #stepLine4.done { background: #16a34a; }
    .step-content { animation: fadeSlide 0.3s ease-out; }
    @keyframes fadeSlide { from { opacity: 0; transform: translateX(18px); } to { opacity: 1; transform: translateX(0); } }
    .form-input {
        width: 100%; padding: 0.6rem 1rem;
        border: 2px solid #e5e7eb; border-radius: 0.75rem;
        font-size: 0.875rem; transition: border-color 0.2s;
        outline: none; background: #fff;
    }
    .form-input:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px #dbeafe; }
</style>
@endpush
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@mediapipe/face_mesh/face_mesh.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js" crossorigin="anonymous"></script>
<script>
let currentStep      = 1;
let currentConfig    = {};
let currentServiceName = '';
let mpCamera         = null;   
let faceMeshInstance = null;
let blinkCount       = 0;
let eyeClosed        = false;  
let livenessStarted  = false;

const BLINK_THRESHOLD = 0.25;  
const BLINK_TARGET    = 2;     
const routeMap = {
    'kk':              "{{ route('kk.store') }}",
    'akte_kelahiran':  "{{ route('aktelahir.store') }}",
    'ganti_kepala_kk': "{{ route('kk.store.gantikepalakk') }}",
    'kk_hilang_rusak': "{{ route('kk.store.hilangrusak') }}",
    'pisah_kk':        "{{ route('kk.store.pisahkk') }}",
    'akte_kematian':   "{{ route('akte-kematian.store') }}",
    'lahir_mati':      "{{ route('lahir-mati.store') }}"
};
function reveal() {
    document.querySelectorAll('.reveal').forEach(el => {
        if (el.getBoundingClientRect().top < window.innerHeight - 50)
            el.classList.add('active');
    });
}
window.addEventListener('scroll', reveal);
window.addEventListener('load', reveal);
function openServiceModal(config, serviceName) {
    currentConfig      = config;
    currentServiceName = serviceName;
    document.getElementById('modalTitle').textContent = serviceName;
    const icon = document.getElementById('modalIcon');
    icon.style.background = getColorBadgeBg(config.color);
    icon.innerHTML = `<i class="fas ${config.icon} text-xl" style="color:${getColorText(config.color)}"></i>`;
    document.getElementById('serviceForm').action = routeMap[config.id] || '#';
    document.getElementById('infoLayanan').textContent =
        `Layanan ${serviceName} adalah layanan kependudukan yang dapat diajukan secara online melalui portal Disdukcapil Kabupaten Toba. Proses verifikasi dilakukan oleh petugas dalam 2–3 hari kerja.`;
    document.getElementById('listPersyaratan').innerHTML = config.persyaratan.map((p, i) => `
        <li class="flex items-start gap-3 bg-white border border-gray-100 rounded-xl p-3">
            <div class="w-5 h-5 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                <span class="text-orange-600 font-bold text-[10px]">${i+1}</span>
            </div>
            <span class="text-sm text-gray-700 leading-relaxed">${p}</span>
        </li>`).join('');
    document.getElementById('listPenjelasan').innerHTML = config.penjelasan.map((p, i) => `
        <li class="flex items-start gap-3">
            <div class="w-6 h-6 bg-green-600 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                <span class="text-white font-bold text-[10px]">${i+1}</span>
            </div>
            <span class="text-sm text-gray-700 leading-relaxed">${p}</span>
        </li>`).join('');
    const hiddenAndText = config.fields.filter(f => f.type !== 'file');
    document.getElementById('formFields').innerHTML = hiddenAndText.map(field => {
        if (field.type === 'hidden')
            return `<input type="hidden" name="${field.name}" value="${field.value}">`;
        
        if (field.type === 'heading') {
            return `
                <div class="col-span-1 md:col-span-2 mt-6 mb-2 border-b border-gray-200 pb-2">
                    <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wide">
                        ${field.label}
                    </h3>
                </div>
            `;
        }

        const fullWidth = field.type === 'textarea' ? 'md:col-span-2' : '';
        return `
            <div class="${fullWidth}">
                <label class="block text-xs font-semibold text-gray-600 mb-1">
                    ${field.label} <span class="text-red-400">*</span>
                </label>
                ${renderField(field)}
            </div>`;
    }).join('');
    document.getElementById('fileFields').innerHTML = config.files.map(file => `
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">
                ${file.label}
                ${file.required !== false
                    ? '<span class="text-red-400">*</span>'
                    : '<span class="text-gray-400 font-normal">(opsional)</span>'}
            </label>
            <label class="flex flex-col items-center justify-center w-full px-4 py-5
                          border-2 border-dashed border-gray-300 rounded-2xl bg-gray-50
                          hover:bg-blue-50 hover:border-blue-400 transition-all cursor-pointer">
                <i class="fas fa-file-pdf text-2xl text-gray-400 mb-2" id="icon-${file.name}"></i>
                <p class="text-sm font-semibold text-gray-600">Pilih File PDF</p>
                <p class="text-[10px] text-gray-400 mt-1 uppercase tracking-wider">Format: PDF</p>
                <input type="file" name="${file.name}" accept=".pdf"
                       ${file.required !== false ? 'required' : ''}
                       class="hidden" onchange="handleFileSelect(this,'${file.name}')">
            </label>
            <div id="name-${file.name}" class="mt-1.5 px-2 text-[11px] text-blue-600 font-medium hidden">
                <i class="fas fa-check-circle mr-1"></i><span class="file-label"></span>
            </div>
        </div>`).join('');
    resetLiveness();
    goToStep(1);
    document.getElementById('serviceModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
function getColorText(color) {
    const map = { blue:'#1D4ED8', green:'#15803D', orange:'#C2410C', purple:'#7E22CE', red:'#BE123C' };
    return map[color] || map.blue;
}
function getColorBadgeBg(color) {
    const map = { blue:'#DBEAFE', green:'#DCFCE7', orange:'#FFEDD5', purple:'#F3E8FF', red:'#FFE4E6' };
    return map[color] || map.blue;
}
function renderField(field) {
    const cls = 'form-input';
    let extraAttr = '';
    if (field.name.toLowerCase().includes('nik') || field.name.toLowerCase().includes('nomor_kk')) {
        extraAttr = `oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16);" maxlength="16"`;
    }
    
    if (field.type === 'textarea')
        return `<textarea name="${field.name}" placeholder="${field.placeholder||''}" class="${cls} h-24 resize-none" required></textarea>`;
    if (field.type === 'select')
        return `<select name="${field.name}" class="${cls}" required>
            <option value="">Pilih...</option>
            ${(field.options||[]).map(o=>`<option value="${o}">${o}</option>`).join('')}
        </select>`;
    return `<input type="${field.type}" name="${field.name}" placeholder="${field.placeholder||''}" class="${cls}" ${extraAttr} required>`;
}
function goToStep(step) {
    currentStep = step;
    document.querySelectorAll('.step-content').forEach(el => el.classList.add('hidden'));
    const active = document.getElementById('step' + step);
    if (active) {
        active.classList.remove('hidden');
        active.style.animation = 'none';
        active.offsetHeight;
        active.style.animation = '';
    }
    const labels = ['Informasi','Data','Berkas','Verifikasi','Konfirmasi'];
    for (let i = 1; i <= 5; i++) {
        const dot = document.getElementById('stepDot' + i);
        const lbl = document.getElementById('stepLabel' + i);
        dot.className = 'step-indicator w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold mb-1 transition-all duration-300';
        lbl.className = 'text-[9px] font-semibold step-label text-gray-400';
        if (i < step)        { dot.classList.add('done');   dot.innerHTML = '<i class="fas fa-check text-[10px]"></i>'; lbl.classList.add('done'); }
        else if (i === step) { dot.classList.add('active'); dot.textContent = i; lbl.classList.add('active'); }
        else                 { dot.textContent = i; }
        if (i < 4) {
            const line = document.getElementById('stepLine' + i);
            if (line) line.className = 'flex-1 h-0.5 rounded mb-5 transition-all duration-500 ' + (i < step ? 'bg-green-400' : 'bg-gray-200');
        }
    }
    document.getElementById('modalStepLabel').textContent = `Langkah ${step} dari 5 — ${labels[step-1]}`;
    document.getElementById('modalContent').scrollTop = 0;
    if (step === 5) buildSummary();
}
function validateAndGoStep3() {
    const inputs = document.getElementById('step2')
        .querySelectorAll('input[required],textarea[required],select[required],input[name*="nik"],input[name*="nomor_kk"]');
    let valid = true;
    let errMsg = 'Harap lengkapi semua data yang diperlukan.';
    inputs.forEach(input => {
        input.style.borderColor = '';
        let val = input.value.trim();
        let isReq = input.hasAttribute('required');
        if (isReq && !val) { 
            input.style.borderColor = '#ef4444'; 
            valid = false; 
        } 
        else if (val && (input.name.toLowerCase().includes('nik') || input.name.toLowerCase().includes('nomor_kk')) && val.length !== 16) {
            input.style.borderColor = '#ef4444';
            valid = false;
            let labelText = input.previousElementSibling ? input.previousElementSibling.innerText.replace('*','').trim() : 'Nomor';
            errMsg = `Isian <b>${labelText}</b> harus tepat 16 angka!`;
        }
    });
    if (!valid) { showToast(errMsg, 'error'); return; }
    goToStep(3);
}
function buildSummary() {
    let html = '';
    currentConfig.fields.forEach(f => {
        if (f.type === 'hidden' || f.type === 'file' || f.type === 'heading') return;
        const el  = document.querySelector(`[name="${f.name}"]`);
        const val = el ? el.value : '-';
        html += `<div class="flex justify-between py-1.5 border-b border-gray-100 last:border-0">
            <span class="text-gray-500 text-xs">${f.label}</span>
            <span class="font-semibold text-gray-800 text-xs text-right max-w-[60%] truncate">${val||'-'}</span>
        </div>`;
    });
    currentConfig.files.forEach(f => {
        const el  = document.querySelector(`[name="${f.name}"]`);
        const val = el && el.files[0] ? el.files[0].name : '(belum dipilih)';
        html += `<div class="flex justify-between py-1.5 border-b border-gray-100 last:border-0">
            <span class="text-gray-500 text-xs">${f.label}</span>
            <span class="font-semibold text-xs text-right max-w-[60%] truncate ${el&&el.files[0]?'text-green-600':'text-gray-400'}">${val}</span>
        </div>`;
    });
    document.getElementById('summaryData').innerHTML = html;
}
function computeEAR(p1, p2, p3, p4, p5, p6) {
    const dist = (a, b) => Math.hypot(a.x - b.x, a.y - b.y);
    const vertical1 = dist(p2, p6);
    const vertical2 = dist(p3, p5);
    const horizontal = dist(p1, p4);
    if (horizontal < 1e-6) return 0;
    return (vertical1 + vertical2) / (2.0 * horizontal);
}
const LEFT_EYE_IDX  = [33,  160, 158, 133, 153, 144]; // [outer, top-left, top-right, inner, bot-right, bot-left]
const RIGHT_EYE_IDX = [362, 385, 387, 263, 373, 380];
function getEAR(landmarks) {
    const lm = (idx) => landmarks[idx];
    const earL = computeEAR(
        lm(LEFT_EYE_IDX[0]),  lm(LEFT_EYE_IDX[1]),  lm(LEFT_EYE_IDX[2]),
        lm(LEFT_EYE_IDX[3]),  lm(LEFT_EYE_IDX[4]),  lm(LEFT_EYE_IDX[5])
    );
    const earR = computeEAR(
        lm(RIGHT_EYE_IDX[0]), lm(RIGHT_EYE_IDX[1]), lm(RIGHT_EYE_IDX[2]),
        lm(RIGHT_EYE_IDX[3]), lm(RIGHT_EYE_IDX[4]), lm(RIGHT_EYE_IDX[5])
    );
    return (earL + earR) / 2;
}
function detectBlink(landmarks) {
    const ear = getEAR(landmarks);
    if (ear < BLINK_THRESHOLD && !eyeClosed) {
        eyeClosed = true;
    } else if (ear >= BLINK_THRESHOLD && eyeClosed) {
        eyeClosed = false;
        blinkCount++;
        updateBlinkUI();
        if (blinkCount >= BLINK_TARGET) {
            onLivenessPassed();
        }
    }
}
function updateBlinkUI() {
    document.getElementById('blinkCount').textContent = blinkCount;
    for (let i = 1; i <= BLINK_TARGET; i++) {
        const dot = document.getElementById(`blink-dot-${i}`);
        if (!dot) continue;
        if (i <= blinkCount) {
            dot.className = 'w-8 h-8 rounded-full border-2 border-green-500 bg-green-500 flex items-center justify-center text-xs font-bold text-white';
            dot.innerHTML = '<i class="fas fa-check text-xs"></i>';
        }
    }
    setOverlay(`Kedipan ${blinkCount}/${BLINK_TARGET} terdeteksi…`);
}
function onLivenessPassed() {
    stopCamera();
    document.getElementById('liveness_passed').value = '1';
    document.getElementById('btnStartLiveness').disabled = true;
    setOverlay('✓ Verifikasi berhasil!');
    document.getElementById('liveness-overlay').classList.replace('bg-black/50','bg-green-600/80');
    showToast('Verifikasi wajah berhasil! Lanjutkan pengajuan.', 'success');
    setTimeout(() => goToStep(5), 900);
}
function setOverlay(text) {
    document.getElementById('liveness-overlay').textContent = text;
}
function startLiveness() {
    if (livenessStarted) return;
    livenessStarted = true;
    const errEl = document.getElementById('liveness-error');
    errEl.classList.add('hidden');
    document.getElementById('btnStartLiveness').disabled = true;
    setOverlay('Meminta izin kamera...');
    navigator.mediaDevices.getUserMedia({ video: true })
        .then((stream) => {
            stream.getTracks().forEach(track => track.stop());
            setOverlay('Mengaktifkan algoritma wajah...');
            const video = document.getElementById('video');
            faceMeshInstance = new FaceMesh({
                locateFile: (file) => `https://cdn.jsdelivr.net/npm/@mediapipe/face_mesh/${file}`
            });
            faceMeshInstance.setOptions({
                maxNumFaces: 1,
                refineLandmarks: true,
                minDetectionConfidence: 0.5,
                minTrackingConfidence: 0.5
            });
            faceMeshInstance.onResults((results) => {
                if (!results.multiFaceLandmarks || results.multiFaceLandmarks.length === 0) {
                    setOverlay('Wajah tidak terdeteksi — pastikan wajah terlihat jelas');
                    return;
                }
                setOverlay('Kedipkan mata 2 kali secara natural…');
                detectBlink(results.multiFaceLandmarks[0]);
            });
            mpCamera = new Camera(video, {
                onFrame: async () => {
                    if (faceMeshInstance) await faceMeshInstance.send({ image: video });
                },
                width: 640,
                height: 480
            });
            mpCamera.start()
                .then(() => setOverlay('Kedipkan mata 2 kali secara natural…'))
                .catch((err) => {
                    errEl.textContent = 'Gagal render MediaPipe: ' + (err.message || err);
                    errEl.classList.remove('hidden');
                    setOverlay('Gagal mengakses kamera');
                    livenessStarted = false;
                    document.getElementById('btnStartLiveness').disabled = false;
                });
        })
        .catch((err) => {
            console.error("Detail Error Kamera:", err);
            errEl.textContent = 'Kamera diblokir oleh browser/sistem. Cek icon gembok di address bar. (' + err.name + ')';
            errEl.classList.remove('hidden');
            setOverlay('Izin kamera ditolak');
            livenessStarted = false;
            document.getElementById('btnStartLiveness').disabled = false;
        });
}
function stopCamera() {
    if (mpCamera) { mpCamera.stop(); mpCamera = null; }
}
function resetLiveness() {
    blinkCount     = 0;
    eyeClosed      = false;
    livenessStarted = false;
    faceMeshInstance = null;
    document.getElementById('blinkCount').textContent   = '0';
    document.getElementById('liveness_passed').value    = '0';
    document.getElementById('liveness-overlay').textContent = 'Tekan "Mulai Verifikasi" untuk mengaktifkan kamera';
    document.getElementById('liveness-overlay').className = 'absolute bottom-0 left-0 right-0 bg-black/50 text-white text-center py-2 text-sm font-semibold';
    const btn = document.getElementById('btnStartLiveness');
    if (btn) btn.disabled = false;
    for (let i = 1; i <= BLINK_TARGET; i++) {
        const dot = document.getElementById(`blink-dot-${i}`);
        if (dot) {
            dot.className = 'w-8 h-8 rounded-full border-2 border-gray-300 flex items-center justify-center text-xs font-bold text-gray-400';
            dot.textContent = i;
        }
    }
}
function handleFileSelect(input, fieldName) {
    const displayDiv = document.getElementById(`name-${fieldName}`);
    const icon       = document.getElementById(`icon-${fieldName}`);
    if (input.files && input.files[0]) {
        displayDiv.querySelector('.file-label').textContent = input.files[0].name;
        displayDiv.classList.remove('hidden');
        if (icon) icon.className = 'fas fa-check-circle text-2xl text-green-500 mb-2';
    } else {
        displayDiv.classList.add('hidden');
        if (icon) icon.className = 'fas fa-file-pdf text-2xl text-gray-400 mb-2';
    }
}
function showToast(message, type = 'error') {
    const colors = { error:'bg-red-500', success:'bg-green-500' };
    const toast  = document.createElement('div');
    toast.className = `fixed top-5 right-5 z-[9999] px-5 py-3 rounded-xl text-white text-sm font-semibold shadow-lg ${colors[type]} transition-all`;
    toast.innerHTML = `<i class="fas ${type==='error'?'fa-exclamation-circle':'fa-check-circle'} mr-2"></i>${message}`;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3500);
}
function closeModal() {
    stopCamera();
    resetLiveness();
    document.getElementById('serviceModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}
document.getElementById('serviceForm').addEventListener('submit', function(e) {
    if (document.getElementById('liveness_passed').value !== '1') {
        e.preventDefault();
        showToast('Harap selesaikan verifikasi wajah terlebih dahulu.', 'error');
        goToStep(4);
        return;
    }
    Swal.fire({ title:'Memproses...', allowOutsideClick:false, didOpen:()=>Swal.showLoading() });
});

// Auto-Recovery Script & Error Handling
@if(session('error'))
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Gagal Memproses!',
            html: '{!! session("error") !!}',
            confirmButtonColor: '#d33'
        });
    });
@endif

@if(session('success'))
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil Terkirim!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#16a34a'
        });
    });
@endif

@if($errors->any() || session('error'))
    document.addEventListener('DOMContentLoaded', function() {
        let lastLayananId = "{{ old('layanan_id') }}";
        if(lastLayananId) {
            let btn = document.getElementById('btn-layanan-' + lastLayananId);
            if(btn) btn.click();
        }
    });
@endif
</script>
@endpush
@endsection