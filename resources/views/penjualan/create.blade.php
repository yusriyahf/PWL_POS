@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ url('penjualan') }}" class="form-horizontal">
            @csrf
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">User</label>
                <div class="col-11">
                    <select class="form-control" id="user_id" name="user_id" required>
                        <option value="">- Pilih user -</option>
                        @foreach($user as $item)
                        <option value="{{ $item->user_id }}">{{ $item->username }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Pembeli</label>
                <div class="col-11">
                    <input type="text" class="form-control" id="pembeli" name="pembeli" value="{{ old('pembeli') }}" required>
                    @error('pembeli')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Penjualan Kode</label>
                <div class="col-11">
                    <input type="text" class="form-control" id="penjualan_kode" name="penjualan_kode" value="{{ old('penjualan_kode') }}" required>
                    @error('penjualan_kode')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Penjualan Tanggal</label>
                <div class="col-11">
                    <input type="date" class="form-control" id="penjualan_tanggal" name="penjualan_tanggal" value="{{ old('penjualan_tanggal') }}" required placeholder="Format: YYYY-MM-DD">
                    @error('penjualan_tanggal')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>            
            <div class="form-group row">
                <label class="col-1 control-label col-form-label"></label>
                <div class="col-11">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    <a class="btn btn-sm btn-default ml-1" href="{{ url('penjualan') }}">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
@endpush
