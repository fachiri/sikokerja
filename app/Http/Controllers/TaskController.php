<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProgresRequest;
use App\Models\Documentation;
use App\Models\Task;
use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Exports\TasksExport;
use Maatwebsite\Excel\Facades\Excel;

class TaskController extends Controller
{
    public function task()
    {
        $vendor = Vendor::where('user_id', auth()->user()->id)->first();
        $tasks = Task::where('vendor_id', $vendor->id)->get();

        return view("pages.dashboard.task", compact("tasks"));
    }

    public function progres($uuid)
    {
        $task = Task::where('uuid', $uuid)->first();

        return view("pages.dashboard.progres", compact("task"));
    }

    public function update_pengawas(Request $request, $id)
    {
        try {
            Vendor::find($id)->update($request->only('pengawas_k3'));

            return redirect()->route('dashboard.task')->with('success', 'Data pengawas berhasil diedit.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    public function update_progress(UpdateProgresRequest $request, $uuid)
    {
        try {
            $task = Task::where('uuid', $uuid)->first();
            $task->update($request->only('progres'));

            if ($request->hasFile('dokumentasi')) {
                foreach ($request->file('dokumentasi') as $file) {
                    $filePath = $file->store('public/dokumentasi');
                    Documentation::create([
                        'task_id' => $task->id,
                        'dokumentasi' => basename($filePath)
                    ]);
                }
            }

            return redirect()->back()->with('success', 'Data progres berhasil diupdate.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    public function export() 
    {
        $date = date('dmY');

        return Excel::download(new TasksExport, 'Laporan-'.$date.'.xlsx');
    }
}
