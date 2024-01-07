<?php

namespace App\Exports;

use App\Models\Task;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TasksExport implements FromView, WithStyles
{
    protected $filter;

    public function __construct($filter)
    {
        $this->filter = $filter;
    }

    public function view(): View
    {
        $filter = Task::query();

        // Apply filters if they are provided
        if ($this->filter['tanggal']) {
            $filter->where('tanggal', $this->filter['tanggal']);
        }

        if ($this->filter['vendor_id']) {
            $filter->where('vendor_id', $this->filter['vendor_id']);
        }

        $tasks = $filter->with(['progress' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])
            ->with('vendor')->get();


        $tasks = $tasks->map(function ($task) {
            $firstProgress = $task->progress->first();
            $task->progress = get_progress($task, $firstProgress);

            return $task;
        });

        return view('exports.tasks', compact('tasks'));
    }

    public function styles(Worksheet $sheet)
    {
        // Get the highest row and column with data
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

        // Define the range of cells with data
        $cellRange = 'A2:' . $highestColumn . $highestRow;

        // Apply borders only to the range with data
        $sheet->getStyle($cellRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        for ($col = 'A'; $col <= $highestColumn; ++$col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Set custom height for row 1 (A1:AMJ1)
        $sheet->getRowDimension(1)->setRowHeight(25);

        // Make text in row 1 bold
        $sheet->getStyle('A2:' . $highestColumn . '2')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);

        $sheet->getStyle('A1:' . $highestColumn . '1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);

        
        // Vertical align content in cell A1
        $sheet->getStyle('A1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        return [
            // You can add additional styles here if needed
        ];
    }
}
