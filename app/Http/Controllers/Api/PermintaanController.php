<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Models\PermintaanModel;
use App\Models\StatusPermintaanModel;
use Illuminate\Support\Facades\Validator;

class PermintaanController extends BaseController
{
    // List all permintaan
    public function index()
    {
        $permintaan = PermintaanModel::with('kategori', 'lokasi', 'user')
            ->orderBy('created_at', 'desc')
            ->get();
        return $this->sendResponse($permintaan, 'Permintaan retrieved successfully.');
    }

    // Store a new permintaan
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pelapor' => 'required|string',
            'kendala' => 'required|string',
            'kategori_id' => 'required|exists:master_kategori,id',
            'tingkat' => 'required|in:Mudah,Sedang,Sulit',
            'lokasi_id' => 'required|exists:master_lokasi,id',
            'user_id' => 'required|exists:users,id'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $permintaan = PermintaanModel::create($request->all());

        return $this->sendCreatedResponse($permintaan, 'Permintaan created successfully.');
    }

    // Show a single permintaan
    public function show($id)
    {
        $permintaan = PermintaanModel::find($id);

        if (!$permintaan) {
            return $this->sendError('Permintaan not found.');
        }

        return $this->sendResponse($permintaan, 'Permintaan retrieved successfully.');
    }

    // Update an existing permintaan
    public function update(Request $request, $id)
    {
        $permintaan = PermintaanModel::find($id);

        if (!$permintaan) {
            return $this->sendError('Permintaan not found.');
        }

        $validator = Validator::make($request->all(), [
            'pelapor' => 'required|string',
            'kendala' => 'required|string',
            'kategori_id' => 'required|exists:master_kategori,id',
            'tingkat' => 'required|in:Mudah,Sedang,Sulit',
            'lokasi_id' => 'required|exists:master_lokasi,id',
            'user_id' => 'required|exists:users,id'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $permintaan->update($request->all());

        return $this->sendUpdateResponse($permintaan, 'Permintaan updated successfully.');
    }

    // Delete a permintaan
    public function destroy($id)
    {
        $permintaan = PermintaanModel::find($id);

        if (!$permintaan) {
            return $this->sendError('Permintaan not found.');
        }

        $permintaan->delete();

        return $this->sendDeleteResponse('Permintaan deleted successfully.');
    }

    public function updateStatus(Request $request, $id, $status)
    {
        // Validate the input based on the status
        if ($status == 'pending') {
            $validator = Validator::make($request->all(), [
                'keterangan' => 'required|string|max:255',
            ]);
        } elseif ($status == 'selesai') {
            $validator = Validator::make($request->all(), [
                'solusi' => 'required|string|max:255',
            ]);
        } else {
            $validator = Validator::make($request->all(), []);
        }

        if (isset($validator) && $validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $permintaan = PermintaanModel::findOrFail($id);

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

        return $this->sendResponse($permintaan, 'Status updated successfully.');
    }
}
