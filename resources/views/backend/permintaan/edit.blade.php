@extends('backend/template/app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Request</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('permintaan.index') }}">Request</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Edit Request User</h3>
                            </div>
                            <form action="{{ route('permintaan.update', $permintaan->id) }}" method="POST">
                                @csrf
                                @method('PUT') <!-- Use PUT method for update -->
                                @auth
                                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                @endauth

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="pelapor">Nama Pelapor</label>
                                                <input type="text" class="form-control" id="pelapor" name="pelapor"
                                                    placeholder="Nama Pelapor" required value="{{ $permintaan->pelapor }}">
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="lantai">Pilih Lokasi</label>
                                                <select id="lantai" class="form-control select2bs4" style="width: 100%"
                                                    required>
                                                    @foreach ($datalantai as $lantai)
                                                        <option value="{{ $lantai->id }}">
                                                            {{ $lantai->floorname }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> --}}
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="lokasi_id" class="text-white">Pilih Lokasi</label>
                                                <select name="lokasi_id" id="lokasi_id" class="form-control select2bs4"
                                                    style="width: 100%" required>
                                                    @foreach ($datalokasi as $lokasi)
                                                        <option value="{{ $lokasi->id }}"
                                                            {{ $lokasi->id == $permintaan->lokasi_id ? 'selected' : '' }}>
                                                            {{ $lokasi->locationname }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="tingkat">Pilih Tingkat</label>
                                                <select name="tingkat" id="tingkat" class="form-control select2bs4"
                                                    style="width: 100%" required>
                                                    <option value="Mudah"
                                                        {{ $permintaan->tingkat == 'Mudah' ? 'selected' : '' }}>Mudah
                                                    </option>
                                                    <option value="Sedang"
                                                        {{ $permintaan->tingkat == 'Sedang' ? 'selected' : '' }}>Sedang
                                                    </option>
                                                    <option value="Sulit"
                                                        {{ $permintaan->tingkat == 'Sulit' ? 'selected' : '' }}>Sulit
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="kategori_id">Pilih Kategori</label>
                                                <select id="kategori_id" class="form-control select2bs4" style="width: 100%"
                                                    required>
                                                    <option value="Hardware"
                                                        {{ $permintaan->tingkat == 'Hardware' ? 'selected' : '' }}>Hardware
                                                    </option>
                                                    <option value="Jaringan"
                                                        {{ $permintaan->tingkat == 'Jaringan' ? 'selected' : '' }}>Jaringan
                                                    </option>
                                                    <option value="Software"
                                                        {{ $permintaan->tingkat == 'Software' ? 'selected' : '' }}>Software
                                                    </option>
                                                    <option value="Other"
                                                        {{ $permintaan->tingkat == 'Other' ? 'selected' : '' }}>Other
                                                    </option>
                                                </select>
                                            </div>
                                        </div> --}}
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="kategori_id" class="">Pilih Kategori</label>
                                                <select name="kategori_id" id="kategori_id" class="form-control select2bs4"
                                                    style="width: 100%" required>
                                                    @foreach ($datakategori as $kategori)
                                                        <option value="{{ $kategori->id }}"
                                                            {{ $kategori->id == $permintaan->kategori_id ? 'selected' : '' }}>
                                                            {{ $kategori->hashtag }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="kendala">Kendala</label>
                                                <textarea class="form-control" name="kendala" id="kendala" cols="30" rows="3" required>{{ $permintaan->kendala }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="{{ route('permintaan.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
