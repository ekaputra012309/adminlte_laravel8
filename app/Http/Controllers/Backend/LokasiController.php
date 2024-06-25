<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LantaiModel;
use App\Models\LokasiModel;
use RealRashid\SweetAlert\Facades\Alert;

class LokasiController extends Controller
{
    public function index()
    {
        $Lokasis = LokasiModel::with('lantai')->get();
        $data = array(
            'title' => 'Lokasi | ',
            'datalokasi' => $Lokasis,
        );
        $title = 'Delete Lokasi!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('backend.lokasi.index', $data);
    }

    public function create()
    {
        $lantai = LantaiModel::all();
        $data = array(
            'title' => 'Add Lokasi | ',
            'datalantai' => $lantai,
        );
        return view('backend.lokasi.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'locationname' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'floor_id' => 'required|integer',
        ]);

        LokasiModel::create($request->all());
        Alert::success('Success', 'Lokasi created successfully.');

        return redirect()->route('lokasi.index');
    }

    public function show(LokasiModel $Lokasi)
    {
        $data = array(
            'title' => 'View Lokasi | ',
        );
        return view('backend.lokasi.show', $data);
    }

    public function edit(LokasiModel $Lokasi)
    {
        $lantai = LantaiModel::all();
        $data = array(
            'title' => 'Edit Lokasi | ',
            'lokasi' => $Lokasi,
            'datalantai' => $lantai,
        );
        return view('backend.lokasi.edit', $data);
    }

    public function update(Request $request, LokasiModel $Lokasi)
    {
        $request->validate([
            'locationname' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'floor_id' => 'required|integer',
        ]);

        $Lokasi->update($request->all());
        Alert::success('Success', 'Lokasi updated successfully.');

        return redirect()->route('lokasi.index');
    }

    public function destroy(LokasiModel $Lokasi)
    {
        $Lokasi->delete();
        Alert::success('Success', 'Lokasi deleted successfully.');

        return redirect()->route('lokasi.index');
    }
}
