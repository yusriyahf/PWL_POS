<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\KategoriModel;
use Illuminate\Support\Facades\DB;
use App\DataTables\KategoriDataTable;
use Illuminate\Http\RedirectResponse;

class KategoriController extends Controller
{

    public function index(KategoriDataTable $dataTable)
    {
        return $dataTable->render('kategori.index');
    }

    public function create(): View
    {
        return view('kategori.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kategori_kode' => 'bail|required',
            'kategori_nama' => 'required',
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
