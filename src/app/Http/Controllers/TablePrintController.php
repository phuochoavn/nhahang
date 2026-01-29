<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TablePrintController extends Controller
{
    public function show(Table $table)
    {
        $url = url('/?table=' . $table->id);
        
        // Generate SVG string
        $qrCode = QrCode::size(300)->generate($url);

        return view('print.qr', [
            'table' => $table,
            'qrCode' => $qrCode,
            'url' => $url,
        ]);
    }

    public function download(Table $table)
    {
        $url = url('/?table=' . $table->id);
        $qrCode = QrCode::format('svg')->size(500)->generate($url);
        
        return response($qrCode)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Content-Disposition', 'attachment; filename="qr-table-' . $table->id . '.svg"');
    }
}
