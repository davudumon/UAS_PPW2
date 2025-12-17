@extends('base')
@section('title','Edit Pegawai')

@section('content')
<section class="p-4 bg-white rounded-lg min-h-[50vh]">
    <h1 class="text-3xl font-bold text-[#C0392B] mb-6 text-center">Edit Pegawai</h1>

    <div class="mx-auto max-w-xl">
        <form action="{{ route('pegawai.update', ['id' => $data->id]) }}" method="POST"
            class="space-y-4 rounded-lg border p-6">
            @csrf @method('PUT')

            <input name="nama" value="{{ old('nama',$data->nama) }}"
                class="w-full border rounded px-3 py-2">

            <input name="email" type="email" value="{{ old('email',$data->email) }}"
                class="w-full border rounded px-3 py-2">

            <select name="gender" class="w-full border rounded px-3 py-2">
                <option value="male" @selected($data->gender=='male')>Male</option>
                <option value="female" @selected($data->gender=='female')>Female</option>
            </select>

            <select name="pekerjaan_id" class="w-full border rounded px-3 py-2">
                @foreach($pekerjaan as $p)
                <option value="{{ $p->id }}"
                    @selected($data->pekerjaan_id==$p->id)>
                    {{ $p->nama }}
                </option>
                @endforeach
            </select>

            <label class="flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1"
                    @checked($data->is_active)>
                Aktif
            </label>

            <div class="flex justify-between pt-4">
                <a href="{{ route('pegawai.index') }}" class="bg-gray-200 px-4 py-2 rounded">
                    Kembali
                </a>
                <button class="bg-blue-600 text-white px-4 py-2 rounded">
                    Update
                </button>
            </div>

        </form>
    </div>
</section>
@endsection