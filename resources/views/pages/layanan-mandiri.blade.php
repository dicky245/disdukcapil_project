@extends('layouts.user')

@section('content')
@php
$serviceConfig = [
    // 1. KARTU KELUARGA 
    1 => [
        'icon'         => 'fa-address-card',
        'color'        => 'blue',
        'id'           => 'kk',
        'persyaratan'  => [
            'Formulir F-1.02 (Formulir Pendaftaran Peristiwa Kependudukan)<a href="'.route('unduh-formulir').'" class="text-blue-600 font-bold hover:underline ml-1" target="_blank"><i class="fas fa-download mr-1"></i>Unduh di Sini</a>',
            'KTP Pemohon dengan Ukuran Berkas Maksimal 200 mb Berformat PDF',
            'Kartu Keluarga Pemohon dengan Ukuran Berkas Maksimal 200 mb Berformat PDF',
            'Surat keterangan/bukti perubahan Peristiwa Kependudukan (cth: Paspor, SKPWNI) dan Peristiwa Penting.',
            'Formulir F-1.06 (Formulir Pernyataan Perubahan Elemen Data Kependudukan)',
        ],
        'penjelasan'   => [
            'Penduduk mengisi F1.02',
            'Penduduk melampirkan KK',
            'Penduduk mengisi F1.06 karena perubahan elemen data dalam KK',
            'Penduduk melampirkan fotokopi bukti peristiwa kependudukan dan peristiwa penting',
            'Dinas menerbitkan KK Baru',
        ],
        'fields'       => [
            ['name' => 'layanan_id',       'value' => '1', 'type' => 'hidden'],
            ['type' => 'heading',          'label' => 'Informasi Pendaftaran'],
            ['name' => 'nomor_antrian',    'label' => 'Nomor Antrian (Opsional)', 'placeholder' => 'Nomor Antrian', 'type' => 'text', 'required' => false],
            ['type' => 'heading',          'label' => 'Data Pemohon'],
            ['name' => 'nama_pemohon',     'label' => 'Nama Pemohon', 'placeholder' => 'Nama Pemohon', 'type' => 'text'],
            ['name' => 'nik_pemohon',      'label' => 'Nomor Induk Kependudukan', 'placeholder' => '16 Digit NIK Pemohon', 'type' => 'text'],
            ['name' => 'nomor_kk_pemohon', 'label' => 'Nomor Kartu Keluarga', 'placeholder' => 'Nomor Kartu Keluarga', 'type' => 'text'],
            ['name' => 'alamat_pemohon',   'label' => 'Alamat', 'placeholder' => 'Alamat Lengkap', 'type' => 'textarea'],
        ],
        'files' => [
            ['name' => 'formulir_f102',              'label' => 'Formulir F1.02'],
            ['name' => 'ktp_pemohon',                'label' => 'KTP Pemohon'],
            ['name' => 'kk_pemohon',                 'label' => 'KK Pemohon'],
            ['name' => 'formulir_f106',              'label' => 'Formulir F1.06'],
            ['name' => 'surat_keterangan_perubahan', 'label' => 'Surat Keterangan Bukti Peristiwa Kependudukan dan Peristiwa Penting'],
            ['name' => 'pernyataan_pindah_kk',       'label' => 'Surat Pernyataan Pengasuhan/Wali (Diwajibkan Jika Pindah KK)', 'required' => false],
        ],
    ],

    // 6. GANTI KEPALA KK 
    6 => [
        'icon'         => 'fa-user-edit',
        'color'        => 'blue',
        'id'           => 'ganti_kepala_kk',
        'persyaratan'  => [
            'Formulir F-1.02 (Formulir Pendaftaran Peristiwa Kependudukan)<a href="'.route('unduh-formulir').'" class="text-blue-600 font-bold hover:underline ml-1" target="_blank"><i class="fas fa-download mr-1"></i>Unduh di Sini</a>',
            'KTP Pemohon dengan Ukuran Berkas Maksimal 200 mb Berformat PDF',
            'Kartu Keluarga Pemohon dengan Ukuran Berkas Maksimal 200 mb Berformat PDF',
            'Akte Kematian Kepala Keluarga',
            'Surat Pernyataan Bersedia Menjadi Wali',
        ],
        'penjelasan'   => [
            'Penduduk mengisi formulir F-1.02',
            'Melampirkan akta kematian jika kepala keluarga meninggal',
            'Melampirkan KTP dan KK pemohon',
            'Dalam hal seluruh anggota keluarga masih berusia di bawah 17 tahun, diperlukan kepala keluarga yang telah dewasa.',
            'Dinas menerbitkan KK Baru.',
        ],
        'fields'       => [
            ['name' => 'layanan_id',       'value' => '6', 'type' => 'hidden'],
            ['type' => 'heading',          'label' => 'Informasi Pendaftaran'],
            ['name' => 'nomor_antrian',    'label' => 'Nomor Antrian (Opsional)', 'placeholder' => 'Nomor Antrian', 'type' => 'text', 'required' => false],
            ['type' => 'heading',          'label' => 'Data Pemohon'],
            ['name' => 'nama_pemohon',     'label' => 'Nama Pemohon', 'placeholder' => 'Nama Pemohon', 'type' => 'text'],
            ['name' => 'nik_pemohon',      'label' => 'Nomor Induk Kependudukan', 'placeholder' => '16 Digit NIK Pemohon', 'type' => 'text'],
            ['name' => 'nomor_kk_pemohon', 'label' => 'Nomor Kartu Keluarga', 'placeholder' => 'Nomor Kartu Keluarga', 'type' => 'text'],
            ['name' => 'alamat_pemohon',   'label' => 'Alamat', 'placeholder' => 'Alamat Lengkap', 'type' => 'textarea'],
        ],
        'files' => [
            ['name' => 'formulir_f102',         'label' => 'Formulir F1.02'],
            ['name' => 'ktp_pemohon',           'label' => 'KTP Pemohon'],
            ['name' => 'kk_pemohon',            'label' => 'KK Pemohon'],
            ['name' => 'akta_kematian',         'label' => 'Akte Kematian Kepala Keluarga Sebelumnya'],
            ['name' => 'surat_pernyataan_wali', 'label' => 'Surat Pernyataan Wali (Jika semua anggota dibawah 17 tahun)', 'required' => false],
        ],
    ],

    // 7. KK HILANG/RUSAK
    7 => [
        'icon'         => 'fa-file-medical-alt',
        'color'        => 'blue',
        'id'           => 'kk_hilang_rusak',
        'persyaratan'  => [
            'Formulir F-1.02 (Formulir Pendaftaran Peristiwa Kependudukan) <a href="'.route('unduh-formulir').'" class="text-blue-600 font-bold hover:underline ml-1" target="_blank"><i class="fas fa-download mr-1"></i>Unduh di Sini</a>',
            'KTP Pemohon dengan Ukuran Berkas Maksimal 200 mb Berformat PDF',
            'Surat kehilangan dari kepolisian (jika hilang) atau KK yang rusak',
        ],
        'penjelasan'   => [
            'Penduduk mengisi F.1.02',
            'Penduduk menyerahkan dokumen KK yang rusak/surat keterangan kehilangan dari kepolisian',
        ],
        'fields'       => [
            ['name' => 'layanan_id',       'value' => '7', 'type' => 'hidden'],
            ['type' => 'heading',          'label' => 'Informasi Pengajuan'],
            ['name' => 'nomor_antrian',    'label' => 'Nomor Antrian (Opsional)', 'placeholder' => 'Nomor Antrian', 'type' => 'text', 'required' => false],
            ['type' => 'heading',          'label' => 'Data Pemohon'],
            ['name' => 'nama_pemohon',     'label' => 'Nama Pemohon', 'placeholder' => 'Nama Pemohon', 'type' => 'text'],
            ['name' => 'nik_pemohon',      'label' => 'Nomor Induk Kependudukan', 'placeholder' => '16 Digit NIK Pemohon', 'type' => 'text'],
            ['name' => 'nomor_kk_pemohon', 'label' => 'Nomor Kartu Keluarga', 'placeholder' => 'Nomor Kartu Keluarga', 'type' => 'text'],
            ['name' => 'alamat_pemohon',   'label' => 'Alamat', 'placeholder' => 'Alamat Lengkap', 'type' => 'textarea'],
        ],
        'files' => [
            ['name' => 'formulir_f102',      'label' => 'Formulir F1.02'],
            ['name' => 'ktp_pemohon',        'label' => 'KTP Pemohon'],
            ['name' => 'suket_hilang_rusak', 'label' => 'Surat Kehilangan Kepolisian / Foto KK Rusak'],
        ],
    ],

    // 8. PISAH KK
    8 => [
        'icon'         => 'fa-people-arrows',
        'color'        => 'blue',
        'id'           => 'pisah_kk',
        'persyaratan'  => [
            'Formulir F-1.02 (Formulir Pendaftaran Peristiwa Kependudukan)<a href="'.route('unduh-formulir').'" class="text-blue-600 font-bold hover:underline ml-1" target="_blank"><i class="fas fa-download mr-1"></i>Unduh di Sini</a>',
            'KK lama',
            'Berumur sekurang-kurangnya 17 (tujuh belas) tahun atau sudah kawin.',
        ],
        'penjelasan'   => [
            'Penduduk mengisi F-1.02',
            'Penduduk melampirkan fotokopi buku nikah atau akta perceraian (jika disebabkan pernikahan atau perceraian)',
            'Penduduk melampirkan KK lama',
        ],
        'fields'       => [
            ['name' => 'layanan_id',       'value' => '8', 'type' => 'hidden'],
            ['type' => 'heading',          'label' => 'Informasi Pengajuan'],
            ['name' => 'nomor_antrian',    'label' => 'Nomor Antrian (Opsional)', 'placeholder' => 'Nomor Antrian', 'type' => 'text', 'required' => false],
            ['type' => 'heading',          'label' => 'Data Pemohon'],
            ['name' => 'nama_pemohon',     'label' => 'Nama Pemohon', 'placeholder' => 'Nama Pemohon', 'type' => 'text'],
            ['name' => 'nik_pemohon',      'label' => 'Nomor Induk Kependudukan', 'placeholder' => '16 Digit NIK Pemohon', 'type' => 'text'],
            ['name' => 'nomor_kk_pemohon', 'label' => 'Nomor Kartu Keluarga', 'placeholder' => 'Nomor Kartu Keluarga', 'type' => 'text'],
            ['name' => 'alamat_pemohon',   'label' => 'Alamat', 'placeholder' => 'Alamat Lengkap', 'type' => 'textarea'],
        ],
        'files' => [
            ['name' => 'formulir_f102',       'label' => 'Formulir F1.02'],
            ['name' => 'ktp_pemohon',         'label' => 'KTP Pemohon'],
            ['name' => 'kk_pemohon',          'label' => 'KK Pemohon'],
            ['name' => 'fotokopi_buku_nikah', 'label' => 'Buku nikah / akta cerai (Jika karena pernikahan/perceraian)'],
            ['name' => 'kk_lama',             'label' => 'Scan/Foto Asli KK Lama'],
        ],
    ],

    // 2. AKTE KELAHIRAN
    2 => [
        'icon'         => 'fa-baby',
        'color'        => 'green',
        'id'           => 'akte_kelahiran',
        'persyaratan'  => [
            'Formulir F-2.01 <a href="'.route('unduh-formulir').'" class="text-blue-600 font-bold hover:underline ml-1" target="_blank"><i class="fas fa-download mr-1"></i>Unduh di Sini</a>',
            'Surat keterangan kelahiran dari rumah sakit/Puskesmas/bidan/kepala desa.',
            'Buku nikah/kutipan akta perkawinan orang tua',
            'KK dan KTP orang tua',
        ],
        'penjelasan'   => [
            'Mengisi formulir F-2.01',
            'Untuk pelayanan online/daring, persyaratan yang discan/difoto untuk diunggah harus aslinya',
        ],
        'fields'       => [
            ['name' => 'layanan_id',       'value' => '2', 'type' => 'hidden'],
            ['type' => 'heading',          'label' => 'Informasi Pengajuan'],
            ['name' => 'nomor_antrian',    'label' => 'Nomor Antrian (Opsional)', 'placeholder' => 'Nomor Antrian', 'type' => 'text', 'required' => false],
            ['type' => 'heading',          'label' => 'Akte Kelahiran'],
            ['name' => 'nama_pemohon',     'label' => 'Nama Pemohon', 'placeholder' => 'Masukkan Nama Pemohon', 'type' => 'text'],
            ['name' => 'nik_pemohon',      'label' => 'NIK Pemohon', 'placeholder' => 'Masukkan NIK Pemohon', 'type' => 'text'],
            ['name' => 'nomor_kk_pemohon', 'label' => 'Nomor KK Pemohon', 'placeholder' => 'Nomor KK Pemohon', 'type' => 'text'],
            ['name' => 'alamat',           'label' => 'Alamat Pemohon', 'placeholder' => 'Alamat Pemohon', 'type' => 'textarea'],
        ],
        'files' => [
            ['name' => 'formulir_f201',            'label' => 'Formulir F2.01 yang Telah Diisi'],
            ['name' => 'ktp_pemohon',              'label' => 'KTP Pemohon'],
            ['name' => 'ktp_saksi1',               'label' => 'KTP Saksi 1'],
            ['name' => 'ktp_saksi2',               'label' => 'KTP Saksi 2'],
            ['name' => 'file_surat_lahir',         'label' => 'Surat Keterangan Lahir (RS/Bidan/Nakhoda/Kades)'],
            ['name' => 'file_buku_nikah',          'label' => 'Buku Nikah / Akta Perkawinan'],
            ['name' => 'file_sptjm_kelahiran',     'label' => 'SPTJM Kebenaran Data Kelahiran (F-2.03) - Jika tidak ada surat lahir', 'required' => false],
            ['name' => 'file_sptjm_pasutri',       'label' => 'SPTJM Kebenaran Pasangan Suami Istri (F-2.04) - Jika tidak ada buku nikah', 'required' => false],
            ['name' => 'file_berita_acara_polisi', 'label' => 'Berita Acara Kepolisian - Untuk anak tidak diketahui asal usulnya', 'required' => false],
        ],
    ],

    // 3. AKTE KEMATIAN
    3 => [
        'icon'         => 'fa-user-times',
        'color'        => 'blue',
        'id'           => 'akte_kematian',
        'persyaratan'  => [
            'Formulir F-2.01 (Wajib diisi) <a href="'.route('unduh-formulir').'" class="text-blue-600 font-bold hover:underline ml-1" target="_blank"><i class="fas fa-download mr-1"></i>Unduh di Sini</a>',
            'Fotokopi surat kematian dari dokter atau kepala desa/lurah',
            'Fotokopi KTP & KK Pemohon.',
            'Fotokopi KTP yang meninggal dunia.',
            'Fotokopi KTP Saksi.'
        ],
        'penjelasan'   => [
            'WNI melampirkan fotokopi KK untuk verifikasi data.',
            'Untuk pelayanan online/Daring, persyaratan yang discan/ difoto untuk diunggah harus aslinya.',
            'Seluruh informasi terkait jenazah dan saksi dilampirkan melalui isian Formulir F-2.01.', 
        ],
        'template_url' => '#',
        'fields'       => [ 
            ['name' => 'layanan_id',       'value' => '3', 'type' => 'hidden'],
            ['type' => 'heading',          'label' => 'Informasi Pengajuan'],
            ['name' => 'nomor_antrian',    'label' => 'Nomor Antrian', 'placeholder' => 'Masukkan Nomor Antrian', 'type' => 'text', 'required' => false],
            ['type' => 'heading',          'label' => 'Data Pemohon'],
            ['name' => 'nik_pemohon',      'label' => 'NIK Pemohon', 'placeholder' => '16 digit NIK Pemohon', 'type' => 'text'],
            ['name' => 'nomor_kk_pemohon', 'label' => 'Nomor KK Pemohon', 'placeholder' => '16 digit Nomor KK', 'type' => 'text'],
            ['name' => 'nama_pemohon',     'label' => 'Nama Lengkap Pemohon', 'placeholder' => 'Masukkan Nama Lengkap Pemohon', 'type' => 'text'],
            ['name' => 'alamat_pemohon',   'label' => 'Alamat Pemohon', 'placeholder' => 'Alamat Domisili', 'type' => 'textarea'],
            ['name' => 'hubungan_pemohon', 'label' => 'Hubungan dengan Jenazah', 'placeholder' => 'Contoh: Anak / Suami / Istri / Ketua RT', 'type' => 'text'],
        ],
        'files'        => [
            ['name' => 'formulir_f201',             'label' => 'Scan/Foto Asli Formulir F-2.01 yang telah diisi'],
            ['name' => 'surat_keterangan_kematian', 'label' => 'Scan/Foto Asli Surat Keterangan Kematian (Dokter/Kades)'],
            ['name' => 'ktp_pemohon',               'label' => 'Scan/Foto Asli KTP Pemohon'],
            ['name' => 'kartu_keluarga_pemohon',    'label' => 'Scan/Foto Asli KK Pemohon'],
            ['name' => 'ktp_almarhum',              'label' => 'Scan/Foto Asli KTP Almarhum'],
            ['name' => 'ktp_saksi1',                'label' => 'Scan/Foto Asli KTP Saksi 1'],
            ['name' => 'ktp_saksi2',                'label' => 'Scan/Foto Asli KTP Saksi 2'],
        ],
    ],

    // 4. LAHIR MATI
    4 => [
        'icon'         => 'fa-exclamation-triangle',
        'color'        => 'blue',
        'id'           => 'lahir_mati',
        'persyaratan'  => [
            'Formulir F-2.01 (Wajib diisi) <a href="'.route('unduh-formulir').'" class="text-blue-600 font-bold hover:underline ml-1" target="_blank"><i class="fas fa-download mr-1"></i>Unduh di Sini</a>',
            'Pemohon Merupakan Orang Tua Kandung dari Bayi yang Lahir Mati.',
            'Fotokopi surat keterangan lahir mati (RS/Bidan/Kades).',
            'Fotokopi KTP & KK Orang Tua.',
            'Fotokopi KTP Saksi.',
        ],
        'penjelasan'   => [
            'WNI melampirkan fotokopi KK untuk verifikasi data.',
            'Untuk pelayanan online/Daring, persyaratan yang discan/ difoto untuk diunggah harus aslinya.',
            'Seluruh informasi terkait jenazah (bayi) dan orang tua dilampirkan melalui isian Formulir F-2.01.',
        ],
        'template_url' => '#',
        'fields'       => [
            ['name' => 'layanan_id',       'value' => '4', 'type' => 'hidden'],
            ['type' => 'heading',          'label' => 'Informasi Pengajuan'],
            ['name' => 'nomor_antrian',    'label' => 'Nomor Antrian', 'placeholder' => 'Masukkan Nomor Antrian', 'type' => 'text', 'required' => false],
            ['type' => 'heading',          'label' => 'Data Pemohon'],
            ['name' => 'nik_pemohon',      'label' => 'NIK Pemohon', 'placeholder' => '16 digit NIK Pemohon', 'type' => 'text'],
            ['name' => 'nomor_kk_pemohon', 'label' => 'Nomor KK Pemohon', 'placeholder' => '16 digit Nomor KK', 'type' => 'text'],
            ['name' => 'nama_pemohon',     'label' => 'Nama Lengkap Pemohon', 'placeholder' => 'Masukkan Nama Lengkap Pemohon', 'type' => 'text'],
            ['name' => 'alamat_pemohon',   'label' => 'Alamat Pemohon', 'placeholder' => 'Alamat Domisili', 'type' => 'textarea'],
            ['name' => 'hubungan_pemohon', 'label' => 'Hubungan dengan Jenazah Bayi', 'placeholder' => 'Contoh: Ayah / Ibu / Bidan', 'type' => 'text'],
        ],
        'files'        => [
            ['name' => 'formulir_f201',               'label' => 'Scan/Foto Asli Formulir F-2.01 yang telah diisi'],
            ['name' => 'surat_keterangan_lahir_mati', 'label' => 'Scan/Foto Asli Surat Ket. Lahir Mati (RS/Bidan/Kades)'],
            ['name' => 'ktp_pemohon',                 'label' => 'Scan/Foto Asli KTP Pemohon'],
            ['name' => 'kartu_keluarga_pemohon',      'label' => 'Scan/Foto Asli KK Pemohon'],
            ['name' => 'ktp_saksi1',                  'label' => 'Scan/Foto Asli KTP Saksi 1'],
            ['name' => 'ktp_saksi2',                  'label' => 'Scan/Foto Asli KTP Saksi 2'],
        ],
    ],

    // 5. PERKAWINAN 
    5 => [
        'icon'         => 'fa-ring',
        'color'        => 'blue',
        'id'           => 'layanan-pernikahan',
        'persyaratan'  => [
            'Kutipan akta kelahiran masing-masing pihak',
            'Surat keterangan belum pernah kawin dari Kepala Desa/Lurah',
            'KTP dan KK kedua calon mempelai',
            'Pas foto berdampingan 4x6 sebanyak 5 lembar',
        ],
        'penjelasan'   => [
            'Penduduk mengisi formulir permohonan pencatatan perkawinan',
            'Melampirkan semua persyaratan yang ditentukan',
            'Dinas menerbitkan Kutipan Akta Perkawinan',
        ],
        'template_url' => '#',
        'fields'       => [
            ['name' => 'layanan_id',         'value' => '5', 'type' => 'hidden'],
            ['type' => 'heading',            'label' => 'Informasi Pendaftaran'],
            ['name' => 'nomor_antrian',      'label' => 'Kode Antrian', 'type' => 'text', 'placeholder' => 'Masukkan kode antrian'],
            ['name' => 'tanggal_perkawinan', 'label' => 'Tanggal Perkawinan', 'type' => 'date'],
            ['type' => 'heading',            'label' => 'Data Mempelai Pria (Suami)'],
            ['name' => 'nama_lengkap_suami', 'label' => 'Nama Suami Lengkap', 'type' => 'text', 'placeholder' => 'Nama sesuai KTP'],
            ['name' => 'nik_suami',          'label' => 'NIK Suami', 'type' => 'text', 'placeholder' => '16 digit NIK Suami'],
            ['type' => 'heading',            'label' => 'Data Mempelai Wanita (Istri)'],
            ['name' => 'nama_lengkap_istri', 'label' => 'Nama Istri Lengkap', 'type' => 'text', 'placeholder' => 'Nama sesuai KTP'],
            ['name' => 'nik_istri',          'label' => 'NIK Istri', 'type' => 'text', 'placeholder' => '16 digit NIK Istri'],
        ],
        'files'        => [
            ['name' => 'akta_pernikahan', 'label' => 'Upload Akta Pernikahan (Opsional)', 'required' => false],
        ],
    ],
];

