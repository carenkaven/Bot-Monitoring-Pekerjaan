@extends('layouts.app')

@section('content')

    <div class="max-w-5xl mx-auto">

        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-transparent dark:border-slate-700/50">

            <div class="border-b border-gray-100 dark:border-slate-700/50 px-8 py-6">

                <h1 class="text-3xl font-bold text-slate-800 dark:text-white">
                    Edit Karyawan
                </h1>

                <p class="text-slate-500 dark:text-slate-400 mt-2">
                    Perbarui data karyawan.
                </p>

            </div>

            @if($errors->any())

                <div
                    class="mx-8 mt-6 bg-red-100 dark:bg-red-500/10 border border-red-300 dark:border-red-500/20 text-red-700 dark:text-red-400 rounded-xl p-4">

                    <ul class="list-disc ml-5 font-medium">

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <form action="{{ route('karyawan.update', $karyawan->id) }}" method="POST">

                @csrf
                @method('PUT')

                <div class="p-8 grid grid-cols-1 lg:grid-cols-2 gap-6">

                    <div>

                        <label class="font-semibold text-slate-700 dark:text-slate-300">
                            Nama Lengkap
                        </label>

                        <input type="text" name="nama" value="{{ old('nama', $karyawan->nama) }}"
                            class="mt-2 w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:ring-blue-500 dark:focus:ring-blue-500/50"
                            required>

                    </div>

                    <div>

                        <label class="font-semibold text-slate-700 dark:text-slate-300">
                            Jabatan
                        </label>

                        <select name="jabatan"
                            class="mt-2 w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:ring-blue-500 dark:focus:ring-blue-500/50">

                            @php

                                $jabatan = [
                                    'Supervisor',
                                    'Mandor',
                                    'Site Engineer',
                                    'Quality Control',
                                    'Safety Officer',
                                    'Staff'
                                ];

                            @endphp

                            @foreach($jabatan as $j)

                                <option value="{{ $j }}" {{ $karyawan->jabatan == $j ? 'selected' : '' }}>

                                    {{ $j }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div>

                        <label class="font-semibold text-slate-700 dark:text-slate-300">
                            Nomor WhatsApp
                        </label>

                        <input type="text" name="no_hp" value="{{ old('no_hp', $karyawan->no_hp) }}"
                            class="mt-2 w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:ring-blue-500 dark:focus:ring-blue-500/50"
                            required>

                    </div>

                    <div>

                        <label class="font-semibold text-slate-700 dark:text-slate-300">
                            Email
                        </label>

                        <input type="email" name="email" value="{{ old('email', $karyawan->email) }}"
                            class="mt-2 w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:ring-blue-500 dark:focus:ring-blue-500/50"
                            required>

                    </div>

                    <div>

                        <label class="font-semibold text-slate-700 dark:text-slate-300">
                            Status
                        </label>

                        <select name="status"
                            class="mt-2 w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:ring-blue-500 dark:focus:ring-blue-500/50">

                            <option value="aktif" {{ $karyawan->status == 'aktif' ? 'selected' : '' }}>

                                Aktif

                            </option>

                            <option value="nonaktif" {{ $karyawan->status == 'nonaktif' ? 'selected' : '' }}>

                                Nonaktif

                            </option>

                        </select>

                    </div>

                </div>

                <div class="border-t border-gray-100 dark:border-slate-700/50 px-8 py-6 flex justify-end gap-3">

                    <a href="{{ route('karyawan.index') }}"
                        class="bg-slate-200 hover:bg-slate-300 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-800 dark:text-slate-100 px-6 py-2.5 rounded-xl transition font-medium">

                        Kembali

                    </a>

                    <button
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl shadow-md shadow-blue-500/20 transition font-medium">

                        Update

                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection