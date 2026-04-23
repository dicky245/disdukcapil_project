<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DasarHukum;

class DasarHukumController extends Controller
{
    public function index(){
        $data = DasarHukum::all();
        return view('admin.dasar_hukum', compact('data'));
    }

    public function store(Request $request){
        $request -> validate([
            'file' => 'required|file|mimes:pdf|max:500',
            'nama' => 'required|string|length:100',
            'deskripsi_singkat' => 'required|string'
        ]);
        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, $id){
        $data = DasarHukum::findOrFail($id);
        $data -> update([
            'file' => $request->file('file'),
            'nama' => $request -> nama,
            'deskripsi_singkat' => $request -> deskripsi_singkat
        ]);
        return redirect()->back()->with('success', 'Data berhasil diupdate');
    }

    public function delete($id){
        $data = DasarHukum::findOrFail($id);
        $data -> delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

}
