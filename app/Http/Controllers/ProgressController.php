<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProgressRequest;
use App\Models\Documentation;
use App\Models\Progress;
use App\Models\Task;
use App\Models\Vendor;
use Illuminate\Http\Request;

class ProgressController extends Controller
{
    public function add(Request $request)
    {
        $task = null;

        if ($request->has('paket_id')) {
            $task = Task::where('id', $request->paket_id)->first();
        }

        $query = Task::query();

        if (auth()->user()->role === 'VENDOR') {
            $vendor = Vendor::where('user_id', auth()->user()->id)->first();
            $query->where('vendor_id', $vendor->id);
        }

        $tasks = $query->get();

        return view("pages.dashboard.progress.add", compact('tasks', 'task'));
    }

    public function store(StoreProgressRequest $request)
    {
        try {
            Progress::create($request->only('task_id', 'jtm', 'jtr', 'gardu'));

            foreach ($request->file('dokumentasi') as $file) {
                $filePath = $file->store('public/dokumentasi');
                Documentation::create([
                    'task_id' => $request->task_id,
                    'dokumentasi' => basename($filePath)
                ]);
            }

            return redirect()->back()->with('success', 'Data berhasil disimpan.');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage())->withInput();
        }
    }
}
