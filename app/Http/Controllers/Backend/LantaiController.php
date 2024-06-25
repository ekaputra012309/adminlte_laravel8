<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LantaiModel;
use RealRashid\SweetAlert\Facades\Alert;

class LantaiController extends Controller
{
    public function index()
    {
        $Lantais = LantaiModel::all();
        $data = array(
            'title' => 'Floor | ',
            'datalantai' => $Lantais,
        );
        $title = 'Delete Lantai Gedung!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('backend.lantai.index', $data);
    }

    public function create()
    {
        $data = array(
            'title' => 'Add Floor | ',
        );
        return view('backend.lantai.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'floorname' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id'
        ]);

        LantaiModel::create($request->all());
        Alert::success('Success', 'Floor created successfully.');

        return redirect()->route('lantai.index');
    }

    public function show(LantaiModel $Lantai)
    {
        $data = array(
            'title' => 'View Floor | ',
        );
        return view('backend.lantai.show', $data);
    }

    public function edit(LantaiModel $Lantai)
    {
        $data = array(
            'title' => 'Edit Floor | ',
            'lantai' => $Lantai,
        );
        return view('backend.lantai.edit', $data);
    }

    public function update(Request $request, LantaiModel $Lantai)
    {
        $request->validate([
            'floorname' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id'
        ]);

        $Lantai->update($request->all());
        Alert::success('Success', 'Floor updated successfully.');

        return redirect()->route('lantai.index');
    }

    public function destroy(LantaiModel $Lantai)
    {
        $Lantai->delete();
        Alert::success('Success', 'Floor deleted successfully.');

        return redirect()->route('lantai.index');
    }
}
