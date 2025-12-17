<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Pekerjaan;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function index()
    {
        $gender = Pegawai::select('gender', DB::raw('count(*) as total'))
            ->groupBy('gender')
            ->pluck('total', 'gender');

        $male = $gender['male'] ?? 0;
        $female = $gender['female'] ?? 0;

        $pekerjaan = Pekerjaan::withCount('pegawai')
            ->orderByDesc('pegawai_count')
            ->limit(5)
            ->get();

        $jobLabels = $pekerjaan->pluck('nama');
        $jobTotals = $pekerjaan->pluck('pegawai_count');

        return view('index', [
            'male' => $male,
            'female' => $female,
            'jobLabels' => $jobLabels,
            'jobTotals' => $jobTotals, 
        ]);
    }
}
