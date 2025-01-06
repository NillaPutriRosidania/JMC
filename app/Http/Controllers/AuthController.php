<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{

    public function index()
    {
        return view('auth.login');
    }

    public function create()
    {
        return view('auth.register');
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Kata sandi harus diisi.',
            'password.min' => 'Kata sandi harus minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);


        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        return redirect('login')->with('success', 'Registrasi berhasil!');
    }

    public function show(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email harus diisi.',
            'password.required' => 'Kata sandi harus diisi.',
        ]);

        $registeredUser = User::where('email', $request->email)->first();

        if ($registeredUser) {
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                return redirect('dashboard');
            } else {
                return back()->withInput()->withErrors(['error' => 'Email dan Password yang dimasukkan tidak sesuai']);
            }
        }

        return back()->withInput()->withErrors(['error' => 'Akun tidak ditemukan!']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        return view('auth.forgot');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Auth::logout();
        Session::flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