$kategoriLayanan = [
    'Kartu Keluarga (KK)' => [
        'icon'    => 'fa-id-card',
        'emoji'   => '👨‍👩‍👧',
        'color'   => 'blue',
        'layanan' => [1, 6, 7, 8],
    ],
    'Akte Kelahiran' => [
        'icon'    => 'fa-baby',
        'emoji'   => '👶',
        'color'   => 'green',
        'layanan' => [2],
    ],
    'Akte Kematian' => [
        'icon'    => 'fa-file-medical',
        'emoji'   => '🕯️',
        'color'   => 'orange',
        'layanan' => [3, 4],
    ],
    'Akte Perkawinan' => [
        'icon'    => 'fa-ring',
        'emoji'   => '💍',
        'color'   => 'purple',
        'layanan' => [5],
    ],
];

$colorMap = [
    'blue'   => ['bg' => '#EFF6FF', 'text' => '#1D4ED8', 'border' => '#93C5FD', 'badge_bg' => '#DBEAFE', 'badge_text' => '#1E40AF', 'icon_bg' => '#E6F1FB'],
    'green'  => ['bg' => '#F0FDF4', 'text' => '#15803D', 'border' => '#86EFAC', 'badge_bg' => '#DCFCE7', 'badge_text' => '#166534', 'icon_bg' => '#EAF3DE'],
    'orange' => ['bg' => '#FFF7ED', 'text' => '#C2410C', 'border' => '#FDB97D', 'badge_bg' => '#FFEDD5', 'badge_text' => '#9A3412', 'icon_bg' => '#FAEEDA'],
    'purple' => ['bg' => '#FAF5FF', 'text' => '#7E22CE', 'border' => '#D8B4FE', 'badge_bg' => '#F3E8FF', 'badge_text' => '#6B21A8', 'icon_bg' => '#FBEAF0'],
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

    {{-- Hero Section --}}
    <section class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-cyan-800 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm text-sm font-medium mb-4">
                    <i class="fas fa-rocket"></i> Layanan Mandiri
                </div>
                <h1 class="text-3xl md:text-4xl font-extrabold mb-4">Pilih Jenis Layanan</h1>
                <p class="text-base text-blue-100 mb-6">
                    Pilih kategori layanan yang Anda butuhkan dan isi form pendaftaran secara online.
                </p>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="#f9fafb"/>
            </svg>
        </div>
    </section>

    {{-- Kategori Grid 2x2 --}}
    <section class="py-12 bg-gray-50 -mt-6 relative z-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Panduan --}}
            <div class="mb-8 bg-blue-50 border border-blue-200 rounded-2xl p-5 reveal shadow-sm">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-blue-200">
                        <i class="fas fa-info-circle text-lg text-white"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm mb-1">Panduan Pengajuan</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Pilih kategori layanan, lalu pilih jenis layanan yang sesuai kebutuhan Anda.
                            Pastikan dokumen pendukung sudah disiapkan sebelum mengisi formulir.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Grid Kategori --}}
            <div class="grid grid-cols-2 gap-4 reveal">
                @foreach($kategoriLayanan as $namaKategori => $kategoriConfig)
                    @php
                        $c = $colorMap[$kategoriConfig['color']] ?? $colorMap['blue'];
                        $jumlah = count($kategoriConfig['layanan']);
                        $layananList = [];
                        foreach ($kategoriConfig['layanan'] as $lid) {
                            $layanan = $layananById[$lid] ?? null;
                            $config  = $serviceConfig[$lid] ?? null;
                            if (!$layanan || !$config) continue;
                            $layananList[] = [
                                'lid'    => $lid,
                                'name'   => $layanan->nama_layanan,
                                'desc'   => $layanan->keterangan ?? str_replace('Penerbitan ', '', $layanan->nama_layanan),
                                'icon'   => $config['icon'],
                                'config' => $config,
                            ];
                        }
                    @endphp

                    <button onclick='openKategoriModal({{ json_encode($layananList) }}, {{ json_encode($namaKategori) }}, {{ json_encode($c) }}, {{ json_encode($kategoriConfig["icon"]) }})'
                        class="group bg-white rounded-2xl p-5 text-left border-2 border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex flex-col"
                        style="min-height: 140px;"
                        onmouseover="this.style.borderColor='{{ $c['border'] }}'"
                        onmouseout="this.style.borderColor='#F3F4F6'">

                        <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-3 flex-shrink-0"
                             style="background: {{ $c['icon_bg'] }}">
                            <i class="fas {{ $kategoriConfig['icon'] }} text-xl" style="color: {{ $c['text'] }}"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-800 text-sm mb-1 leading-tight">{{ $namaKategori }}</h3>
                            <p class="text-xs text-gray-400">{{ $jumlah }} layanan tersedia</p>
                        </div>
                        <div class="mt-3">
                            <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold"
                                  style="background: {{ $c['badge_bg'] }}; color: {{ $c['badge_text'] }}">
                                Pilih <i class="fas fa-arrow-right text-[10px]"></i>
                            </span>
                        </div>
                    </button>
                @endforeach
            </div>
        </div>
    </section>
