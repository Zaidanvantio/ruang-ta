@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center">
    <h4><i class="bi bi-calendar-check"></i> KEHADIRAN KARYAWAN </h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Absen</li>
        </ol>
    </nav>
</div>

<div class="card mt-3">
    <div class="card-header">
       <i class="bi bi-list"></i> Daftar
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="d-flex justify-content-between mb-3">
            <form action="{{ route('absensi.index') }}" method="GET" class="d-flex">
                <select name="bulan" class="form-select me-2" onchange="this.form.submit()">
                    @php
                        $namaBulanIndonesia = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                        ];
                    @endphp
                    @foreach ($namaBulanIndonesia as $num => $name)
                        <option value="{{ $num }}" {{ $bulan == $num ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
                <select name="tahun" class="form-select" onchange="this.form.submit()">
                    @for ($i = date('Y'); $i >= date('Y') - 5; $i--)
                        <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </form>
            <div>
                <a href="{{ route('absensi.create') }}" class="btn btn-success"><i class="bi bi-plus"></i> Tambah</a>
                <button class="btn btn-secondary"><i class="bi bi-printer"></i> Cetak</button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Hari</th>
                        <th>Tanggal</th>
                        <th>Cuti</th>
                        <th>Jam Hadir</th>
                        <th>Jam Kepulangan</th>
                        <th>Jam Kerja</th>
                        <th>Uraian Pekerjaan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php \Carbon\Carbon::setLocale('id'); @endphp
                    @forelse ($absensi as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l') }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                            <td>{{ $item->cuti ? 'Ya' : '-' }}</td>
                            <td>
                                @if($item->jam_datang)
                                <a href="{{ route('absensi.edit', $item) }}">{{ \Carbon\Carbon::parse($item->jam_datang)->format('H:i') }}</a>
                                @else
                                -
                                @endif
                            </td>
                            <td>
                                @if($item->jam_pulang)
                                <a href="{{ route('absensi.edit', $item) }}">{{ \Carbon\Carbon::parse($item->jam_pulang)->format('H:i') }}</a>
                                @else
                                -
                                @endif
                            </td>
                            <td>{{ $item->jam_kerja ?? '-' }}</td>
                            <td>{{ $item->uraian_pekerjaan ?? '-' }}</td>
                            <td>
                                <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('absensi.destroy', $item->id) }}" method="POST">
                                    <a href="{{ route('absensi.edit', $item->id) }}" class="btn btn-sm btn-primary"><i class="bi bi-pencil-square"></i></a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">Data absensi belum tersedia untuk periode {{ $namaBulanIndonesia[(int)$bulan] }} {{ $tahun }}.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            <strong>Jumlah Cuti : {{ $jumlahCuti }}</strong>
        </div>
    </div>
    <div class="card-footer">
        <a href="#">Daftar Hari Libur</a>
    </div>
</div>
@endsection