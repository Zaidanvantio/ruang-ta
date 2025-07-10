@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center">
    <h4><i class="bi bi-calendar-check"></i> Absensi</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('absensi.index') }}">Absensi</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Data</li>
        </ol>
    </nav>
</div>

<div class="card mt-3">
    <div class="card-header">
        <i class="bi bi-plus-square"></i> Tambah Data
    </div>
    <div class="card-body">
        <form action="{{ route('absensi.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal ( dd/mm/yyyy )</label>
                <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}">
                 @error('tanggal')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="cuti" id="cuti">
                <label class="form-check-label" for="cuti">
                    Cuti
                </label>
            </div>
             <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="jam_datang" class="form-label">Jam Datang</label>
                    <input type="time" class="form-control @error('jam_datang') is-invalid @enderror" id="jam_datang" name="jam_datang" value="{{ old('jam_datang') }}">
                    @error('jam_datang')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="jam_pulang" class="form-label">Jam Pulang</label>
                    <input type="time" class="form-control @error('jam_pulang') is-invalid @enderror" id="jam_pulang" name="jam_pulang" value="{{ old('jam_pulang') }}">
                    @error('jam_pulang')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <label for="uraian_pekerjaan" class="form-label">Uraian Pekerjaan</label>
                <textarea class="form-control" id="uraian_pekerjaan" name="uraian_pekerjaan" rows="3">{{ old('uraian_pekerjaan') }}</textarea>
            </div>

            <a href="{{ route('absensi.index') }}" class="btn btn-danger"><i class="bi bi-arrow-left"></i> Kembali</a>
            <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Simpan</button>
        </form>
    </div>
</div>
@endsection