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
            ['name' => 'nomor_registrasi', 'label' => 'Nomor Registrasi', 'placeholder' => 'Nomor Registrasi', 'type' => 'text'],
            ['name' => 'nama', 'label' => 'Nama Kepala Keluarga', 'placeholder' => 'Nama Kepala Keluarga', 'type' => 'text'],
            ['name' => 'alamat', 'label' => 'Alamat', 'placeholder' => 'Alamat', 'type' => 'textarea'],
            ['name' => 'nik', 'label' => 'Nomor Induk Kependudukan', 'placeholder' => 'Nomor Induk Kependudukan', 'type' => 'text']
        ],
        'files' => [
            ['name' => 'formulir_f102', 'label' => 'Formulir F1.02'],
            ['name' => 'kk_lama', 'label' => 'Kartu Keluarga Sebelumnya'],
            ['name' => 'formulir_f106', 'label' => 'Formulir F1.06'],
            ['name' => 'surat_keterangan_perubahan', 'label' => 'Surat Keterangan Bukti Peristiwa Kependudukan dan Peristiwa Penting'],
            ['name' => 'pernyataan_pindah_kk', 'label' => 'Surat Pernyataan Pengasuhan dari Orang Tua jika Pindah KK dan Penyataan Bersedia Menampung dari Kepala Keluarga yang ditumpangi (Diwajibkan Jika Pindah KK)', 'required' => false],
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
            'Dalam hal seluruh anggota keluarga masih berusia di bawah 17 tahun, maka diperlukan kepala keluarga yang telah dewasa. Solusinya adalah ada Saudara yang bersedia pindah menjadi Kepala Keluarga di dalam Keluarga ini atau anak-anak dimaksud dititipkan pada Kartu Keluarga Saudaranya yang terdekat dengan membuat surat pernyataan bersedia menjadi wali',
            'Dinas menerbitkan KK Baru.Catatan:Untuk pelayanan online/Daring, persyaratan yang discan/difoto untuk diunggah harus aslinya'
        ],
        'fields'       => [
            ['name' => 'layanan_id',       'value' => '6',  'type' => 'hidden'],
            ['name' => 'nomor_registrasi', 'label' => 'Nomor Registrasi', 'placeholder' => 'Nomor Registrasi', 'type' => 'text'],
            ['name' => 'nama', 'label' => 'Nama',   'placeholder' => 'Nama sesuai KTP',           'type' => 'text'],
            ['name' => 'nik',  'label' => 'NIK',    'placeholder' => '16 digit NIK',              'type' => 'number'],
            ['name' => 'alamat', 'label' => 'Alamat',   'placeholder' => 'Alamat',           'type' => 'textarea'],
        ],
        'files' => [
            ['name' => 'formulir_f102', 'label' => 'Formulir F-1.02 yang Telah Diisi'],
            ['name' => 'fotokopi_akta_kematian', 'label' => 'Akte Kematian Kepala Keluarga'],
            ['name' => 'kk_lama', 'label' => 'Kartu Keluarga Lama'],
            ['name' => 'surat_pernyataan_wali', 'label' => 'Surat Pernyataan Wali (Jika seluruh anggota keluarga masih berusia di bawah 17 tahun)','required'=> false]
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
            'Dasar Hukum Pasal 13 Perpres 96/2018'
        ],
        'penjelasan'   => [
            'Penduduk mengisi F.1.02 dan tidak perlu melampirkan fotokopi KTP-el karena NIK telah diisi di F.1.02',
            'Penduduk menyerahkan dokumen KK yang rusak/surat keterangan kehilangan dari kepolisian kepada Dinas untuk digantikan dengan KK yang baru.'
        ],
        'fields'       => [
            ['name' => 'layanan_id',       'value' => '7',  'type' => 'hidden'],
            ['name' => 'nomor_registrasi', 'label' => 'Nomor Registrasi', 'placeholder' => 'Nomor Registrasi', 'type' => 'text'],
            ['name' => 'nama', 'label' => 'Nama',   'placeholder' => 'Nama sesuai KTP',           'type' => 'text'],
            ['name' => 'nik',  'label' => 'NIK',    'placeholder' => '16 digit NIK',              'type' => 'number'],
            ['name' => 'alamat', 'label' => 'Alamat',   'placeholder' => 'Alamat',           'type' => 'textarea'],
        ],
        'files' => [
            ['name' => 'suket_hilang_rusak', 'label' => 'Surat Kehilangan dari Polisi atau KK Rusak'],
            ['name' => 'fotokopi_ktp', 'label' => 'Fotokopi KTP'],
            ['name' => 'fotokopi_izin_tinggal', 'label' => 'Fotokopi kartu izin tinggal tetap (untuk OA)','required'=> false]
        ],
    ],

    8 => [
        'icon'         => 'fa-people-arrows',
        'color'        => 'blue',
        'id'           => 'pisah_kk',
        'persyaratan'  => [
            'KK lama',
            'Berumur sekurang-kurangnya 17 (tujuh belas) tahun atau sudah kawin atau pernah kawin yang dibuktikan dengan kepemilikan KTP-el.',
            'Dasar hukum Pasal 10 ayat (4) Permendagri 108/2019',
        ],
        'penjelasan'   => [
            'Penduduk mengisi F-1.02',
            'Penduduk melampirkan fotokopi buku nikah atau akta perceraian (jika disebabkan pernikahan atau perceraian)',
            'Penduduk melampirkan KK lama',
        ],
        'fields'       => [
            ['name' => 'layanan_id',    'value' => '8',  'type' => 'hidden'],
            ['name' => 'nomor_registrasi', 'label' => 'Nomor Registrasi', 'placeholder' => 'Nomor Registrasi', 'type' => 'text'],
            ['name' => 'nama',          'label' => 'Nama Kepala KK Baru', 'placeholder' => 'Nama sesuai KTP', 'type' => 'text'],
            ['name' => 'nik',           'label' => 'NIK', 'placeholder' => '16 digit NIK', 'type' => 'number'],
            ['name' => 'alamat',        'label' => 'Alamat Baru', 'placeholder' => 'Masukkan alamat', 'type' => 'textarea'],
        ],
        'files' => [
            ['name' => 'formulir_f102', 'label' => 'Formulir F1.02 yang Telah Diisi'],
            ['name' => 'fotokopi_buku_nikah', 'label' => 'Buku nikah atau akta perceraian (jika disebabkan pernikahan atau perceraian)', 'required'=> false],
            ['name' => 'kk_lama', 'label' => 'Fotokopi KK Lama'],
        ],
    ],

    // AKTE KELAHIRAN 
    2 => [
        'icon'         => 'fa-baby',
        'color'        => 'green',
        'id'           => 'akte_kelahiran',
        'persyaratan'  => [
            'Surat keterangan kelahiran yaitu dari rumah sakit/Puskesmas/fasilitas kesehatan/dokter/bidan atau surat keterangan kelahiran dari nakhoda kapal laut/kapten pesawat terbang, atau dari kepala desa/lurah jika lahir di rumah/ tempat lain, antara lain: kebun, sawah, angkutan umum.',
            'Buku nikah/kutipan akta perkawinan/bukti lain yang sah',
            'KK dimana penduduk terdaftar atau akan didaftarkan sebagai anggota keluarga',
            'Berita acara dari kepolisian bagi anak yang tidak diketahui asal usulnya/keberadaan orang tuanya',
            'Penduduk dapat membuat SPTJM kebenaran data kelahiran dengan mengisi F-2.03 dan 2 (dua) orang saksi, jika tidak memenuhi persyaratan sebagaimana huruf a',
            'Penduduk dapat membuat SPTJM kebenaran sebagai pasangan suami istri dengan mengisi F-2.04 dan 2 (dua) orang saksi, jika tidak memenuhi persyaratatan sebagaimana huruf b'
        ],
        'penjelasan'   => [
            'Mengisi formulir F-2.01',
            'Untuk pelayanan secara offline/tatap muka, persyaratan surat keterangan kelahiran yang diserahkan berupa fotokopi bukan asli (asli hanya diperlihatkan)',
            'Untuk pelayanan online/daring, persyaratan yang discan/ difoto untuk diunggah harus aslinya',
            'Petugas melakukan verifikasi berkas',
            'WNI melampirkan Fotokopi KK untuk verifikasi data yang tercantum dalam formulir F-2.01',
            'WNI tidak perlu melampirkan fotokopi KTP-el saksi, karena identitas saksi sudah tercantum dalam formulir F-2.01',
        ],
        'fields'       => [
            ['name' => 'layanan_id',       'value' => '2',  'type' => 'hidden'],
            ['name' => 'nomor_registrasi', 'label' => 'Nomor Registrasi', 'placeholder' => 'Masukkan Nomor Registrasi',   'type' => 'text'],

            // Data Pelapor
            ['name' => 'nama_pelapor', 'label' => 'Nama Pelapor','placeholder' => 'Masukkan Nama Pelapor','type' => 'text'],
            ['name' => 'nik_pelapor','label' => 'NIK','placeholder' => 'Masukkan NIK Pelapor','type' => 'text'],
            ['name' => 'nomor_dokumen','label' => 'Nomor Dokumen Perjalanan', 'placeholder' => 'Masukkan Nomor Dokumen Perjalanan', 'type' => 'text'],
            ['name' => 'nomor_kk','label' => 'Nomor Kartu Keluarga', 'placeholder' => 'Masukkan Nomor Kartu Keluarga', 'type' => 'text'],
            ['name' => 'kewarganegaraan_pelapor','label' => 'Kewarganegaraan', 'placeholder' => 'Masukkan Kewarganegaraan', 'type' => 'text'],

            // Data Saksi
            ['name' => 'nama_saksi1','label' => 'Nama Saksi 1', 'placeholder' => 'Nama Saksi 1', 'type' => 'text'],
            ['name' => 'nik_saksi1','label' => 'NIK Saksi 1', 'placeholder' => 'NIK Saksi 1', 'type' => 'text'],
            ['name' => 'nomor_kk_saksi1','label' => 'Nomor KK Saksi 1', 'placeholder' => 'Nomor KK Saksi 1', 'type' => 'text'],
            ['name' => 'kewarganegaraan_saksi1','label' => 'Kewarganegaraan Saksi 1', 'placeholder' => 'Masukkan Kewarganegaraan Saksi 1', 'type' => 'text'],
            ['name' => 'nama_saksi2','label' => 'Nama Saksi 2', 'placeholder' => 'Nama Saksi 2', 'type' => 'text'],
            ['name' => 'nik_saksi2','label' => 'NIK Saksi 2', 'placeholder' => 'NIK Saksi 2', 'type' => 'text'],
            ['name' => 'nomor_kk_saksi2','label' => 'Nomor KK Saksi 2', 'placeholder' => 'Nomor KK Saksi 2', 'type' => 'text'],
            ['name' => 'kewarganegaraan_saksi2','label' => 'Kewarganegaraan Saksi 2', 'placeholder' => 'Masukkan Kewarganegaraan Saksi 2', 'type' => 'text'],

            // Data Orang Tua
            ['name' => 'nama_ayah','label' => 'Nama Ayah', 'placeholder' => 'Nama Ayah', 'type' => 'text'],
            ['name' => 'nik_ayah','label' => 'NIK Ayah', 'placeholder' => 'NIK Ayah', 'type' => 'text'],
            ['name' => 'tempat_lahir_ayah','label' => 'Tempat Lahir Ayah', 'placeholder' => 'Masukkan Tempat Lahir Ayah', 'type' => 'text'],
            ['name' => 'tanggal_lahir_ayah','label' => 'Tanggal Lahir Ayah', 'placeholder' => 'Masukkan Tanggal Lahir Ayah', 'type' => 'text'],
            ['name' => 'kewarganegaraan_ayah','label' => 'Kewarganegaraan Ayah', 'placeholder' => 'Masukkan Kewarganegaraan Ayah', 'type' => 'text'],
            ['name' => 'nama_ibu','label' => 'Nama Ibu', 'placeholder' => 'Nama Ibu', 'type' => 'text'],
            ['name' => 'nik_ibu','label' => 'NIK Ibu', 'placeholder' => 'NIK Ibu', 'type' => 'text'],
            ['name' => 'tempat_lahir_ibu','label' => 'Tempat Lahir Ibu', 'placeholder' => 'Masukkan Tempat Lahir Ibu', 'type' => 'text'],
            ['name' => 'tanggal_lahir_ibu','label' => 'Tanggal Lahir Ibu', 'placeholder' => 'Masukkan Tanggal Lahir Ibu', 'type' => 'text'],
            ['name' => 'kewarganegaraan_ibu','label' => 'Kewarganegaraan Ibu', 'placeholder' => 'Masukkan Kewarganegaraan Ibu', 'type' => 'text'],

            // Data Anak
            ['name' => 'nama_anak','label' => 'Nama Anak', 'placeholder' => 'Nama Anak', 'type' => 'text'],
            ['name' => 'jenis_kelamin','label' => 'Jenis Kelamin Anak', 'placeholder' => 'Jenis Kelamin Anak', 'type' => 'text'],
            ['name' => 'tempat_dilahirkan','label' => 'Tempat Dilahirkan', 'placeholder' => 'Mis: RS/RB, Puskesmas, Dll', 'type' => 'text'],
            ['name' => 'tempat_kelahiran','label' => 'Tempat Kelahiran', 'placeholder' => 'Tempat Kelahiran Anak', 'type' => 'text'],
            ['name' => 'hari_tanggal_lahir','label' => 'Hari/Tanggal Lahir', 'placeholder' => 'Hari/Tanggal Lahir', 'type' => 'text'],
            ['name' => 'pukul','label' => 'Pukul Lahir Anak', 'placeholder' => 'Mis: 08.00', 'type' => 'text'],
            ['name' => 'jenis_kelahiran','label' => 'Jenis Kelahiran Anak', 'placeholder' => 'Mis: Tunggal, Kembar 2, Kembar 3', 'type' => 'text'],
            ['name' => 'kelahiran_ke','label' => 'Kelahiran Ke', 'placeholder' => 'Mis: 1', 'type' => 'text'],
            ['name' => 'penolong','label' => 'Penolong Kelahiran Anak', 'placeholder' => 'Mis: Dokter, Bidan/Perawat, Dukun', 'type' => 'text'],
            ['name' => 'berat_bayi','label' => 'Berat Bayi', 'placeholder' => 'Satuan Kg, Mis: 10 Kg', 'type' => 'text'],
            ['name' => 'panjang_bayi','label' => 'Panjang Bayi', 'placeholder' => 'Satuan cm, Mis: 100 cm', 'type' => 'text'],
        ],
        'files' => [
            ['name' => 'file_surat_lahir', 'label' => 'Surat Keterangan Lahir (RS/Bidan/Nakhoda/Kades)'],
            ['name' => 'file_buku_nikah', 'label' => 'Buku Nikah / Akta Perkawinan'],
            ['name' => 'file_kk', 'label' => 'Kartu Keluarga (Asli/Scan)'],
            ['name' => 'file_sptjm_kelahiran', 'label' => 'SPTJM Kebenaran Data Kelahiran (F-2.03) - Jika tidak ada surat lahir','required'=>false],
            ['name' => 'file_sptjm_pasutri', 'label' => 'SPTJM Kebenaran Pasangan Suami Istri (F-2.04) - Jika tidak ada buku nikah','required'=>false],
            ['name' => 'file_berita_acara_polisi', 'label' => 'Berita Acara Kepolisian - Untuk anak tidak diketahui asal usulnya','required'=>false],
        ],
    ],

    // AKTE KEMATIAN 
    3 => [
            'icon' => 'fa-user-times',
            'color' => 'blue',
            'id' => 'akte_kematian',
            'persyaratan' => [
                'Fotokopi surat kematian dari dokter atau kepala desa/lurah atau yang disebut dengan nama lain...',
                'Fotokopi Dokumen Perjalanan Republik Indonesia bagi WNI bukan Penduduk atau Fotokopi Dokumen Perjalanan bagi OA.',
                'Fotokopi KK/KTP yang meninggal dunia.',
            ],
            'penjelasan' => [
                'Mengisi formulir F-2.01.',
                'Untuk pelayanan secara offline/tatap muka, persyaratan surat kematian yang diserahkan berupa fotokopi bukan asli (asli hanya diperlihatkan).',
                'Dinas tidak menarik surat kematian asli.',
                'WNI melampirkan fotokopi KK untuk verifikasi data yang tercantum dalam formulir F-2.01.',
                'Untuk pelayanan online/Daring, persyaratan yang discan/ difoto untuk diunggah harus aslinya.',
                'WNI dan OA tidak perlu melampirkan fotokopi KTP-el saksi, karena identitasnya sudah tercantum dalam formulir F-2.01.',
                'WNI bukan penduduk menyerahkan fotokopi dokumen perjalanan RI yang meninggal dunia.',
                'Pencatatan Kematian dilaporkan tidak hanya oleh anak atau ahli waris tetapi dapat juga dilaporkan oleh keluarga lainnya, termasuk ketua RT.',
                'Dalam hal subjek akta tidak tercantum dalam KK dan database kependudukan, kutipan akta kematian diterbitkan tanpa NIK.',
                'Dinas menerbitkan kutipan akta kematian.',
            ],
            'template_url' => '#',
            'fields' => [ 
            ['name' => 'layanan_id', 'value' => '3', 'type' => 'hidden'],
            ['name' => 'nomor_registrasi', 'label' => 'Nomor Registrasi (Opsional)', 'placeholder' => 'Masukkan Nomor Registrasi', 'type' => 'text', 'required' => false],
            ['type' => 'heading', 'label' => 'Data Pelapor'],
            ['name' => 'nik_pelapor', 'label' => 'NIK Pelapor', 'placeholder' => 'Masukkan 16 digit NIK Pelapor', 'type' => 'text', 'maxlength' => '16'],
            ['name' => 'nomor_kk_pelapor', 'label' => 'Nomor KK Pelapor (Opsional)', 'placeholder' => 'Masukkan Nomor KK Pelapor', 'type' => 'text', 'maxlength' => '16', 'required' => false],
            ['name' => 'nama_pelapor', 'label' => 'Nama Lengkap Pelapor', 'placeholder' => 'Masukkan Nama Lengkap Pelapor', 'type' => 'text'],
            ['name' => 'hubungan_pelapor', 'label' => 'Hubungan dengan Jenazah', 'placeholder' => 'Contoh: Anak / Suami / Saudara / Ketua RT', 'type' => 'text'],
            
            ['type' => 'heading', 'label' => 'Identitas Jenazah'],
            ['name' => 'nik_almarhum', 'label' => 'NIK Jenazah (Opsional)', 'placeholder' => 'Masukkan 16 digit NIK', 'type' => 'text', 'maxlength' => '16', 'required' => false],
            ['name' => 'nama_almarhum', 'label' => 'Nama Lengkap Jenazah', 'placeholder' => 'Masukkan Nama Lengkap Jenazah', 'type' => 'text'],
            
            ['type' => 'heading', 'label' => 'Rincian Kematian'],
            ['name' => 'tgl_meninggal', 'label' => 'Tanggal Kematian', 'placeholder' => 'Pilih Tanggal Kematian', 'type' => 'date'],
            ['name' => 'tempat_meninggal', 'label' => 'Tempat Kematian', 'placeholder' => 'Contoh: Rumah Sakit / Rumah / Perjalanan', 'type' => 'text'],
            ['name' => 'sebab_meninggal', 'label' => 'Sebab Kematian (Opsional)', 'placeholder' => 'Contoh: Sakit biasa / Kecelakaan / dll', 'type' => 'text', 'required' => false],
            ['name' => 'yang_menerangkan', 'label' => 'Yang Menerangkan Kematian (Opsional)', 'placeholder' => 'Contoh: Dokter / Kepala Desa / Polisi', 'type' => 'text', 'required' => false],
            
            ['type' => 'heading', 'label' => 'Data Saksi (Opsional)'],
            ['name' => 'nik_saksi_1', 'label' => 'NIK Saksi 1', 'placeholder' => 'Masukkan 16 digit NIK Saksi 1', 'type' => 'text', 'maxlength' => '16', 'required' => false],
            ['name' => 'nama_saksi_1', 'label' => 'Nama Lengkap Saksi 1', 'placeholder' => 'Masukkan Nama Lengkap Saksi 1', 'type' => 'text', 'required' => false],
            ['name' => 'nik_saksi_2', 'label' => 'NIK Saksi 2', 'placeholder' => 'Masukkan 16 digit NIK Saksi 2', 'type' => 'text', 'maxlength' => '16', 'required' => false],
            ['name' => 'nama_saksi_2', 'label' => 'Nama Lengkap Saksi 2', 'placeholder' => 'Masukkan Nama Lengkap Saksi 2', 'type' => 'text', 'required' => false],
        ],
        'files' => [
            ['name' => 'surat_keterangan_kematian', 'label' => 'Scan/Foto Asli Surat Kematian'],
            ['name' => 'kartu_keluarga', 'label' => 'Scan/Foto Asli KK yang Meninggal (Opsional)', 'required' => false],
            ['name' => 'ktp_almarhum', 'label' => 'Scan/Foto Asli KTP yang Meninggal (Opsional)', 'required' => false],
            ['name' => 'dokumen_perjalanan', 'label' => 'Dokumen Perjalanan (Opsional - Khusus Orang Asing)', 'required' => false],
        ],
    ],
    4 => [
            'icon' => 'fa-exclamation-triangle',
            'color' => 'blue',
            'id' => 'lahir_mati',
            'persyaratan' => [
                'Fotokopi surat keterangan lahir mati, yaitu dari rumah sakit/Puskesmas/ fasilitas kesehatan/dokter/bidan, surat keterangan lahir mati dari nakhoda kapal laut/kapten pesawat terbang, atau dari kepala desa/lurah jika lahir mati di rumah/tempat lain.',
                'Fotokopi KK Orang Tua.',
            ],
            'penjelasan' => [
                'Mengisi formulir F-2.01.',
                'Untuk pelayanan secara offline/tatap muka, persyaratan surat keterangan lahir mati yang diserahkan berupa fotokopi bukan asli (asli hanya diperlihatkan).',
                'Dinas tidak menarik surat keterangan lahir mati asli.',
                'Melampirkan fotokopi KK untuk verifikasi data yang tercantum dalam formulir F-2.01.',
                'Untuk pelayanan online/Daring, persyaratan yang discan/ difoto untuk diunggah harus aslinya.',
                'Dinas menerbitkan surat keterangan lahir mati.',
            ],
            'template_url' => '#',
            'fields' => [
                ['name' => 'layanan_id', 'value' => '4', 'type' => 'hidden'],
                ['name' => 'nomor_registrasi', 'label' => 'Nomor Registrasi (Opsional)', 'placeholder' => 'Masukkan Nomor Registrasi', 'type' => 'text', 'required' => false],
                
                ['type' => 'heading', 'label' => 'Data Pelapor'],
                ['name' => 'nik_pelapor', 'label' => 'NIK Pelapor', 'placeholder' => 'Masukkan 16 digit NIK Pelapor', 'type' => 'text', 'maxlength' => '16'],
                ['name' => 'nama_pelapor', 'label' => 'Nama Lengkap Pelapor', 'placeholder' => 'Masukkan Nama Lengkap Pelapor', 'type' => 'text'],
                ['name' => 'hubungan_pelapor', 'label' => 'Hubungan dengan Bayi', 'placeholder' => 'Contoh: Ayah / Ibu / Bidan / Keluarga', 'type' => 'text'],
                
                ['type' => 'heading', 'label' => 'Rincian Lahir Mati'],
                ['name' => 'tgl_lahir', 'label' => 'Tanggal Lahir Mati', 'placeholder' => 'Pilih Tanggal Kejadian', 'type' => 'date'],
                ['name' => 'tempat_lahir', 'label' => 'Tempat Kejadian', 'placeholder' => 'Contoh: RS / Puskesmas / Rumah', 'type' => 'text'],
                ['name' => 'lama_kandungan', 'label' => 'Lama Kandungan (Bulan)', 'placeholder' => 'Berapa bulan usia kehamilan', 'type' => 'text'],
                ['name' => 'penolong_persalinan', 'label' => 'Penolong Persalinan', 'placeholder' => 'Contoh: Dokter / Bidan / Lainnya', 'type' => 'text'],
                
                ['type' => 'heading', 'label' => 'Data Bayi (Opsional)'],
                ['name' => 'nama_bayi', 'label' => 'Nama Bayi', 'placeholder' => 'Isi jika sudah diberi nama', 'type' => 'text', 'required' => false],
                ['name' => 'jenis_kelamin', 'label' => 'Jenis Kelamin Bayi', 'type' => 'select', 'options' => ['Laki-laki' => 'Laki-laki', 'Perempuan' => 'Perempuan'], 'required' => false],
                
                ['type' => 'heading', 'label' => 'Data Orang Tua'],
                ['name' => 'nik_ayah', 'label' => 'NIK Ayah', 'placeholder' => 'Masukkan 16 digit NIK Ayah', 'type' => 'text', 'maxlength' => '16'],
                ['name' => 'nama_ayah', 'label' => 'Nama Ayah', 'placeholder' => 'Masukkan Nama Lengkap Ayah', 'type' => 'text'],
                ['name' => 'nik_ibu', 'label' => 'NIK Ibu', 'placeholder' => 'Masukkan 16 digit NIK Ibu', 'type' => 'text', 'maxlength' => '16'],
                ['name' => 'nama_ibu', 'label' => 'Nama Ibu', 'placeholder' => 'Masukkan Nama Lengkap Ibu', 'type' => 'text'],

                ['type' => 'heading', 'label' => 'Data Saksi (Opsional)'],
                ['name' => 'nik_saksi_1', 'label' => 'NIK Saksi 1', 'placeholder' => 'Masukkan 16 digit NIK Saksi 1', 'type' => 'text', 'maxlength' => '16', 'required' => false],
                ['name' => 'nama_saksi_1', 'label' => 'Nama Lengkap Saksi 1', 'placeholder' => 'Masukkan Nama Lengkap Saksi 1', 'type' => 'text', 'required' => false],
                ['name' => 'nik_saksi_2', 'label' => 'NIK Saksi 2', 'placeholder' => 'Masukkan 16 digit NIK Saksi 2', 'type' => 'text', 'maxlength' => '16', 'required' => false],
                ['name' => 'nama_saksi_2', 'label' => 'Nama Lengkap Saksi 2', 'placeholder' => 'Masukkan Nama Lengkap Saksi 2', 'type' => 'text', 'required' => false],
            ],
            'files' => [
                ['name' => 'surat_keterangan_lahir_mati', 'label' => 'Scan/Foto Asli Surat Lahir Mati'],
                ['name' => 'kk_orangtua', 'label' => 'Scan/Foto Asli Kartu Keluarga (KK) Orang Tua'],
                ['name' => 'ktp_ayah', 'label' => 'Scan/Foto Asli KTP Ayah (Opsional)', 'required' => false],
                ['name' => 'ktp_ibu', 'label' => 'Scan/Foto Asli KTP Ibu (Opsional)', 'required' => false],
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
                'Petugas melakukan verifikasi dokumen',
                'Dinas menerbitkan Kutipan Akta Perkawinan',
            ],
            'template_url' => '#',
            'fields' => [
                ['name' => 'nomor_antrian', 'label' => 'Kode Antrian', 'type' => 'text', 'placeholder' => 'Masukkan kode antrian Anda'],
                ['name' => 'tanggal_perkawinan', 'label' => 'Tanggal Perkawinan', 'type' => 'date'],
                ['name' => 'nama_lengkap_suami', 'label' => 'Nama Suami Lengkap', 'type' => 'text', 'placeholder' => 'Nama sesuai KTP'],
                ['name' => 'nik_suami', 'label' => 'NIK Suami', 'type' => 'text', 'maxlength' => '16', 'placeholder' => '16 digit NIK'],
                ['name' => 'nama_lengkap_istri', 'label' => 'Nama Istri Lengkap', 'type' => 'text', 'placeholder' => 'Nama sesuai KTP'],
                ['name' => 'nik_istri', 'label' => 'NIK Istri', 'type' => 'text', 'maxlength' => '16', 'placeholder' => '16 digit NIK'],
            ],
            'files' => [
                ['name' => 'akta_pernikahan', 'label' => 'Upload Akta Pernikahan (Opsional)', 'required' => false],
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
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 lg:gap-6">
                @foreach($layananList as $layanan)
                    @php
                        $config = $serviceConfig[$layanan->layanan_id] ?? [
                            'icon' => 'fa-file-alt',
                            'color' => 'blue',
                            'id' => 'layanan-' . $layanan->layanan_id,
                            'fields' => [],
                            'files' => [],
                            'persyaratan' => [],
                            'penjelasan' => [],
                            'template_url' => '#',
                        ];
                        $serviceIcon = $config['icon'];
                        $serviceColor = $config['color'];
                        $serviceId = $config['id'];
                        $serviceName = $layanan->nama_layanan;
                        $shortDesc = $layanan->keterangan ?? str_replace('Penerbitan ', '', $layanan->nama_layanan);
                        $configJson = json_encode([
                            'id' => $config['id'],
                            'icon' => $config['icon'],
                            'color' => $config['color'],
                            'persyaratan' => $config['persyaratan'],
                            'penjelasan' => $config['penjelasan'],
                            'template_url' => $config['template_url'],
                            'fields' => $config['fields'],
                            'files' => $config['files'],
                        ]);
                    @endphp
                    <div class="reveal" style="animation-delay: {{ $loop->index * 100 }}ms">
                        <button id="btn-layanan-{{ $layanan->layanan_id }}" onclick='openServiceModal({{ $configJson }}, {{ json_encode($serviceName) }})'
                                class="service-card group bg-white rounded-2xl p-6 text-center
                                       hover:shadow-2xl transition-all duration-300 hover:-translate-y-1
                                       border-2 border-gray-100 hover:border-{{ $serviceColor }}-400 min-h-[180px] flex flex-col w-full">
                            <div class="flex-1">
                                <div class="w-16 h-16 bg-{{ $serviceColor }}-100 rounded-2xl flex items-center justify-center mx-auto mb-3
                                            group-hover:bg-{{ $serviceColor }}-500 transition-all duration-300 group-hover:scale-110">
                                    <i class="fas {{ $serviceIcon }} text-3xl text-{{ $serviceColor }}-600 group-hover:text-white transition-colors duration-300"></i>
                                </div>
                                <h3 class="font-bold text-gray-800 text-sm mb-2 leading-tight">{{ $serviceName }}</h3>
                                <p class="text-xs text-gray-500 leading-relaxed line-clamp-2">{{ $shortDesc }}</p>
                            </div>
                            <div class="mt-auto pt-3">
                                <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-{{ $serviceColor }}-50 text-{{ $serviceColor }}-700
                                             rounded-lg text-xs font-semibold group-hover:bg-{{ $serviceColor }}-500
                                             group-hover:text-white transition-all duration-300">
                                    <i class="fas fa-plus text-xs"></i>
                                    <span>Pilih</span>
                                </span>
                            </div>
                        </button>
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
                    @foreach(['Informasi','Data','Berkas','Konfirmasi'] as $i => $stepName)
                    <div class="flex-1 flex flex-col items-center">
                        <div class="step-indicator w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold mb-1 transition-all duration-300"
                             id="stepDot{{ $i+1 }}" data-step="{{ $i+1 }}">{{ $i+1 }}</div>
                        <span class="text-[9px] font-semibold step-label text-gray-400" id="stepLabel{{ $i+1 }}">{{ $stepName }}</span>
                    </div>
                    @if($i < 3)
                    <div class="flex-1 h-0.5 bg-gray-200 rounded mb-5" id="stepLine{{ $i+1 }}"></div>
                    @endif
                    @endforeach
                </div>
            </div>
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
                        <button type="button" onclick="goToStep(3)"
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
<script>
let currentStep = 1;
let currentConfig = {};
let currentServiceName = '';
const routeMap = {
    'kk':                  "{{ route('kk.store') }}",
    'akte_kelahiran':      "{{ route('aktelahir.store') }}",
    'ganti_kepala_kk':     "{{ route('kk.store.gantikepalakk') }}",
    'kk_hilang_rusak':     "{{ route('kk.store.hilangrusak') }}",
    'pisah_kk':            "{{ route('kk.store.pisahkk') }}"
};
function reveal() {
    document.querySelectorAll('.reveal').forEach(el => {
        if (el.getBoundingClientRect().top < window.innerHeight - 50) el.classList.add('active');
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
    const form = document.getElementById('serviceForm');
    form.action = routeMap[config.id] || '#';
    document.getElementById('infoLayanan').textContent =
        `Layanan ${serviceName} adalah layanan kependudukan yang dapat diajukan secara online melalui portal Disdukcapil Kabupaten Toba. Proses verifikasi dilakukan oleh petugas dalam 2–3 hari kerja.`
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
        if (field.type === 'hidden') return `<input type="hidden" name="${field.name}" value="${field.value}">`;
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
                ${file.required !== false ? '<span class="text-red-400">*</span>' : '<span class="text-gray-400 font-normal">(opsional)</span>'}
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
    if (field.type === 'textarea')
        return `<textarea name="${field.name}" placeholder="${field.placeholder||''}" class="${cls} h-24 resize-none" required></textarea>`;
    if (field.type === 'select')
        return `<select name="${field.name}" class="${cls}" required>
            <option value="">Pilih...</option>
            ${(field.options||[]).map(o=>`<option value="${o}">${o}</option>`).join('')}
        </select>`;
    return `<input type="${field.type}" name="${field.name}" placeholder="${field.placeholder||''}" class="${cls}" required>`;
}

function goToStep(step) {
    currentStep = step;
    document.querySelectorAll('.step-content').forEach(el => el.classList.add('hidden'));
    const active = document.getElementById('step' + step);
    if (active) { active.classList.remove('hidden'); active.style.animation='none'; active.offsetHeight; active.style.animation=''; }

    const labels = ['Informasi','Data','Berkas','Konfirmasi'];
    for (let i = 1; i <= 4; i++) {
        const dot = document.getElementById('stepDot' + i);
        const lbl = document.getElementById('stepLabel' + i);
        dot.className = 'step-indicator w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold mb-1 transition-all duration-300';
        lbl.className = 'text-[9px] font-semibold step-label text-gray-400';
        if (i < step)       { dot.classList.add('done');   dot.innerHTML = '<i class="fas fa-check text-[10px]"></i>'; lbl.classList.add('done'); }
        else if (i === step) { dot.classList.add('active'); dot.textContent = i; lbl.classList.add('active'); }
        else                 { dot.textContent = i; }
        if (i < 4) {
            const line = document.getElementById('stepLine' + i);
            if (line) line.className = 'flex-1 h-0.5 rounded mb-5 transition-all duration-500 ' + (i < step ? 'bg-green-400' : 'bg-gray-200');
        }
    }
    document.getElementById('modalStepLabel').textContent = `Langkah ${step} dari 4 — ${labels[step-1]}`;
    document.getElementById('modalContent').scrollTop = 0;
    if (step === 4) buildSummary();
}

function validateAndGoStep3() {
    const inputs = document.getElementById('step2').querySelectorAll('input[required],textarea[required],select[required]');
    let valid = true;
    inputs.forEach(input => { input.style.borderColor=''; if(!input.value.trim()){input.style.borderColor='#ef4444'; valid=false;} });
    if (!valid) { showToast('Harap lengkapi semua data yang diperlukan.','error'); return; }
    goToStep(3);
}

function buildSummary() {
    let html = '';
    currentConfig.fields.forEach(f => {
        if (f.type === 'hidden' || f.type === 'file') return;
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
    document.getElementById('serviceModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

document.getElementById('serviceForm').addEventListener('submit', function() {
    Swal.fire({ title:'Memproses...', allowOutsideClick:false, didOpen:()=>Swal.showLoading() });
});
</script>
@endpush
@endsection