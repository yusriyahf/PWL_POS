<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'penjualan_id' => 1,
                'user_id' => 1,
                'pembeli' => "yusriyah",
                'penjualan_kode' => 'KODE1',
                'penjualan_tanggal' => '2000-12-25 00:28:00',
            ],
            [
                'penjualan_id' => 2,
                'user_id' => 1,
                'pembeli' => "firjatullah",
                'penjualan_kode' => 'KODE2',
                'penjualan_tanggal' => '2000-12-25 00:28:00',
            ],
            [
                'penjualan_id' => 3,
                'user_id' => 1,
                'pembeli' => "ucing",
                'penjualan_kode' => 'KODE3',
                'penjualan_tanggal' => '2000-12-25 00:28:00',
            ],
            [
                'penjualan_id' => 4,
                'user_id' => 2,
                'pembeli' => "dido",
                'penjualan_kode' => 'KODE4',
                'penjualan_tanggal' => '2000-12-25 00:28:00',
            ],
            [
                'penjualan_id' => 5,
                'user_id' => 2,
                'pembeli' => "maul",
                'penjualan_kode' => 'KODE5',
                'penjualan_tanggal' => '2000-12-25 00:28:00',
            ],
            [
                'penjualan_id' => 6,
                'user_id' => 2,
                'pembeli' => "atiyan",
                'penjualan_kode' => 'KODE6',
                'penjualan_tanggal' => '2000-12-25 00:28:00',
            ],
            [
                'penjualan_id' => 7,
                'user_id' => 3,
                'pembeli' => "nopal",
                'penjualan_kode' => 'KODE7',
                'penjualan_tanggal' => '2000-12-25 00:28:00',
            ],
            [
                'penjualan_id' => 8,
                'user_id' => 3,
                'pembeli' => "makmor",
                'penjualan_kode' => 'KODE8',
                'penjualan_tanggal' => '2000-12-25 00:28:00',
            ],
            [
                'penjualan_id' => 9,
                'user_id' => 3,
                'pembeli' => "arya",
                'penjualan_kode' => 'KODE9',
                'penjualan_tanggal' => '2000-12-25 00:28:00',
            ],
            [
                'penjualan_id' => 10,
                'user_id' => 3,
                'pembeli' => "andre",
                'penjualan_kode' => 'KODE10',
                'penjualan_tanggal' => '2000-12-25 00:28:00',
            ],

        ];
        DB::table('t_penjualan')->insert($data);
    }
}
