<?php

namespace App\Http\Controllers;

use App\Models\Documentation;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.index');
    }

    public function add()
    {
        $pengawas = User::where('role', 'PENGAWAS')->get();

        return view('pages.dashboard.add', compact('pengawas'));
    }

    public function report()
    {
        $tasks = Task::with('user')->get();

        return view('pages.dashboard.report', compact('tasks'));
    }

    public function store(Request $request)
    {
        try {
            $dokumentasiRules = [];
            if ($request->hasFile('dokumentasi')) {
                foreach ($request->file('dokumentasi') as $key => $file) {
                    $dokumentasiRules["dokumentasi.{$key}"] = 'required|file|mimes:jpeg,png,pdf|max:2048';
                }
            } else {
                $dokumentasiRules["dokumentasi"] = 'required|file|mimes:jpeg,png,pdf|max:2048';
            }

            $request->validate([
                'nama_paket' => 'required|string|max:255',
                'vendor' => 'required|string|max:255',
                'jtm' => 'required|numeric',
                'jtr' => 'required|numeric',
                'gardu' => 'required|string|max:255',
                'progres' => 'required|numeric|between:0,100',
                'pengawas_k3' => 'required|string|max:255',
                'latitude' => 'required|string|max:255',
                'longitude' => 'required|string|max:255',
            ] + $dokumentasiRules);

            $input = $request->only([
                'nama_paket', 'vendor', 'jtm', 'jtr', 'gardu', 'progres', 'pengawas_k3', 'latitude', 'longitude'
            ]);

            $data = new Task();
            $data->fill($input);
            $data->save();

            foreach ($request->file('dokumentasi') as $file) {
                $filePath = $file->store('public/dokumentasi');
                Documentation::create([
                    'task_id' => $data->id,
                    'dokumentasi' => basename($filePath)
                ]);
            }

            return redirect()->route('dashboard.report')->with('success', 'Data berhasil disimpan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage())->withInput();
        }
    }

    public function edit($uuid)
    {
        $task = Task::where('uuid', $uuid)->first();

        return view('pages.dashboard.edit', compact('task'));
    }

    public function update(Request $request, $uuid)
    {
        try {
            $dokumentasiRules = [];
            if ($request->hasFile('dokumentasi')) {
                foreach ($request->file('dokumentasi') as $key => $file) {
                    $dokumentasiRules["dokumentasi.{$key}"] = 'nullable|file|mimes:jpeg,png,pdf|max:2048';
                }
            } else {
                $dokumentasiRules["dokumentasi"] = 'nullable|file|mimes:jpeg,png,pdf|max:2048';
            }

            $request->validate([
                'nama_paket' => 'required|string|max:255',
                'vendor' => 'required|string|max:255',
                'jtm' => 'required|numeric',
                'jtr' => 'required|numeric',
                'gardu' => 'required|string|max:255',
                'progres' => 'required|numeric|between:0,100',
                'pengawas_k3' => 'required|string|max:255',
                'koordinat' => 'required|string|max:255',
            ] + $dokumentasiRules);

            $input = $request->only([
                'nama_paket', 'vendor', 'jtm', 'jtr', 'gardu', 'progres', 'pengawas_k3', 'koordinat'
            ]);

            $data = Task::where('uuid', $uuid)->first();
            $data->fill($input);
            $data->save();

            if ($request->hasFile('dokumentasi')) {
                Documentation::where('task_id', $data->id)->delete();
                foreach ($request->file('dokumentasi') as $file) {
                    $filePath = $file->store('public/dokumentasi');
                    Documentation::create([
                        'task_id' => $data->id,
                        'dokumentasi' => basename($filePath)
                    ]);
                }
            }

            return redirect()->route('dashboard.edit', $data->uuid)->with('success', 'Data berhasil diedit.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    public function delete($uuid)
    {
        try {
            $task = Task::where('uuid', $uuid)->first();
            
            if (!$task) {
                return redirect()->route('dashboard.report')->with('error', 'Data tidak ditemukan.');
            }

            foreach ($task->documentations as $documentation) {
                Storage::delete('public/dokumentasi/' . $documentation->dokumentasi);
            }

            Documentation::where('task_id', $task->id)->delete();

            $task->delete();

            return redirect()->route('dashboard.report')->with('success', 'Data berhasil dihapus.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    public function dokumentasi($uuid)
    {
        $task = Task::where('uuid', $uuid)->with('documentations')->first();

        return view('pages.dashboard.documentation', compact('task'));
    }
}
