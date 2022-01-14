<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ReportExport implements FromView, WithEvents, ShouldAutoSize
{
    protected $date;
    protected $row;
    public function __construct($date, $row)
    {
        $this->date = $date;
        $this->row = $row;
    }
    public function view(): View
    {
        $date = explode('-', $this->date);
        $Y = $date[0];
        $m = $date[1];
        return view('admin.exports.report', [
            'orders' => Order::with('orderitems')->where('status', 'unpaid')->whereMonth('tanggalTransaksi', '=', $m)->whereYear('tanggalTransaksi', '=', $Y)->get()
        ]);
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:S'.$this->row)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => 'thin',
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                $event->sheet->getStyle('A1:R2')->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                    ],
                ]);
            }
        ];
    }
}
