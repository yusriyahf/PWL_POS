<?php

namespace App\Http\Controllers;

use App\Models\PenjualanModel;
use App\Models\DetailPenjualanModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PenjualanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Penjualan',
            'list' => ['Home', 'Penjualan']
        ];

        $page = (object) [
            'title' => 'Daftar penjualan yang terdaftar dalam sistem'
        ];

        $activeMenu = 'penjualan';

        $user = UserModel::all();

        return view('penjualan.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $penjualans = PenjualanModel::select('penjualan_id', 'user_id', 'pembeli', 'penjualan_kode', 'penjualan_tanggal')->with('user');
        if ($request->level_id) {
            $penjualans->where('level_id', $request->level_id);
        }
        return DataTables::of($penjualans)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($penjualan) { // menambahkan kolom aksi
                $btn = '<a href="' . url('/penjualan/' . $penjualan->penjualan_id) . '" class="btn btn-info btn-sm" > Detail</a> ';
                $btn .= '<a href="' . url('/penjualan/' . $penjualan->penjualan_id . '/edit') . '"class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/penjualan/' . $penjualan->penjualan_id) . '">' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger btn-sm"onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    public function show(string $id)
    {
        // $detail = DetailPenjualanModel::with(['penjualan', 'barang'])->where('penjualan_id', $id)->get();
        $detail = DetailPenjualanModel::where('penjualan_id', $id)->first();

        $breadcrumb = (object) [
            'title' => 'Detail Penjualan',
            'list' => ['Home', 'Penjualan', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail penjualan'
        ];

        $activeMenu = 'penjualan';

        return view('penjualan.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'detail' => $detail, 'activeMenu' => $activeMenu]);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Penjualan',
            'list' => ['Home', 'Penjualan', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah penjualan baru'
        ];

        $user = UserModel::all();
        $activeMenu = 'penjualan';

        return view('penjualan.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'pembeli' => 'required|string',
            'penjualan_kode' => 'required',
            'penjualan_tanggal' => 'required',
            'user_id' => 'required',
        ]);

        PenjualanModel::create([
            'pembeli' => $request->pembeli,
            'penjualan_kode' => $request->penjualan_kode,
            'penjualan_tanggal' => $request->penjualan_tanggal,
            'user_id' => $request->user_id
        ]);

        return redirect('/penjualan')->with('success', 'Data penjualan berhasil disimpan');
    }

    public function edit(string $id)
    {
        $penjualan = PenjualanModel::find($id);
        $user = UserModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit penjualan',
            'list' => ['Home', 'penjualan', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit penjualan'
        ];

        $activeMenu = 'penjualan';

        return view('penjualan.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'penjualan' => $penjualan, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'pembeli' => 'required',
            'penjualan_kode' => 'required',
            'penjualan_tanggal' => 'required',
            'user_id' => 'required|integer'
        ]);

        PenjualanModel::find($id)->update([
            'pembeli' => $request->pembeli,
            'penjualan_kode' => $request->penjualan_kode,
            'penjualan_tanggal' => $request->penjualan_tanggal,
            'user_id' => $request->user_id
        ]);

        return redirect('/penjualan')->with('success', 'Data penjualan berhasil diubah');
    }

    public function destroy(string $id)
    {
        $check = PenjualanModel::find($id);
        if (!$check) {
            return redirect('/penjualan')->with('error', 'Data penjualan tidak ditemukan');
        }

        try {
            PenjualanModel::destroy($id);

            return redirect('/penjualan')->with('success', 'Data penjualan berhasil dihapus');
        } catch (\illuminate\Database\QueryException $e) {
            return redirect('/penjualan')->with('error' . 'Data penjualan gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
