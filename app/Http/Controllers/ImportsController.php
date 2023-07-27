<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

// Imports
use App\Imports\ContactsImport;

class ImportsController extends Controller
{
    public function index(){
        return view('imports.browse');
    }
    public function store(){
        try {
            Excel::import(new ContactsImport, request()->file('file'));
            return redirect()->route('imports.index')->with(['message' => 'Datos importados correctamente', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->route('imports.index')->with(['message' => 'Ocurrió un error en el servidor', 'alert-type' => 'error']);
        }
    }
}
