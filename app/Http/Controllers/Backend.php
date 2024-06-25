<?php

namespace App\Http\Controllers;

use App\Models\PermintaanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Backend extends Controller
{
    public function signin()
    {
        $data = array(
            'title' => 'Login | ',
        );
        return view('backend.login', $data);
    }

    public function register()
    {
        $data = array(
            'title' => 'Register | ',
        );
        return view('backend.register', $data);
    }

    public function dashboard()
    {
        $permintaan = PermintaanModel::with('kategori')
            ->select('kategori_id')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('kategori_id')
            ->get();

        $kategoriLabels = $permintaan->pluck('kategori.hashtag')->toArray();
        $kategoriCountsData = $permintaan->pluck('count')->toArray();

        $data = [
            'title' => 'Dashboard | ',
            'kategoriLabels' => $kategoriLabels,
            'kategoriCountsData' => $kategoriCountsData,
        ];

        return view('backend.dashboard', $data);
    }

    public function profile(Request $request)
    {
        $data = array(
            'title' => 'Profile | ',
            'user' => $request->user(),
        );
        return view('backend.profile', $data);
    }
}
