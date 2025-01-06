@extends('layouts.guest')

@section('title', 'Register')

@section('content')
    <div class="bg-white py-6 rounded-xl border-2 border-primary w-full md:w-7/12 lg:w-6/12 xl:w-3/12 m-5">
        <div class="flex flex-col justify-center items-center text-center my-6">
            <div class="flex mb-6 justify-center items-center">
                <img src="{{ asset('assets/img/logo_polije.png') }}" alt="logo" width="120px">
                <img src="{{ asset('assets/img/logo_sitik.png') }}" alt="logo" width="150px">
            </div>
            <div class="w-10/12">
                <h3 class="font-semibold text-2xl">Daftar Akun</h3>
                <p class="w-full mt-2 text-primary">Masukkan email dan kata sandi Anda di bawah ini</p>

                @if ($errors->any())
                    <div id="alert-2" class="flex p-4 mt-4 text-red-950 rounded-lg bg-red-300" role="alert">
                        <div class="ml-3 font-normal">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button type="button"
                            class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700"
                            data-dismiss-target="#alert-2" aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                @endif

                <form action="{{ route('register.store') }}" method="POST">
                    @csrf
                    <div class="flex mt-4 items-start flex-col">
                        <label for="username" class="text-primary font-semibold">Nama</label>
                        <input type="text" name="username" id="username" placeholder="Masukkan Nama"
                            value="{{ old('username') }}" required
                            class="w-full h-12 mt-2 border border-primary rounded-md py-2 px-4 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary duration-500">
                        @error('username')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex mt-4 items-start flex-col">
                        <label for="email" class="text-primary font-semibold">Email</label>
                        <input type="email" name="email" id="email" placeholder="Masukkan Email"
                            value="{{ old('email') }}" required
                            class="w-full h-12 mt-2 border border-primary rounded-md py-2 px-4 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary duration-500">
                        @error('email')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex mt-4 items-start flex-col">
                        <label for="password" class="text-primary font-semibold">Kata Sandi</label>
                        <input type="password" name="password" id="password" placeholder="Masukkan Kata Sandi" required
                            class="w-full h-12 mt-2 border border-primary rounded-md py-2 px-4 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary duration-500">
                        @error('password')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex mt-4 items-start flex-col">
                        <label for="password_confirmation" class="text-primary font-semibold">Konfirmasi Kata Sandi</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            placeholder="Konfirmasi Kata Sandi" required
                            class="w-full h-12 mt-2 border border-primary rounded-md py-2 px-4 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary duration-500">
                    </div>

                    <div class="flex flex-col mt-5 mb-2">
                        <button type="submit"
                            class="w-full bg-primary rounded-md mb-2 h-12 text-white hover:bg-hover duration-500">Daftar</button>
                        <div class="flex mt-3 items-center flex-row justify-center">
                            <div class="flex mt-2 items-center flex-row justify-center">
                                <p class="text-xs mr-2">Sudah memiliki akun?</p>
                                <a href="{{ route('login') }}"
                                    class="text-xs text-primary outline-none underline duration-500">Masuk</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
