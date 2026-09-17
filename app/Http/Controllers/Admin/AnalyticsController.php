<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisitLog;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    public function index(): View
    {
        $today = CarbonImmutable::today();
        $last30 = CarbonImmutable::now()->subDays(30);
        $last14 = CarbonImmutable::now()->subDays(13)->startOfDay();

        $totals = [
            'total_visits' => VisitLog::count(),
            'unique_visitors' => VisitLog::distinct('ip_hash')->count('ip_hash'),
            'today_visits' => VisitLog::since($today)->count(),
            'today_unique' => VisitLog::since($today)->distinct('ip_hash')->count('ip_hash'),
            'last30_visits' => VisitLog::since($last30)->count(),
            'last30_unique' => VisitLog::since($last30)->distinct('ip_hash')->count('ip_hash'),
        ];

        $topPages = VisitLog::since($last30)
            ->select('url', DB::raw('COUNT(*) as count'))
            ->groupBy('url')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        $devices = VisitLog::since($last30)
            ->select('device', DB::raw('COUNT(*) as count'))
            ->groupBy('device')
            ->orderByDesc('count')
            ->get()
            ->keyBy('device');

        $referrers = VisitLog::since($last30)
            ->whereNotNull('referer')
            ->where('referer', '!=', '')
            ->select('referer', DB::raw('COUNT(*) as count'))
            ->groupBy('referer')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        $daily = VisitLog::since($last14)
            ->select(
                DB::raw('DATE(visited_at) as day'),
                DB::raw('COUNT(*) as visits'),
                DB::raw('COUNT(DISTINCT ip_hash) as unique_visitors'),
            )
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->keyBy('day');

        $chartDays = [];
        $chartVisits = [];
        $chartUnique = [];

        for ($i = 13; $i >= 0; $i--) {
            $day = $last14->addDays($i)->toDateString();
            $chartDays[] = $day;
            $row = $daily->get($day);
            $chartVisits[] = $row ? (int) $row->visits : 0;
            $chartUnique[] = $row ? (int) $row->unique_visitors : 0;
        }

        return view('admin.analytics.index', compact(
            'totals', 'topPages', 'devices', 'referrers', 'chartDays', 'chartVisits', 'chartUnique'
        ));
    }
}