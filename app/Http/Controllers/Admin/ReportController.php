<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\ReportExport;
use App\Models\Order;
use App\Models\Orderitem;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function view(Request $request) {
        if ($request->date) {
            $date = explode('-', $request->date);
        } else {
            $date = explode('-', date('Y-m'));
        }
        $Y = $date[0];
        $m = $date[1];
        return view('admin.report', [
            'orders' => Order::with('orderitems')->where('status', 'unpaid')->whereMonth('tanggalTransaksi', '=', $m)->whereYear('tanggalTransaksi', '=', $Y)->get()
        ]);
    }

    public function export(Request $request) {
        $request->validate([
            'date' => 'required|date|date_format:Y-m'
        ]);
        $Row = count(Orderitem::all()) + 2;
        return Excel::download(new ReportExport($request->date, $Row), 'report.xlsx');
    }
}
