@extends('layouts.user')

@section('content')
@php
$serviceConfig = [
    1 => [
        'icon'         => 'fa-address-card',
        'color'        => 'blue',
        'id'           => 'kk',
        'persyaratan'  => [
            'Wajib Mengambil Nomor Antrian',
            'Formulir F-1.02 (Formulir Pendaftaran Peristiwa Kependudukan) <a href="'.route('unduh-formulir').'" class="text-blue-600 font-bold hover:underline ml-1" target="_blank"><i class="fas fa-download mr-1"></i>Unduh di Sini</a>',
            'KTP Pemohon dengan Ukuran Berkas Maksimal 200 KB Berformat PDF',
            'Kartu Keluarga Pemohon dengan Ukuran Berkas Maksimal 200 KB Berformat PDF',
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
            ['name' => 'layanan_id', 'value' => '1',  'type' => 'hidden'],
            ['type' => 'heading', 'label' => 'Informasi Pendaftaran'],
            ['name' => 'nomor_antrian', 'label' => 'Nomor Antrian', 'placeholder' => 'Nomor Antrian', 'type' => 'text'],
            ['type' => 'heading', 'label' => 'Data Pemohon'],
            ['name' => 'nama_pemohon', 'label' => 'Nama Pemohon', 'placeholder' => 'Nama Pemohon', 'type' => 'text'],
            ['name' => 'nik_pemohon', 'label' => 'Nomor Induk Kependudukan', 'placeholder' => '16 Digit NIK Pemohon', 'type' => 'text'],
            ['name' => 'nomor_kk_pemohon', 'label' => 'Nomor Kartu Keluarga', 'placeholder' => 'Nomor Kartu Keluarga', 'type' => 'text'],
            ['name' => 'alamat_pemohon', 'label' => 'Alamat', 'placeholder' => 'Alamat Lengkap', 'type' => 'textarea'],
        ],
        'files' => [
            ['name' => 'formulir_f102', 'label' => 'Formulir F1.02'],
            ['name' => 'ktp_pemohon', 'label' => 'KTP Pemohon'],
            ['name' => 'kk_pemohon', 'label' => 'KK Pemohon'],
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
            'Wajib Mengambil Nomor Antrian',
            'Formulir F-1.02 (Formulir Pendaftaran Peristiwa Kependudukan) <a href="'.route('unduh-formulir').'" class="text-blue-600 font-bold hover:underline ml-1" target="_blank"><i class="fas fa-download mr-1"></i>Unduh di Sini</a>',
            'KTP Pemohon dengan Ukuran Berkas Maksimal 200 KB Berformat PDF',
            'Kartu Keluarga Pemohon dengan Ukuran Berkas Maksimal 200 KB Berformat PDF',
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
            ['name' => 'layanan_id', 'value' => '6', 'type' => 'hidden'],
            ['type' => 'heading', 'label' => 'Informasi Pendaftaran'],
            ['name' => 'nomor_antrian', 'label' => 'Nomor Antrian', 'placeholder' => 'Nomor Antrian', 'type' => 'text'],
            ['type' => 'heading', 'label' => 'Data Pemohon'],
            ['name' => 'nama_pemohon', 'label' => 'Nama Pemohon', 'placeholder' => 'Nama Pemohon', 'type' => 'text'],
            ['name' => 'nik_pemohon', 'label' => 'Nomor Induk Kependudukan', 'placeholder' => '16 Digit NIK Pemohon', 'type' => 'text'],
            ['name' => 'nomor_kk_pemohon', 'label' => 'Nomor Kartu Keluarga', 'placeholder' => 'Nomor Kartu Keluarga', 'type' => 'text'],
            ['name' => 'alamat_pemohon', 'label' => 'Alamat', 'placeholder' => 'Alamat Lengkap', 'type' => 'textarea'],
        ],
        'files' => [
            ['name' => 'formulir_f102', 'label' => 'Formulir F1.02'],
            ['name' => 'ktp_pemohon', 'label' => 'KTP Pemohon'],
            ['name' => 'kk_pemohon', 'label' => 'KK Pemohon'],
            ['name' => 'akta_kematian', 'label' => 'Akte Kematian Kepala Keluarga Sebelumnya'],
            ['name' => 'surat_pernyataan_wali', 'label' => 'Surat Pernyataan Wali (Jika semua anggota dibawah 17 tahun)', 'required' => false],
        ],
    ],
    7 => [
        'icon'         => 'fa-file-medical-alt',
        'color'        => 'blue',
        'id'           => 'kk_hilang_rusak',
        'persyaratan'  => [
            'Wajib Mengambil Nomor Antrian',
            'Formulir F-1.02 (Formulir Pendaftaran Peristiwa Kependudukan) <a href="'.route('unduh-formulir').'" class="text-blue-600 font-bold hover:underline ml-1" target="_blank"><i class="fas fa-download mr-1"></i>Unduh di Sini</a>',
            'KTP Pemohon dengan Ukuran Berkas Maksimal 200 KB Berformat PDF',
            'Surat kehilangan dari kepolisian (jika hilang) atau KK yang rusak',
        ],
        'penjelasan'   => [
            'Penduduk mengisi F.1.02',
            'Penduduk menyerahkan dokumen KK yang rusak/surat keterangan kehilangan dari kepolisian',
        ],
        'fields'       => [
            ['name' => 'layanan_id', 'value' => '7', 'type' => 'hidden'],
            ['type' => 'heading', 'label' => 'Informasi Pengajuan'],
            ['name' => 'nomor_antrian', 'label' => 'Nomor Antrian', 'placeholder' => 'Nomor Antrian', 'type' => 'text'],
            ['type' => 'heading', 'label' => 'Data Pemohon'],
            ['name' => 'nama_pemohon', 'label' => 'Nama Pemohon', 'placeholder' => 'Nama Pemohon', 'type' => 'text'],
            ['name' => 'nik_pemohon', 'label' => 'Nomor Induk Kependudukan', 'placeholder' => '16 Digit NIK Pemohon', 'type' => 'text'],
            ['name' => 'nomor_kk_pemohon', 'label' => 'Nomor Kartu Keluarga', 'placeholder' => 'Nomor Kartu Keluarga', 'type' => 'text'],
            ['name' => 'alamat_pemohon', 'label' => 'Alamat', 'placeholder' => 'Alamat Lengkap', 'type' => 'textarea'],
        ],
        'files' => [
            ['name' => 'formulir_f102', 'label' => 'Formulir F1.02'],
            ['name' => 'ktp_pemohon', 'label' => 'KTP Pemohon'],
            ['name' => 'suket_hilang_rusak', 'label' => 'Surat Kehilangan Kepolisian / Foto KK Rusak'],
        ],
    ],
    8 => [
        'icon'         => 'fa-people-arrows',
        'color'        => 'blue',
        'id'           => 'pisah_kk',
        'persyaratan'  => [
            'Wajib Mengambil Nomor Antrian',
            'Formulir F-1.02 (Formulir Pendaftaran Peristiwa Kependudukan) <a href="'.route('unduh-formulir').'" class="text-blue-600 font-bold hover:underline ml-1" target="_blank"><i class="fas fa-download mr-1"></i>Unduh di Sini</a>',
            'KK lama',
            'Berumur sekurang-kurangnya 17 (tujuh belas) tahun atau sudah kawin.',
        ],
        'penjelasan'   => [
            'Penduduk mengisi F-1.02',
            'Penduduk melampirkan fotokopi buku nikah atau akta perceraian (jika disebabkan pernikahan atau perceraian)',
            'Penduduk melampirkan KK lama',
        ],
        'fields'       => [
            ['name' => 'layanan_id', 'value' => '8', 'type' => 'hidden'],
            ['type' => 'heading', 'label' => 'Informasi Pengajuan'],
            ['name' => 'nomor_antrian', 'label' => 'Nomor Antrian', 'placeholder' => 'Nomor Antrian', 'type' => 'text'],
            ['type' => 'heading', 'label' => 'Data Pemohon'],
            ['name' => 'nama_pemohon', 'label' => 'Nama Pemohon', 'placeholder' => 'Nama Pemohon', 'type' => 'text'],
            ['name' => 'nik_pemohon', 'label' => 'Nomor Induk Kependudukan', 'placeholder' => '16 Digit NIK Pemohon', 'type' => 'text'],
            ['name' => 'nomor_kk_pemohon', 'label' => 'Nomor Kartu Keluarga', 'placeholder' => 'Nomor Kartu Keluarga', 'type' => 'text'],
            ['name' => 'alamat_pemohon', 'label' => 'Alamat', 'placeholder' => 'Alamat Lengkap', 'type' => 'textarea'],
        ],
        'files' => [
            ['name' => 'formulir_f102', 'label' => 'Formulir F1.02'],
            ['name' => 'ktp_pemohon', 'label' => 'KTP Pemohon'],
            ['name' => 'kk_pemohon', 'label' => 'KK Pemohon'],
            ['name' => 'fotokopi_buku_nikah', 'label' => 'Buku nikah / akta cerai (Jika karena pernikahan/perceraian)'],
            ['name' => 'kk_lama', 'label' => 'Scan/Foto Asli KK Lama'],
        ],
    ],
    2 => [
        'icon'         => 'fa-baby',
        'color'        => 'green',
        'id'           => 'akte_kelahiran',
        'persyaratan'  => [
            'Wajib Mengambil Nomor Antrian',
            'Formulir F-2.01 (Formulir Permohonan Pencatatan Kelahiran) <a href="'.route('unduh-formulir').'" class="text-blue-600 font-bold hover:underline ml-1" target="_blank"><i class="fas fa-download mr-1"></i>Unduh di Sini</a>',
            'Surat keterangan kelahiran dari rumah sakit/Puskesmas/bidan/kepala desa.',
            'Buku nikah/kutipan akta perkawinan orang tua',
            'KK dan KTP orang tua',
        ],
        'penjelasan'   => [
            'Mengisi formulir F-2.01',
            'Untuk pelayanan online/daring, persyaratan yang discan/difoto untuk diunggah harus aslinya',
        ],
        'fields'       => [
            ['name' => 'layanan_id', 'value' => '2', 'type' => 'hidden'],
            ['type' => 'heading', 'label' => 'Informasi Pengajuan'],
            ['name' => 'nomor_antrian', 'label' => 'Nomor Antrian', 'placeholder' => 'Nomor Antrian', 'type' => 'text'],
            ['type' => 'heading', 'label' => 'Akte Kelahiran'],
            ['name' => 'nama_pemohon', 'label' => 'Nama Pemohon', 'placeholder' => 'Masukkan Nama Pemohon', 'type' => 'text'],
            ['name' => 'nik_pemohon', 'label' => 'NIK Pemohon', 'placeholder' => 'Masukkan NIK Pemohon', 'type' => 'text'],
            ['name' => 'nomor_kk_pemohon', 'label' => 'Nomor KK Pemohon', 'placeholder' => 'Nomor KK Pemohon', 'type' => 'text'],
            ['name' => 'alamat', 'label' => 'Alamat Pemohon', 'placeholder' => 'Alamat Pemohon', 'type' => 'textarea'],
        ],
        'files' => [
            ['name' => 'formulir_f201', 'label' => 'Formulir F2.01 yang Telah Diisi'],
            ['name' => 'ktp_pemohon', 'label' => 'KTP Pemohon'],
            ['name' => 'ktp_saksi1', 'label' => 'KTP Saksi 1'],
            ['name' => 'ktp_saksi2', 'label' => 'KTP Saksi 2'],
            ['name' => 'kk_pemohon', 'label' => 'Kartu Keluarga Pemohon'],
            ['name' => 'file_surat_lahir', 'label' => 'Surat Keterangan Lahir (RS/Bidan/Nakhoda/Kades)'],
            ['name' => 'file_buku_nikah', 'label' => 'Buku Nikah / Akta Perkawinan'],
            ['name' => 'file_sptjm_kelahiran', 'label' => 'SPTJM Kebenaran Data Kelahiran (F-2.03) - Jika tidak ada surat lahir', 'required' => false],
            ['name' => 'file_sptjm_pasutri', 'label' => 'SPTJM Kebenaran Pasangan Suami Istri (F-2.04) - Jika tidak ada buku nikah', 'required' => false],
            ['name' => 'file_berita_acara_polisi', 'label' => 'Berita Acara Kepolisian - Untuk anak tidak diketahui asal usulnya', 'required' => false],
        ],
    ],
    3 => [
        'icon'  => 'fa-user-times',
        'color' => 'orange',
        'id'    => 'akte_kematian',
        'persyaratan' => [
            'Wajib Mengambil Nomor Antrian',
            'Formulir F-2.01 (Formulir Permohonan Pencatatan Kematian) <a href="'.route('unduh-formulir').'" class="text-blue-600 font-bold hover:underline ml-1" target="_blank"><i class="fas fa-download mr-1"></i>Unduh di Sini</a>',
            'Fotokopi surat kematian dari dokter atau kepala desa/lurah',
            'Fotokopi KK/KTP yang meninggal dunia.',
            'Fotokopi KK/KTP pemohon.',
            'Fotokopi KK/KTP saksi 1 dan saksi 2 yang mengetahui kematian.',
        ],
        'penjelasan' => [
            'Mengisi formulir F-2.01',
            'WNI melampirkan fotokopi KK untuk verifikasi data.',
            'Untuk pelayanan online/Daring, persyaratan yang discan/difoto untuk diunggah harus aslinya.',
            'Seluruh informasi terkait jenazah dan saksi dilampirkan melalui isian Formulir F-2.01.',
        ],
        'fields' => [
            ['name' => 'layanan_id', 'value' => '3', 'type' => 'hidden'],
            ['type' => 'heading', 'label' => 'Informasi Pengajuan'],
            ['name' => 'nomor_antrian', 'label' => 'Nomor Antrian', 'placeholder' => 'Masukkan Nomor Antrian', 'type' => 'text',],
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
    4 => [
        'icon'  => 'fa-exclamation-triangle',
        'color' => 'orange',
        'id'    => 'lahir_mati',
        'persyaratan' => [
            'Wajib Mengambil Nomor Antrian',
            'Mengisi Formulir F-2.01 (Formulir Permohonan Pencatatan Kelahiran Mati) <a href="'.route('unduh-formulir').'" class="text-blue-600 font-bold hover:underline ml-1" target="_blank"><i class="fas fa-download mr-1"></i>Unduh di Sini</a>',
            'Fotokopi surat keterangan lahir mati (RS/Bidan/Kades).',
            'Fotokopi KK Orang Tua.',
            'Fotokopi Saksi 1 dan Saksi 2 yang mengetahui peristiwa lahir mati.',
        ],
        'penjelasan' => [
            'WNI melampirkan fotokopi KK untuk verifikasi data.',
            'Untuk pelayanan online/Daring, persyaratan yang discan/difoto untuk diunggah harus aslinya.',
            'Seluruh informasi terkait jenazah (bayi) dan orang tua dilampirkan melalui isian Formulir F-2.01.',
        ],
        'fields' => [
            ['name' => 'layanan_id', 'value' => '4', 'type' => 'hidden'],
            ['type' => 'heading', 'label' => 'Informasi Pengajuan'],
            ['name' => 'nomor_antrian', 'label' => 'Nomor Antrian', 'placeholder' => 'Masukkan Nomor Antrian', 'type' => 'text'],
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
    5 => [
        'icon'  => 'fa-ring',
        'color' => 'purple',
        'id'    => 'layanan-pernikahan',
        'persyaratan' => [
            'Wajib Mengambil Nomor Antrian',
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
    'red'    => ['bg' => '#FFF1F2', 'text' => '#BE123C', 'border' => '#FDA4AF', 'badge_bg' => '#FFE4E6', 'badge_text' => '#9F1239', 'icon_bg' => '#FCEBEB'],
];

$layananById = \App\Models\Layanan_Model::whereIn('layanan_id', collect($kategoriLayanan)->pluck('layanan')->flatten()->toArray())->get()->keyBy('layanan_id');
@endphp

<main class="pt-0">
    {{-- Page Loading --}}
    <div id="pageLoading" class="page-loading">
        <div class="loading-logo bg-white rounded-2xl shadow-2xl overflow-hidden flex items-center justify-center">
            <img src="{{ asset('images/logo_toba.jpeg') }}" alt="Logo Kabupaten Toba" class="w-full h-full object-contain p-3">
        </div>
        <div class="loading-spinner"></div>
        <div class="loading-text">Disdukcapil Kabupaten Toba</div>
        <div class="loading-subtext">Memuat layanan mandiri...</div>
        <div class="loading-dots"><span></span><span></span><span></span></div>
    </div>

    {{-- Hero --}}
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

    {{-- ===================== KATEGORI GRID 2x2 ===================== --}}
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

            {{-- Grid 2x2 Kategori --}}
            <div class="grid grid-cols-2 gap-4 reveal">
                @foreach($kategoriLayanan as $namaKategori => $kategoriConfig)
                    @php
                        $c = $colorMap[$kategoriConfig['color']] ?? $colorMap['blue'];
                        $jumlah = count($kategoriConfig['layanan']);

                        // Kumpulkan data layanan untuk modal
                        $layananList = [];
                        foreach ($kategoriConfig['layanan'] as $lid) {
                            $layanan = $layananById[$lid] ?? null;
                            $config  = $serviceConfig[$lid] ?? null;
                            if (!$layanan || !$config) continue;
                            $layananList[] = [
                                'lid'      => $lid,
                                'name'     => $layanan->nama_layanan,
                                'desc'     => $layanan->keterangan ?? str_replace('Penerbitan ', '', $layanan->nama_layanan),
                                'icon'     => $config['icon'],
                                'config'   => $config,
                            ];
                        }
                        $layananListJson = json_encode($layananList);
                    @endphp

                    <button
                        onclick='openKategoriModal({{ $layananListJson }}, {{ json_encode($namaKategori) }}, {{ json_encode($c) }}, {{ json_encode($kategoriConfig["icon"]) }})'
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
                                <i class="fas fa-arrow-right text-[10px]"></i> Lihat Layanan
                            </span>
                        </div>
                    </button>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Keuntungan --}}
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

{{-- ===================== MODAL 1: PILIH LAYANAN DALAM KATEGORI ===================== --}}
<div id="kategoriModal" class="fixed inset-0 z-40 hidden overflow-y-auto">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="closeKategoriModal()"></div>
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md relative z-10 overflow-hidden" style="animation: popIn 0.2s ease;">
            {{-- Header --}}
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
            {{-- Daftar Layanan --}}
            <div id="km-list" class="p-3 space-y-1 max-h-[60vh] overflow-y-auto"></div>
            <div class="px-5 py-3 border-t border-gray-100">
                <p class="text-xs text-gray-400 text-center">Siapkan berkas pendukung pada halaman selanjutnya dalam format PDF dengan ukuran maksimal 200 KB per file.</p>
            </div>
        </div>
    </div>
</div>

{{-- ===================== MODAL 2: FORM SERVICE (5 STEP) ===================== --}}
<div id="serviceModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full max-h-[92vh] overflow-y-auto transform transition-all relative z-10" id="modalContent">
            {{-- Sticky Header + Steps --}}
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
                {{-- Step Indicators --}}
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
                <input type="hidden" name="foto_wajah" id="foto_wajah">

                {{-- Step 1: Informasi --}}
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
                            <h4 class="font-bold text-gray-800 text-sm">Persyaratan Dokumen yang Dibutuhkan</h4>
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

                {{-- Step 2: Data --}}
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

                {{-- Step 3: Berkas --}}
                <div id="step3" class="step-content p-5 space-y-4 hidden">
                    <p class="text-sm text-gray-500 mb-1">Upload berkas persyaratan dalam format <strong>PDF</strong>. Pastikan dokumen terbaca dengan jelas.</p>
                    <div id="fileFields" class="space-y-4"></div>
                    <div class="flex gap-3 mt-6 pt-4 border-t border-gray-100">
                        <button type="button" onclick="goToStep(2)"
                                class="flex-1 py-3 border-2 border-gray-200 text-gray-600 rounded-xl font-bold hover:bg-gray-50 transition flex items-center justify-center gap-2">
                            <i class="fas fa-arrow-left text-sm"></i> Kembali
                        </button>
                        <button type="button" onclick="validateAndGoStep4()"
                                class="flex-1 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-bold hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg flex items-center justify-center gap-2">
                            Selanjutnya <i class="fas fa-arrow-right text-sm"></i>
                        </button>
                    </div>
                </div>

                {{-- Step 4: Verifikasi Wajah --}}
                <div id="step4" class="step-content p-5 space-y-4 hidden">
                    <h3 class="font-bold text-lg text-gray-800">Verifikasi Wajah</h3>
                    <p class="text-sm text-gray-500">Kedipkan mata <strong>2 kali</strong> di depan kamera untuk membuktikan Anda bukan robot.</p>
                    <div class="relative rounded-2xl overflow-hidden border-2 border-gray-200 bg-black">
                        <video id="video" autoplay playsinline muted class="w-full rounded-xl" style="max-height:260px; object-fit:cover;"></video>
                        <canvas id="canvas" class="hidden"></canvas>
                        <div id="liveness-overlay" class="absolute bottom-0 left-0 right-0 bg-black/50 text-white text-center py-2 text-sm font-semibold">
                            Tekan "Mulai Verifikasi" untuk mengaktifkan kamera
                        </div>
                    </div>
                    <div class="flex items-center gap-3 bg-blue-50 border border-blue-200 rounded-xl px-4 py-3">
                        <div class="flex gap-2">
                            <span id="blink-dot-1" class="w-8 h-8 rounded-full border-2 border-gray-300 flex items-center justify-center text-xs font-bold text-gray-400">1</span>
                            <span id="blink-dot-2" class="w-8 h-8 rounded-full border-2 border-gray-300 flex items-center justify-center text-xs font-bold text-gray-400">2</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-700">Kedipan terdeteksi: <span id="blinkCount">0</span>/2</p>
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

                {{-- Step 5: Konfirmasi --}}
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
    #stepLine1.done, #stepLine2.done, #stepLine3.done, #stepLine4.done { background: #16a34a; }
    .step-content { animation: fadeSlide 0.3s ease-out; }
    @keyframes fadeSlide { from { opacity: 0; transform: translateX(18px); } to { opacity: 1; transform: translateX(0); } }
    @keyframes popIn { from { opacity: 0; transform: scale(0.95) translateY(8px); } to { opacity: 1; transform: scale(1) translateY(0); } }
    .form-input {
        width: 100%; padding: 0.6rem 1rem;
        border: 2px solid #e5e7eb; border-radius: 0.75rem;
        font-size: 0.875rem; transition: border-color 0.2s;
        outline: none; background: #fff;
    }
    .form-input:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px #dbeafe; }

    /* Layanan item hover */
    .layanan-item { transition: background 0.15s; }
    .layanan-item:hover { background: #f9fafb; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@mediapipe/face_mesh/face_mesh.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js" crossorigin="anonymous"></script>
<script>
let currentStep        = 1;
let currentConfig      = {};
let currentServiceName = '';
let mpCamera           = null;
let faceMeshInstance   = null;
let blinkCount         = 0;
let eyeClosed          = false;
let livenessStarted    = false;

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

function openKategoriModal(layananList, namaKategori, colors, iconClass) {
    document.getElementById('km-title').textContent = namaKategori;
    document.getElementById('km-sub').textContent   = layananList.length + ' layanan tersedia';

    const iconEl = document.getElementById('km-icon');
    iconEl.style.background = colors.icon_bg;
    iconEl.innerHTML = `<i class="fas ${iconClass} text-lg" style="color:${colors.text}"></i>`;

    const list = document.getElementById('km-list');
    list.innerHTML = layananList.map(item => `
        <div class="layanan-item flex items-center gap-3 px-3 py-3 rounded-xl cursor-pointer"
             onclick='selectLayanan(${JSON.stringify(item.config)}, ${JSON.stringify(item.name)})'>
            <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0"
                 style="background: ${colors.icon_bg}">
                <i class="fas ${item.icon} text-sm" style="color:${colors.text}"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-800 leading-tight">${item.name}</p>
                <p class="text-xs text-gray-400 mt-0.5 truncate">${item.desc}</p>
            </div>
            <div class="flex-shrink-0">
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold"
                      style="background: ${colors.badge_bg}; color: ${colors.badge_text}">
                    Pilih <i class="fas fa-chevron-right text-[9px]"></i>
                </span>
            </div>
        </div>
    `).join('');

    document.getElementById('kategoriModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeKategoriModal() {
    document.getElementById('kategoriModal').classList.add('hidden');
    if (document.getElementById('serviceModal').classList.contains('hidden')) {
        document.body.style.overflow = 'auto';
    }
}
function selectLayanan(config, serviceName) {
    closeKategoriModal();
    openServiceModal(config, serviceName);
}
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
        if (field.type === 'heading')
            return `<div class="col-span-1 md:col-span-2 mt-4 mb-1 border-b border-gray-200 pb-2">
                        <h3 class="text-xs font-bold text-gray-600 uppercase tracking-wider">${field.label}</h3>
                    </div>`;
        const fullWidth = field.type === 'textarea' ? 'md:col-span-2' : '';
        return `<div class="${fullWidth}">
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
    if (field.name && (field.name.toLowerCase().includes('nik') || field.name.toLowerCase().includes('nomor_kk'))) {
        extraAttr = `oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16);" maxlength="16"`;
    }
    if (field.type === 'textarea')
        return `<textarea name="${field.name}" placeholder="${field.placeholder||''}" class="${cls} h-24 resize-none" required></textarea>`;
    if (field.type === 'select')
        return `<select name="${field.name}" class="${cls}" required>
            <option value="">Pilih...</option>
            ${(field.options||[]).map(o=>`<option value="${o}">${o}</option>`).join('')}
        </select>`;
    return `<input type="${field.type}" name="${field.name}" placeholder="${field.placeholder||''}" class="${cls}" ${extraAttr} ${field.required !== false ? 'required' : ''}>`;
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
        if (i < 5) {
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
        .querySelectorAll('input[required],textarea[required],select[required]');
    let valid = true;
    let errMsg = 'Harap lengkapi semua data yang diperlukan.';
    inputs.forEach(input => {
        input.style.borderColor = '';
        let val = input.value.trim();
        if (!val) { input.style.borderColor = '#ef4444'; valid = false; }
        else if (val && (input.name.toLowerCase().includes('nik') || input.name.toLowerCase().includes('nomor_kk')) && val.length !== 16) {
            input.style.borderColor = '#ef4444';
            valid = false;
            errMsg = `Nomor harus tepat 16 angka!`;
        }
    });
    if (!valid) { showToast(errMsg, 'error'); return; }
    goToStep(3);
}

function validateAndGoStep4() {
    let valid = true;
    let missingLabel = '';
    currentConfig.files.forEach(file => {
        if (file.required === false) return;
        const input = document.querySelector(`input[name="${file.name}"]`);
        if (!input || !input.files || input.files.length === 0) {
            if (!missingLabel) missingLabel = file.label;
            valid = false;
            const lbl = input ? input.closest('label') : null;
            if (lbl) {
                lbl.classList.add('border-red-400', 'bg-red-50');
                input.addEventListener('change', () => lbl.classList.remove('border-red-400','bg-red-50'), { once: true });
            }
        }
    });
    if (!valid) { showToast(`Harap upload berkas: ${missingLabel}`, 'error'); return; }
    goToStep(4);
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

const LEFT_EYE_IDX  = [33, 160, 158, 133, 153, 144];
const RIGHT_EYE_IDX = [362, 385, 387, 263, 373, 380];

function computeEAR(p1,p2,p3,p4,p5,p6) {
    const d = (a,b) => Math.hypot(a.x-b.x, a.y-b.y);
    return (d(p2,p6) + d(p3,p5)) / (2 * d(p1,p4));
}
function getEAR(lm) {
    const l = (i) => lm[i];
    const earL = computeEAR(l(LEFT_EYE_IDX[0]),l(LEFT_EYE_IDX[1]),l(LEFT_EYE_IDX[2]),l(LEFT_EYE_IDX[3]),l(LEFT_EYE_IDX[4]),l(LEFT_EYE_IDX[5]));
    const earR = computeEAR(l(RIGHT_EYE_IDX[0]),l(RIGHT_EYE_IDX[1]),l(RIGHT_EYE_IDX[2]),l(RIGHT_EYE_IDX[3]),l(RIGHT_EYE_IDX[4]),l(RIGHT_EYE_IDX[5]));
    return (earL + earR) / 2;
}
function detectBlink(landmarks) {
    const ear = getEAR(landmarks);
    if (ear < BLINK_THRESHOLD && !eyeClosed) { eyeClosed = true; }
    else if (ear >= BLINK_THRESHOLD && eyeClosed) {
        eyeClosed = false;
        blinkCount++;
        updateBlinkUI();
        if (blinkCount >= BLINK_TARGET) onLivenessPassed();
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
    const video  = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    canvas.width  = video.videoWidth  || 640;
    canvas.height = video.videoHeight || 480;
    const ctx = canvas.getContext('2d');
    ctx.translate(canvas.width, 0); ctx.scale(-1, 1);
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
    document.getElementById('foto_wajah').value = canvas.toDataURL('image/jpeg', 0.85);
    stopCamera();
    document.getElementById('liveness_passed').value = '1';
    document.getElementById('btnStartLiveness').disabled = true;
    const preview = document.createElement('img');
    preview.src = document.getElementById('foto_wajah').value;
    preview.className = 'w-full rounded-xl';
    preview.style.maxHeight = '260px';
    preview.style.objectFit = 'cover';
    preview.id = 'foto-preview';
    video.style.display = 'none';
    video.parentNode.insertBefore(preview, video);
    document.getElementById('liveness-overlay').textContent = '✓ Foto berhasil diambil!';
    document.getElementById('liveness-overlay').classList.replace('bg-black/50','bg-green-600/80');
    showToast('Verifikasi wajah berhasil! Foto tersimpan.', 'success');
    setTimeout(() => goToStep(5), 900);
}
function setOverlay(text) { document.getElementById('liveness-overlay').textContent = text; }
function startLiveness() {
    if (livenessStarted) return;
    livenessStarted = true;
    const errEl = document.getElementById('liveness-error');
    errEl.classList.add('hidden');
    document.getElementById('btnStartLiveness').disabled = true;
    setOverlay('Meminta izin kamera...');
    navigator.mediaDevices.getUserMedia({ video: true }).then((stream) => {
        stream.getTracks().forEach(t => t.stop());
        setOverlay('Mengaktifkan algoritma wajah...');
        const video = document.getElementById('video');
        faceMeshInstance = new FaceMesh({ locateFile: (f) => `https://cdn.jsdelivr.net/npm/@mediapipe/face_mesh/${f}` });
        faceMeshInstance.setOptions({ maxNumFaces:1, refineLandmarks:true, minDetectionConfidence:0.5, minTrackingConfidence:0.5 });
        faceMeshInstance.onResults((results) => {
            if (!results.multiFaceLandmarks || !results.multiFaceLandmarks.length) {
                setOverlay('Wajah tidak terdeteksi — pastikan wajah terlihat jelas'); return;
            }
            setOverlay('Kedipkan mata 2 kali secara natural…');
            detectBlink(results.multiFaceLandmarks[0]);
        });
        mpCamera = new Camera(video, {
            onFrame: async () => { if (faceMeshInstance) await faceMeshInstance.send({ image: video }); },
            width: 640, height: 480
        });
        mpCamera.start().then(() => setOverlay('Kedipkan mata 2 kali secara natural…'))
            .catch(err => {
                errEl.textContent = 'Gagal render MediaPipe: ' + (err.message || err);
                errEl.classList.remove('hidden');
                setOverlay('Gagal mengakses kamera');
                livenessStarted = false;
                document.getElementById('btnStartLiveness').disabled = false;
            });
    }).catch(err => {
        errEl.textContent = 'Kamera diblokir. Cek izin browser. (' + err.name + ')';
        errEl.classList.remove('hidden');
        setOverlay('Izin kamera ditolak');
        livenessStarted = false;
        document.getElementById('btnStartLiveness').disabled = false;
    });
}
function stopCamera() { if (mpCamera) { mpCamera.stop(); mpCamera = null; } }
function resetLiveness() {
    blinkCount = 0; eyeClosed = false; livenessStarted = false; faceMeshInstance = null;
    const old = document.getElementById('foto-preview');
    if (old) old.remove();
    document.getElementById('video').style.display = '';
    document.getElementById('foto_wajah').value = '';
    document.getElementById('blinkCount').textContent = '0';
    document.getElementById('liveness_passed').value = '0';
    document.getElementById('liveness-overlay').textContent = 'Tekan "Mulai Verifikasi" untuk mengaktifkan kamera';
    document.getElementById('liveness-overlay').className = 'absolute bottom-0 left-0 right-0 bg-black/50 text-white text-center py-2 text-sm font-semibold';
    const btn = document.getElementById('btnStartLiveness');
    if (btn) btn.disabled = false;
    for (let i = 1; i <= BLINK_TARGET; i++) {
        const dot = document.getElementById(`blink-dot-${i}`);
        if (dot) { dot.className = 'w-8 h-8 rounded-full border-2 border-gray-300 flex items-center justify-center text-xs font-bold text-gray-400'; dot.textContent = i; }
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
@if(session('error'))
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({ icon:'error', title:'Gagal Memproses!', html:'{!! session("error") !!}', confirmButtonColor:'#d33' });
    });
@endif
@if(session('success'))
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({ icon:'success', title:'Berhasil Terkirim!', text:'{{ session("success") }}', confirmButtonColor:'#16a34a' });
    });
@endif
</script>
@endpush
@endsection