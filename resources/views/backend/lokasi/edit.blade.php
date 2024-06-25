@extends('backend/template/app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Lokasi</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('lokasi.index') }}">Lokasi</a></li>
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
                                <h3 class="card-title">Edit Lokasi</h3>
                            </div>
                            <form action="{{ route('lokasi.update', $lokasi->id) }}" method="POST">
                                @csrf
                                @method('PUT') <!-- Use PUT method for update -->
                                @auth
                                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                @endauth

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="locationname">Nama Lokasi</label>
                                                <input type="text" class="form-control" id="locationname"
                                                    name="locationname" placeholder="Nama lokasi" required
                                                    value="{{ $lokasi->locationname }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="floor_id">Nama Lantai</label>
                                                <select name="floor_id" id="floor_id" class="form-control select2bs4"
                                                    style="width: 100%" required>
                                                    @foreach ($datalantai as $floor)
                                                        <option value="{{ $floor->id }}"
                                                            {{ $floor->id == $lokasi->floor_id ? 'selected' : '' }}>
                                                            {{ $floor->floorname }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="{{ route('lokasi.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
