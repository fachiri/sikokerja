<?php

namespace App\Exports;

use App\Models\Task;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TasksExport implements FromView
{
    public function view(): View
    {
        $tasks = Task::with(['vendor.user:id,name', 'vendor:id,pengawas_k3'])
            ->select(
                'tasks.nama_paket',
                'users.name as nama_user',
                'tasks.jtm',
                'tasks.jtr',
                'tasks.gardu',
                'tasks.progres',
                'vendors.pengawas_k3',
                'tasks.keterangan',
                'tasks.latitude',
                'tasks.longitude'
            )
            ->join('vendors', 'tasks.vendor_id', '=', 'vendors.id')
            ->join('users', 'vendors.user_id', '=', 'users.id')
            ->get();

        return view('exports.tasks', [
            'tasks' => $tasks
        ]);
    }

    // public function headings(): array
    // {
    //     return [
    //         [
    //             'Monitoring Progres Pekerjaan Lisdes UP2K GORONTALO'
    //         ],
    //         [
    //             'Nama Paket',
    //             'Vendor',
    //             'JTM',
    //             'JTR',
    //             'Gardu',
    //             'Progres',
    //             'Pengawas K3',
    //             'Keterangan',
    //             'Latitude',
    //             'Longitude',
    //         ]
    //     ];
    // }

    // public function styles(Worksheet $sheet)
    // {
    //     $sheet->mergeCells('A1:J1');

    //     return [];
    // }
}
