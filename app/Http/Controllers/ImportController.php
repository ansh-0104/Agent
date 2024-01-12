<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    

public function index()
{
    return view('import');
}

public function import(Request $request)
{
    $request->validate([
        'csv_file' => 'required|mimes:csv,txt',
    ]);

    $file = $request->file('csv_file');
    
    // Process the CSV file and create users
    Excel::import(new UsersImport, $file);

    return redirect()->route('import.index')->with('success', 'Users imported successfully');
}

}
