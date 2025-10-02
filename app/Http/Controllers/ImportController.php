<?php

namespace App\Http\Controllers;

use App\Imports\MovimientosImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function index()
    {
        return view('import.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new MovimientosImport, $request->file('file'));

        return redirect()->back()->with('success', 'Archivo importado exitosamente.');
    }
}
