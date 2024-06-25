<?php

namespace App\Http\Controllers\API;

use App\Models\KategoriModel;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class KategoriController extends BaseController
{
    public function index(Request $request): JsonResponse
    {
        $kategori1 = $request->post('kategoriId');
        $kategoris = KategoriModel::query();
        if ($kategori1) {
            $kategori1 = $kategoris->where('categoryname', $kategori1);
        }

        $kategoris = $kategoris->get();
        return $this->sendResponse($kategoris, 'Kategori retrieved successfully.');
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'hashtag' => 'required|string',
            'categoryname' => 'required|in:Hardware,Software,Jaringan,Other',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $kategori = KategoriModel::create($input);

        return $this->sendCreatedResponse($kategori, 'Kategori created successfully.');
    }

    public function show($id): JsonResponse
    {
        $kategori = KategoriModel::find($id);

        if (is_null($kategori)) {
            return $this->sendError('Kategori not found.');
        }

        return $this->sendResponse($kategori, 'Kategori retrieved successfully.');
    }

    public function update(Request $request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'hashtag' => 'required|string',
            'categoryname' => 'required|in:Hardware,Software,Jaringan,Other',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $kategori = KategoriModel::find($id);

        if (is_null($kategori)) {
            return $this->sendError('Kategori not found.');
        }

        $kategori->update($request->all());

        return $this->sendUpdateResponse($kategori, 'Kategori updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): JsonResponse
    {
        $kategori = KategoriModel::find($id);

        if (is_null($kategori)) {
            return $this->sendError('Kategori not found.');
        }

        $kategori->delete();

        return $this->sendDeleteResponse('Kategori deleted successfully.');
    }
}
