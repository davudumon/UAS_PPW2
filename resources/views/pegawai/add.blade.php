@extends('base')
@section('title','Tambah Pegawai')

@section('content')
<section class="p-4 bg-white rounded-lg min-h-[50vh]">
    <h1 class="text-3xl font-bold text-[#C0392B] mb-6 text-center">Tambah Pegawai</h1>

    <div class="mx-auto max-w-xl">
        <form action="{{ route('pegawai.store') }}" method="POST"
            class="space-y-4 rounded-lg border p-6">
            @csrf

            <input name="nama" value="{{ old('nama') }}" placeholder="Nama"
                class="w-full border rounded px-3 py-2">

            <input name="email" type="email" value="{{ old('email') }}" placeholder="Email"
                class="w-full border rounded px-3 py-2">

            <select name="gender" class="w-full border rounded px-3 py-2">
                <option value="">-- Gender --</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>

            <select name="pekerjaan_id" class="w-full border rounded px-3 py-2">
                <option value="">-- Pekerjaan --</option>
                @foreach($pekerjaan as $p)
                <option value="{{ $p->id }}">{{ $p->nama }}</option>
                @endforeach
            </select>

            <label class="flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" checked>
                Aktif
            </label>

            <div class="flex justify-between pt-4">
                <a href="{{ route('pegawai.index') }}" class="bg-gray-200 px-4 py-2 rounded">
                    Kembali
                </a>
                <button class="bg-green-600 text-white px-4 py-2 rounded">
                    Simpan
                </button>
            </div>

        </form>
    </div>
</section>
@endsection