<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\KategoriModel;
use Illuminate\Support\Facades\DB;
use App\DataTables\KategoriDataTable;
use Illuminate\Http\RedirectResponse;
use Yajra\DataTables\Facades\DataTables;


class KategoriController extends Controller
{

    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Kategori',
            'list' => ['Home', 'Kategori']
        ];

        $page = (object) [
            'title' => 'Daftar kategori yang terdaftar dalam sistem'
        ];

        $activeMenu = 'kategori';

        $kategori = KategoriModel::all();

        return view('kategori.index', ['breadcrumb' => $breadcrumb, 'kategori' => $kategori, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $kategoris = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama');
        return DataTables::of($kategoris)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($kategori) { // menambahkan kolom aksi
                $btn = '<a href="' . url('/kategori/' . $kategori->kategori_id) . '" class="btn btn-info btn-sm" > Detail</a> ';
                $btn .= '<a href="' . url('/kategori/' . $kategori->kategori_id . '/edit') . '"class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/kategori/' . $kategori->kategori_id) . '">' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger btn-sm"onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    public function show(string $id)
    {
        $kategori = KategoriModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Kategori',
            'list' => ['Home', 'Kategori', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail kategori'
        ];

        $activeMenu = 'kategori';

        return view('kategori.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Kategori',
            'list' => ['Home', 'Kategori', 'Ta,bah']
        ];

        $page = (object) [
            'title' => 'Tambah kategori baru'
        ];

        $activeMenu = 'kategori';

        return view('kategori.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode',
            'kategori_nama' => 'required|string'
        ]);

        KategoriModel::create([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama
        ]);

        return redirect('/kategori')->with('success', 'Data kategori berhasil disimpan');
    }

    public function edit(string $id)
    {
        $kategori = KategoriModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit kategori',
            'list' => ['Home', 'kategori', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit kategori'
        ];

        $activeMenu = 'kategori';

        return view('kategori.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode,' . $id . ',kategori_id',
            'kategori_nama' => 'required|string'
        ]);

        KategoriModel::find($id)->update([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama
        ]);

        return redirect('/kategori')->with('success', 'Data kategori berhasil diubah');
    }

    public function destroy(string $id)
    {
        $check = KategoriModel::find($id);
        if (!$check) {
            return redirect('/kategori')->with('error', 'Data kategori tidak ditemukan');
        }
        try {
            KategoriModel::destroy($id);

            return redirect('/kategori')->with('success', 'Data kategori berhasil dihapus');
        } catch (\illuminate\Database\QueryException $e) {
            return redirect('/kategori')->with('error' . 'Data kategori gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }


    // public function index(KategoriDataTable $dataTable)
    // {
    //     return $dataTable->render('kategori.index');
    // }

    // public function create(): View
    // {
    //     return view('kategori.create');
    // }

    // public function store(Request $request): RedirectResponse
    // {
    //     $validated = $request->validate([
    //         'kategori_kode' => 'bail|required',
    //         'kategori_nama' => 'required',
    //     ]);
    //     return redirect('/kategori');
    // }

    // public function edit($id)
    // {
    //     $user = KategoriModel::find($id);
    //     return view('kategori.edit', ['data' => $user]);
    // }

    // public function update($id, Request $request)
    // {
    //     $user = KategoriModel::find($id);

    //     $user->kategori_kode = $request->kategori_kode;
    //     $user->kategori_nama = $request->kategori_nama;

    //     $user->save();

    //     return redirect('/kategori');
    // }

    // public function destroy($id)
    // {
    //     $user = KategoriModel::find($id);
    //     $user->delete();

    //     return redirect('/kategori');
    // }
}
