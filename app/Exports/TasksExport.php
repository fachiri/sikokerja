<?php

namespace App\Exports;

use App\Models\Task;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TasksExport implements FromCollection, WithHeadings
{
    public function collection()
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


        return $tasks;
    }

    public function headings(): array
    {
        return [
            'Nama Paket',
            'Vendor',
            'JTM',
            'JTR',
            'Gardu',
            'Progres',
            'Pengawas K3',
            'Keterangan',
            'Latitude',
            'Longitude',
        ];
    }
}
