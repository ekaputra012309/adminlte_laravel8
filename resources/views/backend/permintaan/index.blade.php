@extends('backend/template/app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Request User</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        {{-- <li class="breadcrumb-item"><a href="#">Layout</a></li> --}}
                        <li class="breadcrumb-item active">Request User</li>
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
                            <h3 class="card-title"> </h3>
                            <div class="card-tools">
                                <a href="{{ route('permintaan.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Add Data
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table ">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Pelapor</th>
                                        <th>Kendala</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datapermintaan as $request)
                                    <tr>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Actions
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item text-danger {{ $request->user_id != auth()->user()->id ? 'disabled' : '' }} d-flex justify-content-between align-items-center" href="{{ route('permintaan.destroy', $request->id) }}" data-confirm-delete="true">
                                                        Delete
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    <a class="dropdown-item text-info d-flex justify-content-between align-items-center" href="{{ route('permintaan.edit', $request->id) }}">
                                                        <span>Edit</span>
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item text-primary {{ $request->status == 'Selesai' || $request->status != 'Belum Proses' ? 'disabled' : '' }} d-flex justify-content-between align-items-center proses-action" href="javascript:void(0);" data-url="{{ route('permintaan.updateStatus', ['id' => $request->id, 'status' => 'proses']) }}">
                                                        <span>Proses</span>
                                                        <i class="fas fa-spinner"></i>
                                                    </a>
                                                    <a class="dropdown-item text-danger {{ $request->status == 'Selesai' || $request->status == 'Belum Proses' ? 'disabled' : '' }} d-flex justify-content-between align-items-center" href="javascript:void(0);" data-toggle="modal" data-target="#pendingModal" data-url="{{ route('permintaan.updateStatus', ['id' => $request->id, 'status' => 'pending']) }}">
                                                        <span>Pending</span>
                                                        <i class="fas fa-pause-circle"></i>
                                                    </a>
                                                    <a class="dropdown-item text-success {{ $request->status == 'Selesai' || $request->status == 'Belum Proses' ? 'disabled' : '' }} d-flex justify-content-between align-items-center" href="javascript:void(0);" data-toggle="modal" data-target="#selesaiModal" data-url="{{ route('permintaan.updateStatus', ['id' => $request->id, 'status' => 'selesai']) }}">
                                                        <span>Selesai</span>
                                                        <i class="fas fa-check-circle"></i>
                                                    </a>
                                                </div>

                                            </div>
                                            @php
                                            $colors = [
                                            'Belum Proses' => 'btn-warning',
                                            'On Proses' => 'btn-info',
                                            'Pending' => 'btn-danger',
                                            'Selesai' => 'btn-success',
                                            ];
                                            $color = $colors[$request->status] ?? 'btn-secondary';
                                            @endphp
                                            <span class="btn btn-sm btn-xs {{ $color }}">
                                                {{ $request->status }}
                                            </span>

                                            @php
                                            $colors = [
                                            'Mudah' => 'btn-success',
                                            'Sedang' => 'btn-warning',
                                            'Sulit' => 'btn-danger',
                                            ];
                                            $color = $colors[$request->tingkat] ?? 'btn-secondary';
                                            @endphp

                                            <span class="btn btn-sm btn-xs {{ $color }}">
                                                {{ $request->tingkat }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ $request->pelapor }}
                                            <br>
                                            <span class="small btn btn-xs"><em>PIC :
                                                    {{ $request->user->name }}</em></span>
                                        </td>
                                        <td>
                                            {{ mb_strlen($request->kendala) > 150 ? mb_substr($request->kendala, 0, 150) . '...' : $request->kendala }}
                                            <br>
                                            <a href="#" class="btn btn-light btn-xs"><i class="fas fa-hashtag nav-icon"></i>
                                                {{ $request->kategori->hashtag ?? 'No Hashtag' }}</a>
                                            <a href="#" class="btn btn-light btn-xs"><i class="fas fa-map-marker-alt nav-icon"></i>
                                                {{ $request->lokasi->locationname }}</a>
                                            <a href="#" class="btn btn-light btn-xs"><i class="fas fa-calendar-alt"></i>
                                                {{ \Carbon\Carbon::parse($request->created_at)->translatedFormat('d F Y') }}</a>
                                        </td>
                                        <td>
                                            @php
                                            $keterangan = $request->keterangan;
                                            $solusi = $request->solusi;

                                            if ($keterangan || $solusi) {
                                            $text = '<small>';
                                                if ($keterangan) {
                                                $text .=
                                                '<em><strong>Pending:</strong></em><br>' .
                                                nl2br(e($keterangan)) .
                                                '<br>';
                                                }
                                                if ($solusi) {
                                                $text .=
                                                '<em><strong>Solusi:</strong></em><br>' .
                                                nl2br(e($solusi)) .
                                                '<br>';
                                                }
                                                $text .= '</small>';
                                            } else {
                                            $text = '';
                                            }
                                            @endphp
                                            {!! $text !!}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('backend.permintaan.modal')
    </section>
    <script>
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true,
            // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    </script>
    @include('backend.permintaan.script')
</div>
@endsection