<?php

namespace App\Http\Controllers;

use App\Models\Documentation;
use App\Models\Progress;
use App\Models\Task;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $vendors = Vendor::with('user')->get();
        $taskss = Task::with(['progress' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->get();

        $tasks = $taskss->map(function ($task) {
            $firstProgress = $task->progress->first();
            $task->progress = get_progress($task, $firstProgress);

            return $task;
        });

        $graph = (object) [
            'series' => [],
            'categories' => ['Minggu I', 'Minggu II', 'Minggu III', 'Minggu IV', 'Minggu V', 'Minggu VI', 'Minggu VII']
        ];

        foreach (Task::all() as $item) {
            $data = [];
            foreach ($item->progress as $progress) {
                $progress = get_progress($item, $progress);
                $data[] = $progress->persentase;
            }

            $graph->series[] = (object) [
                'name' => $item->nama_paket,
                'data' => $data
            ];
        }

        return view('pages.dashboard.index', compact('vendors', 'tasks', 'graph'));
    }

    public function add()
    {
        $query = Vendor::query();

        if (auth()->user()->role == 'VENDOR') {
            $user = User::where('id', auth()->user()->id)->first();
            $query = $query->where('user_id', $user->id);
        }

        $vendors = $query->with('user')->get();

        return view('pages.dashboard.add', compact('vendors'));
    }

    public function report(Request $request)
    {
        $filter = Task::query();

        if (isset($request->tanggal)) {
            $filter->where('tanggal', $request->tanggal);
        }

        if (isset($request->vendor_id)) {
            $filter->where('vendor_id', $request->vendor_id);
        }

        $tasks = $filter->with(['progress' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])
            ->with('vendor')
            ->get();

        $tasks = $tasks->map(function ($task) {
            $firstProgress = $task->progress->first();
            $task->progress = get_progress($task, $firstProgress);

            return $task;
        });

        $vendors = Vendor::all();

        return view('pages.dashboard.report', compact('tasks', 'vendors'));
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
                'tanggal' => 'required|date',
                'nama_paket' => 'required|string|max:255',
                'vendor_id' => 'required|string|max:255',
                'nilai_kontrak_jtm' => 'required',
                'nilai_kontrak_jtr' => 'required',
                'nilai_kontrak_gardu' => 'required',
                'ongkos_angkut' => 'required',
                'latitude' => 'required|string|max:255',
                'longitude' => 'required|string|max:255',
                'keterangan' => 'required|string|max:255',
            ] + $dokumentasiRules);

            Vendor::where('id', $request->vendor_id)->update([
                'pengawas_k3' => $request->pengawas_k3
            ]);

            $input = $request->only([
                'tanggal', 'nama_paket', 'vendor_id', 'target_jtm', 'target_jtr', 'target_gardu', 'nilai_kontrak_jtm', 'nilai_kontrak_jtr', 'nilai_kontrak_gardu', 'ongkos_angkut', 'latitude', 'longitude', 'keterangan'
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

            Progress::create([
                'task_id' => $data->id,
                'jtm' => 0,
                'jtr' => 0,
                'gardu' => 0
            ]);

            if (auth()->user()->role == 'VENDOR') {
                return redirect()->route('dashboard.task')->with('success', 'Data berhasil disimpan.');
            }

            return redirect()->route('dashboard.report')->with('success', 'Data berhasil disimpan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage())->withInput();
        }
    }

    public function detail($uuid)
    {
        $task = Task::where('uuid', $uuid)
            ->with(['progress' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }])
            ->with('vendor')
            ->first();

        $latestProgress = $task->progress->first();
        $progress = get_progress($task, $latestProgress);

        return view('pages.dashboard.detail', compact('task', 'progress'));
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
                'vendor_id' => 'required|string|max:255',
                'jtm' => 'required|numeric',
                'jtr' => 'required|numeric',
                'gardu' => 'required|string|max:255',
                'progres' => 'required|numeric|between:0,100',
                'keterangan' => 'required|string|max:255',
                'latitude' => 'required|string|max:255',
                'longitude' => 'required|string|max:255',
            ] + $dokumentasiRules);

            $input = $request->only([
                'nama_paket', 'vendor_id', 'jtm', 'jtr', 'gardu', 'progres', 'latitude', 'longitude', 'keterangan'
            ]);

            $data = Task::where('uuid', $uuid)->first();
            $data->fill($input);
            $data->save();

            if ($request->hasFile('dokumentasi')) {
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

    public function profile()
    {
        try {
            $user = User::where('id', auth()->user()->id)->firstOrFail();

            return view('pages.dashboard.profile', compact('user'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['message' => ['Terjadi kesalahan!', $e->getMessage()]]);
        }
    }

    public function update_profile(Request $request)
    {
        try {
            $user = User::where('id', auth()->user()->id)->firstOrFail();
            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->save();

            return redirect()
                ->back()
                ->with('success', 'Data berhasil diedit!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['message' => ['Terjadi kesalahan!', $e->getMessage()]]);
        }
    }

    public function change_password_profile(Request $request)
    {
        try {
            $user = User::where('id', auth()->user()->id)->firstOrFail();

            $request->validate([
                'old_password' => 'required|current_password',
                'new_password' => 'required',
                'repeat_new_password' => 'required|same:new_password'
            ]);

            $user->password = Hash::make($request->new_password);
            $user->save();

            return redirect()
                ->back()
                ->with('success', 'Password berhasil diubah!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['message' => ['Terjadi kesalahan!', $e->getMessage()]]);
        }
    }
}
