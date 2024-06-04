<?php

namespace App\Http\Controllers;

use App\Models\Confidence;
use App\Models\EclatCalculation;
use App\Models\Itemset2;
use App\Models\Itemset3;
use App\Models\Proses;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HasilController extends Controller
{
    public function index()
    {
        $proses = Proses::all();
        $count = Proses::count();
        return view('layouts.pages.hasil', compact('proses', 'count'));
    }

    public function show($id)
    {
        $proses = Proses::findOrFail($id);
        $itemset2 = Itemset2::where('proses_id', $id)->with('confidences')->get();
        $itemset3 = Itemset3::where('proses_id', $id)->with('confidences')->get();

        return view('layouts.pages.detail', compact('proses', 'itemset2', 'itemset3'));
    }

    public function generatePDF($id)
    {
        $proses = Proses::findOrFail($id);
        $itemset2 = Itemset2::where('proses_id', $id)->with('confidences')->get();
        $itemset3 = Itemset3::where('proses_id', $id)->with('confidences')->get();

        $pdf = Pdf::loadView('layouts.pages.pdf', compact('proses', 'itemset2', 'itemset3'));

        $timestamp = Carbon::now()->format('Ymd_His');
        $fileName = 'eclat_' . $timestamp . '.pdf';

        return $pdf->download($fileName);
    }
}
