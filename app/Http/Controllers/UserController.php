<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $roles = Role::all();

        return view('pages.dashboard.user', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'role' => 'required|string|max:15',
                'name' => 'required|string|max:50',
                'username' => 'required|unique:users,username',
                'email' => 'required|email|unique:users,email',
                'no_telp' => 'required|digits:12|unique:users,no_telp',
            ]);

            $data = new User();
            $data->fill($request->only(['role', 'name', 'username', 'email', 'no_telp']) + ['password' => Hash::make($request->username)]);
            $data->save();

            return redirect()->route('dashboard.users.index')->with('success', 'Data berhasil disimpan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage())->withInput();
        }
    }

    public function update(Request $request)
    {
        // dd($request);

        // return view('pages.dashboard.user', compact('users'));
    }
}
