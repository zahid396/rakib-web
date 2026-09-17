@extends('admin.layouts.app')

@section('title', 'Analytics')

@section('content')
    <div class="page-header">
        <h1>Analytics</h1>
        <p>Visitor statistics for your store. Tracking started when the analytics feature was deployed.</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon primary">&#128202;</div>
            <div class="stat-content">
                <h4>{{ number_format($totals['total_visits']) }}</h4>
                <p>Total Visits</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon info">&#128101;</div>
            <div class="stat-content">
                <h4>{{ number_format($totals['unique_visitors']) }}</h4>
                <p>Unique Visitors (All Time)</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon success">&#128336;</div>
            <div class="stat-content">
                <h4>{{ number_format($totals['today_visits']) }}</h4>
                <p>Visits Today ({{ number_format($totals['today_unique']) }} unique)</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon warning">&#128197;</div>
            <div class="stat-content">
                <h4>{{ number_format($totals['last30_visits']) }}</h4>
                <p>Last 30 Days ({{ number_format($totals['last30_unique']) }} unique)</p>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Visits &amp; Unique Visitors - Last 14 Days</h3>
        </div>
        <div class="card-body">
            <canvas id="trafficChart" height="80"></canvas>
        </div>
    </div>

    <div class="dash-grid" style="margin-top:1.25rem;">
        <div class="card">
            <div class="card-header">
                <h3>Top Pages - Last 30 Days</h3>
            </div>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Page</th>
                            <th style="text-align:right;">Visits</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topPages as $page)
                            <tr>
                                <td><code style="font-size:0.85rem;">/{{ $page->url }}</code></td>
                                <td style="text-align:right;">{{ number_format($page->count) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" style="text-align:center; color:var(--text-secondary);">No visits recorded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3>Top Referrers - Last 30 Days</h3>
            </div>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Source</th>
                            <th style="text-align:right;">Visits</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($referrers as $ref)
                            <tr>
                                <td style="word-break:break-word;">{{ \Illuminate\Support\Str::limit($ref->referer, 60) }}</td>
                                <td style="text-align:right;">{{ number_format($ref->count) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" style="text-align:center; color:var(--text-secondary);">No external referrers yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card" style="margin-top:1.25rem; max-width:520px;">
        <div class="card-header">
            <h3>Devices - Last 30 Days</h3>
        </div>
        <div class="card-body">
            <canvas id="deviceChart" height="90"></canvas>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var rootStyle = getComputedStyle(document.body);
        var lineColor = rootStyle.getPropertyValue('--primary').trim() || '#6366f1';

        new Chart(document.getElementById('trafficChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode($chartDays) !!},
                datasets: [{
                    label: 'Visits',
                    data: {!! json_encode($chartVisits) !!},
                    borderColor: lineColor,
                    backgroundColor: lineColor + '22',
                    fill: true,
                    tension: 0.3
                }, {
                    label: 'Unique Visitors',
                    data: {!! json_encode($chartUnique) !!},
                    borderColor: '#f59e0b',
                    backgroundColor: '#f59e0b22',
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 } }
                }
            }
        });

        var deviceData = {!! json_encode([
            'desktop' => (int) ($devices['desktop']->count ?? 0),
            'mobile' => (int) ($devices['mobile']->count ?? 0),
            'tablet' => (int) ($devices['tablet']->count ?? 0),
            'other' => (int) ($devices['other']->count ?? 0),
        ]) !!};

        var labels = [];
        var counts = [];
        var colors = ['#6366f1', '#f59e0b', '#10b981', '#94a3b8'];

        ['desktop', 'mobile', 'tablet', 'other'].forEach(function (key, i) {
            if (deviceData[key] > 0) {
                labels.push(key.charAt(0).toUpperCase() + key.slice(1));
                counts.push(deviceData[key]);
            }
        });

        new Chart(document.getElementById('deviceChart'), {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: counts,
                    backgroundColor: colors
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    });
</script>
@endpush