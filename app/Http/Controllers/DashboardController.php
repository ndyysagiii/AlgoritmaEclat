<?php

namespace App\Http\Controllers;

use App\Models\EclatResult;
use App\Models\EclatResultDetail;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Ramsey\Uuid\v1;

class DashboardController extends Controller
{
    public function index()
    {
        return view('layouts.pages.dashboard');
    }
}
