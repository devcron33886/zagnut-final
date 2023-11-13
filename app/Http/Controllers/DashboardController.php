<?php

namespace App\Http\Controllers;
use App\Models\Work;
class DashboardController extends Controller
{
    public function __invoke()
    {
        $works = Work::simplePaginate(30);
        $bar_total = Work::sum('bar_amount');
        $kitchen_total = Work::sum('kitchen_amount');
        $chamber_total = Work::sum('chamber_amount');
        $bingalo_total = Work::sum('bingalo_amount');
        $percentages = Work::sum('payout');
        $total = $bar_total + $kitchen_total + $chamber_total + $bingalo_total;

        return view('dashboard', compact('works', 'bar_total', 'kitchen_total', 'chamber_total', 'bingalo_total', 'percentages','total'));
    }
}
