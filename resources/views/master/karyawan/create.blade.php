@extends('layouts.app')

@section('content')

    <div class="max-w-5xl mx-auto">

        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-transparent dark:border-slate-700/50">

            <div class="border-b border-gray-100 dark:border-slate-700/50 px-8 py-6">

                <h1 class="text-3xl font-bold text-slate-800 dark:text-white">

                    Tambah Karyawan

                </h1>

                <p class="text-slate-500 dark:text-slate-400 mt-2">

                    Tambahkan karyawan baru agar dapat menggunakan WhatsApp Bot.

                </p>

            </div>

            {{-- Global error banner --}}
            @if ($errors->any())
                <div
                    class="mx-8 mt-6 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-700/50 text-red-700 dark:text-red-300 px-4 py-3 rounded-xl">
                    <p class="font-semibold mb-1">Terjadi kesalahan:</p>
                    <ul class="list-disc list-inside text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('karyawan.store') }}" method="POST">

                @csrf

                <div class="p-8 grid grid-cols-1 lg:grid-cols-2 gap-6">

                    {{-- Nama --}}
                    <div>

                        <label class="font-semibold text-slate-700 dark:text-slate-300">

                            Nama Lengkap

                        </label>

                        <input type="text" name="nama" value="{{ old('nama') }}" required class="mt-2 w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:ring-blue-500 dark:focus:ring-blue-500/50
                                @error('nama') border-red-500 dark:border-red-500 @enderror">

                        @error('nama')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                    </div>

                    {{-- Jabatan --}}
                    <div>

                        <label class="font-semibold text-slate-700 dark:text-slate-300">

                            Jabatan

                        </label>

                        <select name="jabatan" required class="mt-2 w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:ring-blue-500 dark:focus:ring-blue-500/50
                                @error('jabatan') border-red-500 dark:border-red-500 @enderror">

                            <option value="" class="text-slate-400">-- Pilih Jabatan --</option>

                            <option {{ old('jabatan') == 'Supervisor' ? 'selected' : '' }}>Supervisor</option>
                            <option {{ old('jabatan') == 'Mandor' ? 'selected' : '' }}>Mandor</option>
                            <option {{ old('jabatan') == 'Site Engineer' ? 'selected' : '' }}>Site Engineer</option>
                            <option {{ old('jabatan') == 'Quality Control' ? 'selected' : '' }}>Quality Control</option>
                            <option {{ old('jabatan') == 'Safety Officer' ? 'selected' : '' }}>Safety Officer</option>
                            <option {{ old('jabatan') == 'Staff' ? 'selected' : '' }}>Staff</option>

                        </select>

                        @error('jabatan')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                    </div>

                    {{-- No HP --}}
                    <div>

                        <label class="font-semibold text-slate-700 dark:text-slate-300">

                            Nomor WhatsApp

                        </label>

                        <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="628xxxxxxxxxx" required
                            class="mt-2 w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:ring-blue-500 dark:focus:ring-blue-500/50
                                @error('no_hp') border-red-500 dark:border-red-500 @enderror">

                        @error('no_hp')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                    </div>

                    {{-- Email --}}
                    <div>

                        <label class="font-semibold text-slate-700 dark:text-slate-300">

                            Email

                        </label>

                        <input type="email" name="email" value="{{ old('email') }}" required class="mt-2 w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:ring-blue-500 dark:focus:ring-blue-500/50
                                @error('email') border-red-500 dark:border-red-500 @enderror">

                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                    </div>

                    {{-- Password --}}
                    <div>

                        <label class="font-semibold text-slate-700 dark:text-slate-300">

                            Password

                        </label>

                        <input type="password" name="password" required class="mt-2 w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:ring-blue-500 dark:focus:ring-blue-500/50
                                @error('password') border-red-500 dark:border-red-500 @enderror">

                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                    </div>

                    {{-- Konfirmasi Password --}}
                    <div>

                        <label class="font-semibold text-slate-700 dark:text-slate-300">

                            Konfirmasi Password

                        </label>

                        <input type="password" name="password_confirmation" required
                            class="mt-2 w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:ring-blue-500 dark:focus:ring-blue-500/50">

                    </div>

                    {{-- Status --}}
                    <div>

                        <label class="font-semibold text-slate-700 dark:text-slate-300">

                            Status

                        </label>

                        <select name="status"
                            class="mt-2 w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:ring-blue-500 dark:focus:ring-blue-500/50">

                            <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>

                            <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>

                        </select>

                    </div>

                </div>

                <div class="border-t border-gray-100 dark:border-slate-700/50 px-8 py-6 flex justify-end gap-3">

                    <a href="{{ route('karyawan.index') }}"
                        class="bg-slate-200 hover:bg-slate-300 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-800 dark:text-slate-100 px-6 py-2.5 rounded-xl transition font-medium">

                        Batal

                    </a>

                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl shadow-md shadow-blue-500/20 transition font-medium">

                        Simpan

                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection