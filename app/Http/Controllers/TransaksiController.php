<?php

namespace App\Http\Controllers;

use App\Imports\TransaksiImport;
use App\Models\Obat;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::OrderByDesc('id')->get();
        $transaksiCount = Transaksi::count();
        return view('layouts.pages.transaksi', compact('transaksi', 'transaksiCount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'obat' => 'required',
        ]);

        $transaksi = Transaksi::create([
            'tanggal' => $request->tanggal,
            'obat' => $request->obat,
        ]);

        return redirect()->route('transaksi')->with('message', 'Transaksi berhasil disimpan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'obat' => 'required',
        ]);

        $transaksi = Transaksi::findOrFail($id);
        $transaksi->update([
            'tanggal' => $request->tanggal,
            'obat' => $request->obat,
        ]);

        return redirect()->route('transaksi')->with('message', 'Transaksi berhasil diperbarui.');
    }

    public function delete($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();
        return redirect()->route('transaksi')->with('message', 'Data berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        Excel::import(new TransaksiImport, $request->file('file'));

        return redirect()->back()->with('success', 'Data berhasil diimport');
    }
}
