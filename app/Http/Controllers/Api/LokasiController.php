<?php

namespace App\Http\Controllers\API;

use App\Models\LokasiModel;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class LokasiController extends BaseController
{
    public function index(Request $request): JsonResponse
    {
        $lantaiid = $request->post('lantaiId');
        $lokasis = LokasiModel::with('lantai');

        if ($lantaiid) {
            $lokasis = $lokasis->where('floor_id', $lantaiid);
        }

        $lokasis = $lokasis->get();
        return $this->sendResponse($lokasis, 'Lokasi retrieved successfully.');
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'locationname' => 'required|string',
            'floor_id' => 'required|exists:master_lantai,id',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $lokasi = LokasiModel::create($input);

        return $this->sendCreatedResponse($lokasi, 'Lokasi created successfully.');
    }

    public function show($id): JsonResponse
    {
        $lokasi = LokasiModel::find($id);

        if (is_null($lokasi)) {
            return $this->sendError('lokasi not found.');
        }

        return $this->sendResponse($lokasi, 'Lokasi retrieved successfully.');
    }

    public function update(Request $request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'locationname' => 'required|string',
            'floor_id' => 'required|exists:master_lantai,id',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $lokasi = lokasiModel::find($id);

        if (is_null($lokasi)) {
            return $this->sendError('Lokasi not found.');
        }

        $lokasi->update($request->all());

        return $this->sendUpdateResponse($lokasi, 'Lokasi updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): JsonResponse
    {
        $lokasi = LokasiModel::find($id);

        if (is_null($lokasi)) {
            return $this->sendError('Lokasi not found.');
        }

        $lokasi->delete();

        return $this->sendDeleteResponse('Lokasi deleted successfully.');
    }
}
