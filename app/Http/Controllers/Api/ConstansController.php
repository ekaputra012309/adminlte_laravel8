<?php

namespace App\Http\Controllers\Api;

use App\Models\ConstansModel;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class ConstansController extends BaseController
{
    public function index(): JsonResponse
    {
        $constanss = ConstansModel::all();
        return $this->sendResponse($constanss, 'Constans retrieved successfully.');
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'api' => 'required|string',
            'title' => 'required|string',
            'about' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $constans = ConstansModel::create($input);

        return $this->sendCreatedResponse($constans, 'Constans created successfully.');
    }

    public function show($id): JsonResponse
    {
        $constans = ConstansModel::find($id);

        if (is_null($constans)) {
            return $this->sendError('Constans not found.');
        }

        return $this->sendResponse($constans, 'Constans retrieved successfully.');
    }

    public function update(Request $request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'api' => 'required|string',
            'title' => 'required|string',
            'about' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $constans = ConstansModel::find($id);

        if (is_null($constans)) {
            return $this->sendError('Constans not found.');
        }

        $constans->update($request->all());

        return $this->sendUpdateResponse($constans, 'Constans updated successfully.');
    }

    public function destroy($id): JsonResponse
    {
        $constans = ConstansModel::find($id);

        if (is_null($constans)) {
            return $this->sendError('Constans not found.');
        }

        $constans->delete();

        return $this->sendDeleteResponse('Constans deleted successfully.');
    }
}
