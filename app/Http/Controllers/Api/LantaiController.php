<?php

namespace App\Http\Controllers\API;

use App\Models\LantaiModel;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class LantaiController extends BaseController
{
    public function index(): JsonResponse
    {
        $lantais = LantaiModel::all();
        return $this->sendResponse($lantais, 'Lantais retrieved successfully.');
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'floorname' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $lantai = LantaiModel::create($input);

        return $this->sendCreatedResponse($lantai, 'Lantai created successfully.');
    }

    public function show($id): JsonResponse
    {
        $lantai = LantaiModel::find($id);

        if (is_null($lantai)) {
            return $this->sendError('Lantai not found.');
        }

        return $this->sendResponse($lantai, 'Lantai retrieved successfully.');
    }

    public function update(Request $request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'floorname' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $lantai = LantaiModel::find($id);

        if (is_null($lantai)) {
            return $this->sendError('Lantai not found.');
        }

        $lantai->update($request->all());

        return $this->sendUpdateResponse($lantai, 'Lantai updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): JsonResponse
    {
        $lantai = LantaiModel::find($id);

        if (is_null($lantai)) {
            return $this->sendError('Lantai not found.');
        }

        $lantai->delete();

        return $this->sendDeleteResponse('Lantai deleted successfully.');
    }
}
