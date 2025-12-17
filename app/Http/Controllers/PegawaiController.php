<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Pekerjaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;

        $data = Pegawai::with('pekerjaan')
            ->when($keyword, function ($q) use ($keyword) {
                $q->where('nama', 'like', "%$keyword%");
            })
            ->paginate(5)
            ->withQueryString();

        return view('pegawai.index', compact('data'));
    }

    public function add()
    {
        $pekerjaan = Pekerjaan::all();
        return view('pegawai.add', compact('pekerjaan'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'email' => 'required|email|unique:zayyan_540567_pegawai,email',
            'gender' => 'required|in:male,female',
            'pekerjaan_id' => 'required|exists:zayyan_540567_pekerjaan,id',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Pegawai::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'gender' => $request->gender,
            'pekerjaan_id' => $request->pekerjaan_id,
            'is_active' => $request->is_active ?? true,
        ]);

        return redirect()->route('pegawai.index')
            ->with('type', 'success')
            ->with('message', 'Data pegawai berhasil ditambahkan');
    }


    public function edit(Request $request)
    {
        $data = Pegawai::findOrFail($request->id);
        $pekerjaan = Pekerjaan::all();

        return view('pegawai.edit', compact('data', 'pekerjaan'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'email' => 'required|email|unique:zayyan_540567_pegawai,email,' . $request->id,
            'gender' => 'required|in:male,female',
            'pekerjaan_id' => 'required|exists:zayyan_540567_pekerjaan,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = Pegawai::findOrFail($request->id);

        $data->nama = $request->nama;
        $data->email = $request->email;
        $data->gender = $request->gender;
        $data->pekerjaan_id = $request->pekerjaan_id;
        $data->is_active = $request->has('is_active');

        $data->save();

        return redirect()->route('pegawai.index')
            ->with('type', 'update')
            ->with('message', 'Data pegawai berhasil diperbarui.');
    }


    public function destroy($id)
    {
        Pegawai::findOrFail($id)->delete();

        return redirect()->route('pegawai.index')
            ->with('type', 'delete')
            ->with('message', 'Data pegawai berhasil dihapus');
    }
}
