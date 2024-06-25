<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\KategoriModel;
use App\Models\LantaiModel;
use App\Models\LokasiModel;
use App\Models\PermintaanModel;
use App\Models\StatusPermintaanModel;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PermintaanController extends Controller
{
    public function index()
    {
        $permintaan = PermintaanModel::with('kategori', 'user')->orderBy('created_at', 'desc')->get();
        $data = array(
            'title' => 'Permintaan | ',
            'datapermintaan' => $permintaan,
        );
        // dd($data['datapermintaan']);
        $title = 'Delete Permintaan!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('backend.permintaan.index', $data);
    }

    public function create()
    {
        $kategori = KategoriModel::all();
        $lokasi = LokasiModel::all();
        $lantai = LantaiModel::all();
        $data = array(
            'title' => 'Add Permintaan | ',
            'datakategori' => $kategori,
            'datalokasi' => $lokasi,
            'datalantai' => $lantai,
        );
        return view('backend.permintaan.create', $data);
    }

    public function store(Request $permintaan)
    {
        $permintaan->validate([
            'pelapor' => 'required|string',
            'kendala' => 'required|string',
            'kategori_id' => 'required|exists:master_kategori,id',
            'tingkat' => 'required|in:Mudah,Sedang,Sulit',
            'lokasi_id' => 'required|exists:master_lokasi,id',
            'user_id' => 'required|exists:users,id'
        ]);
        // dd($permintaan->all());
        permintaanModel::create($permintaan->all());
        Alert::success('Success', 'Permintaan created successfully.');

        return redirect()->route('permintaan.index');
    }

    public function show(PermintaanModel $permintaan)
    {
        $data = array(
            'title' => 'View Permintaan | ',
        );
        return view('backend.permintaan.show', $data);
    }

    public function edit(PermintaanModel $permintaan)
    {
        $kategori = KategoriModel::all();
        $lokasi = LokasiModel::all();
        $lantai = LantaiModel::all();
        $data = array(
            'title' => 'Edit Permintaan | ',
            'permintaan' => $permintaan,
            'datakategori' => $kategori,
            'datalokasi' => $lokasi,
            'datalantai' => $lantai,
        );
        return view('backend.permintaan.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $permintaan = PermintaanModel::find($id);
        if (!$permintaan) {
            Alert::error('Error', 'Model not found.');
        }
        $request->validate([
            'pelapor' => 'required|string',
            'kendala' => 'required|string',
            'kategori_id' => 'required|exists:master_kategori,id',
            'tingkat' => 'required|in:Mudah,Sedang,Sulit',
            'lokasi_id' => 'required|exists:master_lokasi,id',
            'user_id' => 'required|exists:users,id'
        ]);
        $permintaan->update($request->all());
        Alert::success('Success', 'Permintaan updated successfully.');

        return redirect()->route('permintaan.index');
    }

    public function destroy(PermintaanModel $permintaan)
    {
        $permintaan->delete();
        Alert::success('Success', 'permintaan deleted successfully.');

        return redirect()->route('permintaan.index');
    }

    public function updateStatus(Request $request, $id, $status)
    {
        // Validate the input based on the status
        if ($status == 'pending') {
            $request->validate([
                'keterangan' => 'required|string|max:255',
            ]);
        } elseif ($status == 'selesai') {
            $request->validate([
                'solusi' => 'required|string|max:255',
            ]);
        }

        $permintaan = PermintaanModel::where('id', $id)->firstOrFail();

        if ($status == 'proses') {
            // Insert a new record
            StatusPermintaanModel::create([
                'permintaan_id' => $id,
                'user_id' => auth()->user()->id,
                'onproses' => now(),
            ]);
            $permintaan->status = 'On Proses';
            $permintaan->save();
        } else {
            // Update the existing record
            $statusPermintaan = StatusPermintaanModel::where('permintaan_id', $id)->firstOrFail();
            if ($status == 'pending') {
                $statusPermintaan->pending = now();
                $permintaan->solusi = '';
                $permintaan->keterangan = $request->keterangan; // Save keterangan
                $permintaan->status = 'Pending';
            } elseif ($status == 'selesai') {
                $statusPermintaan->selesai = now();
                $permintaan->keterangan = '';
                $permintaan->solusi = $request->solusi; // Save solusi
                $permintaan->status = 'Selesai';
            }

            $statusPermintaan->save();
            $permintaan->save();
        }

        Alert::success('Success', 'Status updated successfully.');
        return redirect()->route('permintaan.index');
    }
}