</main>

{{-- MODAL 1: PILIH LAYANAN --}}
<div id="kategoriModal" class="fixed inset-0 z-40 hidden overflow-y-auto">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="closeKategoriModal()"></div>
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md relative z-10 overflow-hidden" style="animation: popIn 0.2s ease;">
            <div id="km-header" class="p-5 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div id="km-icon" class="w-10 h-10 rounded-xl flex items-center justify-center"></div>
                        <div>
                            <h3 id="km-title" class="text-base font-bold text-gray-800"></h3>
                            <p id="km-sub" class="text-xs text-gray-400 mt-0.5"></p>
                        </div>
                    </div>
                    <button onclick="closeKategoriModal()" class="w-8 h-8 rounded-xl bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition">
                        <i class="fas fa-times text-gray-500 text-sm"></i>
                    </button>
                </div>
            </div>
            <div id="km-list" class="p-3 space-y-1 max-h-[60vh] overflow-y-auto"></div>
        </div>
    </div>
</div>

{{-- MODAL 2: FORM STEPPER --}}
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
                {{-- Steps --}}
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

            <form id="serviceForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="foto_wajah" id="foto_wajah">

                {{-- Step 1 --}}
                <div id="step1" class="step-content p-5 space-y-5">
                    <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fas fa-info-circle text-blue-600"></i>
                            <h4 class="font-bold text-blue-800 text-sm">Informasi Layanan</h4>
                        </div>
                        <p id="infoLayanan" class="text-sm text-blue-700 leading-relaxed"></p>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm mb-3">Persyaratan Dokumen</h4>
                        <ul id="listPersyaratan" class="space-y-2"></ul>
                    </div>
                    <button type="button" onclick="goToStep(2)" class="w-full py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl font-bold hover:from-green-700 hover:to-green-800 transition-all">Selanjutnya</button>
                </div>

                {{-- Step 2: Data --}}
                <div id="step2" class="step-content p-5 hidden">
                    <div id="formFields" class="grid grid-cols-1 md:grid-cols-2 gap-4"></div>
                    <div class="flex gap-3 mt-6">
                        <button type="button" onclick="goToStep(1)" class="flex-1 py-3 border rounded-xl font-bold">Kembali</button>
                        <button type="button" onclick="validateAndGoStep3()" class="flex-1 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl font-bold hover:from-green-700 hover:to-green-800 transition-all">Selanjutnya</button>
                    </div>
                </div>

                {{-- Step 3: Berkas --}}
                <div id="step3" class="step-content p-5 hidden">
                    <div id="fileFields" class="space-y-4"></div>
                    <div class="flex gap-3 mt-6">
                        <button type="button" onclick="goToStep(2)" class="flex-1 py-3 border rounded-xl font-bold">Kembali</button>
                        <button type="button" onclick="validateAndGoStep4()" class="flex-1 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl font-bold hover:from-green-700 hover:to-green-800 transition-all">Selanjutnya</button>
                    </div>
                </div>

                {{-- Step 4: Verifikasi --}}
                <div id="step4" class="step-content p-5 hidden">
                    <div class="relative rounded-2xl overflow-hidden border bg-black aspect-video mb-4">
                        <video id="video" autoplay playsinline muted class="w-full h-full object-cover"></video>
                        <canvas id="canvas" class="hidden"></canvas>
                        <div id="liveness-overlay" class="absolute bottom-0 inset-x-0 bg-black/60 text-white text-center py-2 text-xs">Aktifkan Kamera</div>
                    </div>
                    <div id="blink-status" class="text-center text-sm font-bold text-gray-700 mb-4">Kedipan: <span id="blinkCount">0</span>/2</div>
                    <div class="flex gap-3">
                        <button type="button" onclick="goToStep(3); stopCamera();" class="flex-1 py-3 border rounded-xl font-bold">Kembali</button>
                        <button type="button" id="btnStartLiveness" onclick="startLiveness()" class="flex-1 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl font-bold hover:from-green-700 hover:to-green-800 transition-all">Mulai Kamera</button>
                    </div>
                </div>

                {{-- Step 5: Konfirmasi --}}
                <div id="step5" class="step-content p-5 hidden">
                    <div id="summaryData" class="space-y-2 border p-4 rounded-xl bg-gray-50 text-sm"></div>
                    <button type="submit" class="w-full py-3 bg-green-600 text-white rounded-xl font-bold mt-6">Kirim Pengajuan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .reveal { opacity: 0; transform: translateY(20px); transition: all 0.5s ease-out; }
    .reveal.active { opacity: 1; transform: translateY(0); }
    .step-indicator { background: #e5e7eb; color: #9ca3af; }
    .step-indicator.active { background: #2563eb; color: #fff; }
    .step-indicator.done { background: #16a34a; color: #fff; }
    .form-input { width: 100%; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 0.75rem; outline: none; }
    .form-input:focus { border-color: #3b82f6; }
    @keyframes popIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
    .layanan-item:hover { background: #f9fafb; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@mediapipe/face_mesh/face_mesh.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js"></script>
<script>
let currentStep = 1, currentConfig = {}, mpCamera = null, faceMeshInstance = null;
let blinkCount = 0, eyeClosed = false, livenessStarted = false;
const BLINK_THRESHOLD = 0.25, BLINK_TARGET = 2;

const routeMap = {
    'kk': "{{ route('kk.store') }}",
    'akte_kelahiran': "{{ route('aktelahir.store') }}",
    'ganti_kepala_kk': "{{ route('kk.store.gantikepalakk') }}",
    'kk_hilang_rusak': "{{ route('kk.store.hilangrusak') }}",
    'pisah_kk': "{{ route('kk.store.pisahkk') }}",
    'akte_kematian': "{{ route('akte-kematian.store') }}",
    'lahir_mati': "{{ route('lahir-mati.store') }}"
};

function reveal() {
    document.querySelectorAll('.reveal').forEach(el => {
        if (el.getBoundingClientRect().top < window.innerHeight - 50) el.classList.add('active');
    });
}
window.addEventListener('scroll', reveal);
window.addEventListener('load', reveal);

function openKategoriModal(list, title, colors, icon) {
    document.getElementById('km-title').textContent = title;
    document.getElementById('km-sub').textContent = list.length + ' layanan';
    const iconEl = document.getElementById('km-icon');
    iconEl.style.background = colors.icon_bg;
    iconEl.innerHTML = `<i class="fas ${icon} text-lg" style="color:${colors.text}"></i>`;
    
    document.getElementById('km-list').innerHTML = list.map(item => `
        <div class="layanan-item flex items-center gap-3 p-3 rounded-xl cursor-pointer border border-transparent hover:border-gray-200"
             onclick='selectLayanan(${JSON.stringify(item.config)}, ${JSON.stringify(item.name)})'>
            <i class="fas ${item.icon} text-blue-500"></i>
            <span class="text-sm font-bold text-gray-800">${item.name}</span>
        </div>`).join('');
    document.getElementById('kategoriModal').classList.remove('hidden');
}

function closeKategoriModal() { document.getElementById('kategoriModal').classList.add('hidden'); }

function selectLayanan(config, name) { closeKategoriModal(); openServiceModal(config, name); }

function openServiceModal(config, name) {
    currentConfig = config;
    document.getElementById('modalTitle').textContent = name;
    document.getElementById('serviceForm').action = routeMap[config.id] || '#';
    document.getElementById('infoLayanan').textContent = `Pengajuan ${name} diproses dalam 2-3 hari kerja.`;
    
    document.getElementById('listPersyaratan').innerHTML = config.persyaratan.map(p => 
        `<li class="text-sm text-gray-600 flex gap-2"><i class="fas fa-check text-green-500 mt-1"></i><span>${p}</span></li>`).join('');

    const textFields = config.fields.filter(f => f.type !== 'file');
    document.getElementById('formFields').innerHTML = textFields.map(f => {
        if (f.type === 'hidden') return `<input type="hidden" name="${f.name}" value="${f.value}">`;
        if (f.type === 'heading') return `<div class="col-span-full border-b font-bold text-xs pt-4">${f.label}</div>`;
        return `<div><label class="block text-xs font-bold mb-1">${f.label}</label>
                <input type="${f.type}" name="${f.name}" class="form-input" placeholder="${f.placeholder||''}" required></div>`;
    }).join('');

    document.getElementById('fileFields').innerHTML = config.files.map(f => `
        <div class="border-2 border-dashed p-4 rounded-xl text-center">
            <label class="block text-xs font-bold mb-2">${f.label}</label>
            <input type="file" name="${f.name}" accept=".pdf" class="text-xs" onchange="handleFile(this, '${f.name}')">
            <div id="status-${f.name}" class="text-[10px] mt-1 text-blue-600 hidden font-bold">Terpilih</div>
        </div>`).join('');

    resetLiveness(); goToStep(1);
    document.getElementById('serviceModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function handleFile(input, name) {
    document.getElementById('status-' + name).classList.toggle('hidden', !input.files.length);
}

function goToStep(s) {
    currentStep = s;
    document.querySelectorAll('.step-content').forEach(c => c.classList.add('hidden'));
    document.getElementById('step' + s).classList.remove('hidden');
    for (let i = 1; i <= 5; i++) {
        const dot = document.getElementById('stepDot' + i);
        dot.className = `step-indicator w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold mb-1 ` + 
                        (i < s ? 'done' : (i === s ? 'active' : ''));
    }
    if (s === 5) buildSummary();
}

function validateAndGoStep3() { goToStep(3); }
function validateAndGoStep4() { goToStep(4); }

function buildSummary() {
    let h = '';
    currentConfig.fields.forEach(f => {
        if (f.type === 'heading' || f.type === 'hidden') return;
        const val = document.querySelector(`[name="${f.name}"]`)?.value || '-';
        h += `<div class="flex justify-between border-b py-1"><span>${f.label}</span><span class="font-bold">${val}</span></div>`;
    });
    document.getElementById('summaryData').innerHTML = h;
}

function startLiveness() {
    livenessStarted = true;
    const video = document.getElementById('video');
    faceMeshInstance = new FaceMesh({ locateFile: (f) => `https://cdn.jsdelivr.net/npm/@mediapipe/face_mesh/${f}` });
    faceMeshInstance.setOptions({ maxNumFaces: 1, refineLandmarks: true, minDetectionConfidence: 0.5 });
    faceMeshInstance.onResults(res => {
        if (res.multiFaceLandmarks?.length) detectBlink(res.multiFaceLandmarks[0]);
    });
    mpCamera = new Camera(video, { onFrame: async () => { await faceMeshInstance.send({ image: video }); }, width: 640, height: 480 });
    mpCamera.start();
    document.getElementById('liveness-overlay').textContent = "Kedipkan mata 2x...";
}

function detectBlink(lm) {
    const d = (a, b) => Math.hypot(lm[a].x - lm[b].x, lm[a].y - lm[b].y);
    const ear = (d(160, 153) + d(158, 144)) / (2 * d(33, 133));
    if (ear < BLINK_THRESHOLD && !eyeClosed) eyeClosed = true;
    else if (ear >= BLINK_THRESHOLD && eyeClosed) {
        eyeClosed = false; blinkCount++;
        document.getElementById('blinkCount').textContent = blinkCount;
        if (blinkCount >= BLINK_TARGET) {
            document.getElementById('liveness_passed').value = "1";
            stopCamera();
            goToStep(5);
        }
    }
}

function stopCamera() { if (mpCamera) { mpCamera.stop(); mpCamera = null; } }

function resetLiveness() { blinkCount = 0; livenessStarted = false; document.getElementById('blinkCount').textContent = 0; }

function closeModal() { stopCamera(); document.getElementById('serviceModal').classList.add('hidden'); document.body.style.overflow = 'auto'; }

function showToast(m, t) { 
    if (typeof SwalHelper === 'function') {
        SwalHelper.info(t);
    } else {
        Swal.fire({
            icon: 'info',
            title: 'Informasi',
            text: m,
            toast: true,
            position: 'top-end',
            timer: 3000,
            showConfirmButton: false
        });
    }
}

// Notifikasi sukses upload
function notifyUploadSuccess(fileName) {
    SwalHelper.success('File ' + fileName + ' berhasil diunggah');
}

// Notifikasi gagal upload
function notifyUploadError(message) {
    SwalHelper.error(message);
}

// Notifikasi form tidak lengkap
function notifyFormIncomplete() {
    SwalHelper.warning('Peringatan!', 'Mohon lengkapi semua field yang wajib diisi');
}

// Notifikasi validasi error
function notifyValidationError(errors) {
    SwalHelper.error('Validasi Gagal', errors.join(', '));
}

// Notifikasi pengajuan berhasil
function notifyPengajuanSuccess(noReg, onSelesai, onTambah) {
    Swal.fire({
        icon: 'success',
        title: 'Pengajuan Berhasil!',
        html: '<p>Nomor Registrasi: <strong>' + noReg + '</strong></p><p>Simpan nomor ini untuk melacak status pengajuan.</p>',
            confirmButtonColor: '#16a34a',
            confirmButtonText: 'OK'
        });
    }
}

// Notifikasi error submission
function notifySubmitError(message) {
    SwalHelper.error('Gagal!', message);
            text: message,
            confirmButtonColor: '#dc2626'
        });
    }
}
</script>
@endpush
@endsection