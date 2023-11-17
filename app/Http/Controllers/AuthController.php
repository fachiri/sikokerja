<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('pages.auth.login');
    }

    public function auth_login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()
                ->route('dashboard.index')
                ->withSuccess('Selamat datang <b>'. auth()->user()->name.'</b>');
        }

        return redirect()
            ->back()
            ->withErrors(['message' => 'Ups! Username atau password salah']);
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect()
            ->route('login');
    }

    public function change_password(Request $request)
    {
        try {
            $user = User::where('id', auth()->user()->id)->firstOrFail();

            $validator = Validator::make($request->all(), [
                'old_password' => 'required|current_password',
                'new_password' => 'required',
                'repeat_new_password' => 'required|same:new_password'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            $user->password = Hash::make($request->new_password);
            $user->save();

            Session::flush();
            Auth::logout();

            return redirect()
                ->route('login')
                ->with('success', 'Password berhasil diubah!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['message' => ['Terjadi kesalahan!', $e->getMessage()]]);
        }
    }
}
