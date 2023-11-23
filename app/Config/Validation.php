<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------
    public $tambah_guru = [
        'nip ' => [
            'rules'     => 'required|numeric|is_unique[tb_guru.nip]',
            'errors'    => [
                'is_unique' => 'NIP Sudah Terdaftar',
                'required'  => 'NIP Harus Diisi',
                'numeric'   => 'NIP Yang diisi Bukan angka'
            ]
        ],
        'nama_guru ' => [
            'rules'     => 'required',
            'errors'    => [
                'required'  => 'Nama Guru Harus Diisi',
            ]
        ],
        'tanggal_lahir ' => [
            'rules'     => 'required',
            'errors'    => [
                'required'  => 'Tanggal Lahir Harus Diisi',
            ]
        ],
        'jenis_kelamin ' => [
            'rules'     => 'required',
            'errors'    => [
                'required'  => 'Jenis Kelamin Harus Diisi',
            ]
        ],
        'min_jam ' => [
            'rules'     => 'required',
            'errors'    => [
                'required'  => 'Minimal Jam Mengajar Harus Diisi',
            ]
        ],
    ];
    public $update_guru = [
        'nip ' => [
            'rules'     => 'required|numeric',
            'errors'    => [
                'required'  => 'NIP Harus Diisi',
                'numeric'   => 'NIP Yang diisi Bukan angka'
            ]
        ],
        'nama_guru ' => [
            'rules'     => 'required',
            'errors'    => [
                'required'  => 'Nama Guru Harus Diisi',
            ]
        ],
        'tanggal_lahir ' => [
            'rules'     => 'required',
            'errors'    => [
                'required'  => 'Tanggal Lahir Harus Diisi',
            ]
        ],
        'jenis_kelamin ' => [
            'rules'     => 'required',
            'errors'    => [
                'required'  => 'Jenis Kelamin Harus Diisi',
            ]
        ],
    ];
    public $tambah_mapel = [
        'nama_mapel ' => [
            'rules'     => 'required',
            'errors'    => [
                'required'  => 'Nama Mapel Harus Diisi',
            ]
        ],
    ];
    public $tahun_akademik = [
        'tahun' => [
            'rules'    => 'required|numeric',
            'errors'   => [
                'required' => 'Tahun Harus Diisi',
                'is_unique' => 'Tahun Sudah ada',
                'numeric' => 'Tahun Harus Angka'
            ]
        ],
        'semester' => [
            'rules'    => 'required',
            'errors'   => [
                'required' => 'Semester Harus Diisi',
            ]
        ],
        'tanggal_mulai' => [
            'rules'     => 'required',
            'errors'    => [
                'required' => 'Tanggal mulai Harus Diisi'
            ]
        ],
        'tanggal_selesai' => [
            'rules'     => 'required',
            'errors'    => [
                'required' => 'Tanggal selesai Harus Diisi'
            ]
        ]
    ];
    public $jadwal_pelajaran =[
        'hari' => [
            'rules'     => 'required',
            'errors'    => [
                'required'  => 'Silahkan Pilih Hari',
            ]
        ],
        'id_kelas' => [
            'rules'     => 'required',
            'errors'    => [
                'required'  => 'Silahkan Pilih kelas',
            ]
        ],
        'id_mapel' => [
            'rules'     => 'required',
            'errors'    => [
                'required'  => 'Silahkan Pilih Nama mapel',
            ]
        ],
        'nip' => [
            'rules'     => 'required',
            'errors'    => [
                'required'  => 'Silahkan Pilih guru',
            ]
        ],
        'jam_masuk' => [
            'rules'     => 'required',
            'errors'    => [
                'required'  => 'Silahkan masukkan jam mulai',
            ]
        ],
        'jam_selesai' => [
            'rules'     => 'required',
            'errors'    => [
                'required'  => 'Silahkan Pilih jam selesai',
            ]
        ],
    ];
    public $kelola = [
        'tahun' => [
            'rules'    => 'required',
            'errors'   => [
                'required' => 'Tahun Harus Diisi',
            ]
        ],
        'kategori' => [
            'rules'    => 'required',
            'errors'   => [
                'required' => 'Kategori Harus Diisi',
            ]
        ],
    ];
    public $tambah_kelas = [
        'jurusan' => [
            'rules'     => 'required',
            'errors'    => [
                // 'is_unique' => 'Nama kelas Sudah ada',
                'required'  => 'Jurusan Kelas Harus Diisi',
            ]
        ],
        'kelas' => [
            'rules'     => 'required|numeric',
            'errors'    => [
                // 'is_unique' => 'Nama kelas Sudah ada',
                'required'  => 'Kelas Harus Diisi',
                'numeric'   => 'Kelas Harus Angka'
            ]
        ],
        'kelompok' => [
            'rules'     => 'required|numeric',
            'errors'    => [
                // 'is_unique' => 'Nama kelas Sudah ada',
                'required'  => 'kelompok Harus Diisi',
                'numeric'   => 'kelompok Harus Angka'
            ]
        ], 
    ];

    public $tambah_siswa = [
        'nis_siswa ' => [
            'rules'     => 'required|numeric|is_unique[tb_siswa.nis_siswa]',
            'errors'    => [
                'is_unique' => 'NIS Sudah Terdaftar',
                'numeric'   => 'NIS Yang diisi Bukan angka',
                'required'  => 'NIS Harus Diisi',
            ]
        ],
        
        'tahun_masuk' => [
            'rules'     => 'required|numeric',
            'errors'    => [
                'required'  => 'tahun masuk Harus Diisi',
                'required'  => 'tahun masuk Harus berupa angka',
            ]
        ],
        'nama_siswa ' => [
            'rules'     => 'required',
            'errors'    => [
                // 'alpha_space'  => 'Nama Siswa Tidak Boleh Mengandung Angka',
                'required'  => 'Nama Siswa Harus Diisi',
            ]
        ],
        'tanggal_lahir ' => [
            'rules'     => 'required',
            'errors'    => [
                'required'  => 'Tanggal Lahir Harus Diisi',
            ]
        ],
        'jenis_kelamin ' => [
            'rules'     => 'required',
            'errors'    => [
                'required'  => 'Jenis Kelamin Harus Diisi',
            ]
        ],
        'id_kelas ' => [
            'rules'     => 'required',
            'errors'    => [
                'required'  => 'kelas Harus Diisi',
            ]
        ],
    ];
    public $update_siswa = [
        'nis_siswa ' => [
            'rules'     => 'required|numeric',
            'errors'    => [
                'numeric'   => 'NIS Yang diisi Bukan angka',
                'required'  => 'Jenis Kelamin Harus Diisi',
            ]
        ],
        'nama_siswa ' => [
            'rules'     => 'required|alpha_space',
            'errors'    => [
                'alpha_space'  => 'Nama Siswa Tidak Boleh Mengandung Angka',
                'required'  => 'Nama Siswa Harus Diisi',
            ]
        ],
        'tanggal_lahir ' => [
            'rules'     => 'required',
            'errors'    => [
                'required'  => 'Tanggal Lahir Harus Diisi',
            ]
        ],
        'jenis_kelamin ' => [
            'rules'     => 'required',
            'errors'    => [
                'required'  => 'Jenis Kelamin Harus Diisi',
            ]
        ],
        'id_kelas ' => [
            'rules'     => 'required',
            'errors'    => [
                'required'  => 'kelas Harus Diisi',
            ]
        ],
    ];
}
