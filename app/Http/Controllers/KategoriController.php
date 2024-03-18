<?php

namespace App\Http\Controllers;

use App\DataTables\KategoriDataTable;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{

    public function index(KategoriDataTable $dataTable)
    {
        return $dataTable->render('kategori.index');
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        KategoriModel::create([
            'kategori_kode' => $request->kodeKategori,
            'kategori_nama' => $request->namaKategori,
        ]);
        return redirect('/kategori');
    }

    public function edit($id)
    {
        $user = KategoriModel::find($id);
        return view('kategori.edit', ['data' => $user]);
    }

    public function update($id, Request $request)
    {
        $user = KategoriModel::find($id);

        $user->kategori_kode = $request->kategori_kode;
        $user->kategori_nama = $request->kategori_nama;

        $user->save();

        return redirect('/kategori');
    }

    public function destroy($id)
    {
        $user = KategoriModel::find($id);
        $user->delete();

        return redirect('/kategori');
    }
}
