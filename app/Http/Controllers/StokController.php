<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\StokModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StokController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Stok',
            'list' => ['Home', 'Stok']
        ];

        $page = (object) [
            'title' => 'Daftar stok yang terdaftar dalam sistem'
        ];

        $activeMenu = 'stok';

        $barang = BarangModel::all();
        $user = UserModel::all();

        return view('stok.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $stoks = StokModel::select('stok_id', 'stok_tanggal', 'stok_jumlah', 'barang_id', 'user_id')->with('barang')->with('user');
        if ($request->barang_id) {
            $stoks->where('barang_id', $request->barang_id);
        }

        if ($request->user_id) {
            $stoks->where('user_id', $request->user_id);
        }

        return DataTables::of($stoks)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($stok) { // menambahkan kolom aksi
                $btn = '<a href="' . url('/stok/' . $stok->stok_id) . '" class="btn btn-info btn-sm" > Detail</a> ';
                $btn .= '<a href="' . url('/stok/' . $stok->stok_id . '/edit') . '"class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/stok/' . $stok->stok_id) . '">' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger btn-sm"onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    public function show(string $id)
    {
        $stok = StokModel::with(['barang', 'user'])->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail stok',
            'list' => ['Home', 'stok', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail stok'
        ];

        $activeMenu = 'stok';

        return view('stok.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'stok' => $stok, 'activeMenu' => $activeMenu]);
    }

    public function destroy(string $id)
    {
        $check = StokModel::find($id);
        if (!$check) {
            return redirect('/stok')->with('error', 'Data stok tidak ditemukan');
        }

        try {
            StokModel::destroy($id);

            return redirect('/stok')->with('success', 'Data stok berhasil dihapus');
        } catch (\illuminate\Database\QueryException $e) {
            return redirect('/stok')->with('error' . 'Data stok gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function edit(string $id)
    {
        $stok = StokModel::find($id);
        $barang = BarangModel::all();
        $user = UserModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit Stok',
            'list' => ['Home', 'Stok', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit stok'
        ];

        $activeMenu = 'stok';

        return view('stok.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'stok' => $stok, 'barang' => $barang, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'stok_jumlah' => 'required',
            'stok_tanggal' => 'required',
            'barang_id' => 'required',
            'user_id' => 'required'
        ]);

        StokModel::find($id)->update([
            'stok_jumlah' => $request->stok_jumlah,
            'stok_tanggal' => $request->stok_tanggal,
            'barang_id' => $request->barang_id,
            'user_id' => $request->user_id
        ]);

        return redirect('/stok')->with('success', 'Data stok berhasil diubah');
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Stok',
            'list' => ['Home', 'Stok', 'Ta,bah']
        ];

        $page = (object) [
            'title' => 'Tambah stok baru'
        ];

        $user = UserModel::all();
        $barang = BarangModel::all();
        $activeMenu = 'stok';

        return view('stok.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'barang' => $barang, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'stok_tanggal' => 'required',
            'stok_jumlah' => 'required',
            'user_id' => 'required',
            'barang_id' => 'required|integer',
        ]);

        StokModel::create([
            'stok_tanggal' => $request->stok_tanggal,
            'stok_jumlah' => $request->stok_jumlah,
            'user_id' => $request->user_id,
            'barang_id' => $request->barang_id
        ]);

        return redirect('/stok')->with('success', 'Data stok berhasil disimpan');
    }
}
