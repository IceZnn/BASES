<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;

class DashboardController extends Controller
{
    public function __invoke(DashboardService $dashboardService)
    {
        return view('dashboard', $dashboardService->summary());
    }
}
