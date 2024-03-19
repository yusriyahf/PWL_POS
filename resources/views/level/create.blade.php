@extends('layouts.app')
{{-- Customize layout sections --}}
@section('subtitle', 'Kategori')
@section('content_header_title', 'Level')
@section('content_header_subtitle', 'Create')
{{-- Content body: main page content --}}
@section('content')
    <div class="container">
        <div class="card card-primary">
            <div class="card-header">
                <div class="card-title">Buat kategori baru</div>
            </div>

            <form action="../level" method="post">
                <div class="card-body">
                    <div class="form-group">
                        <label for="kodeKategori">Kode Level</label>
                        <input type="text" name="level_kode" id="kodeKategori" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="namaKategori">Nama Level</label>
                        <input type="text" name="level_nama" id="namaKategori" class="form-control">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection