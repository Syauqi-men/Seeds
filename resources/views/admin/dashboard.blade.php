@extends('admin.layout')
@section('title', 'Dashboard')
@section('content')

@php
    // Format kg: 1.250,5 / 300 (tanpa nol desimal berlebih)
    $kg = fn ($v) => rtrim(rtrim(number_format((float) $v, 2, ',', '.'), '0'), ',');

    $productionCols = [
        ['key' => 'grading',   'label' => 'Grading',   'icon' => 'layers',      'hint' => 'Total hasil grading'],
        ['key' => 'sorting',   'label' => 'Sorting',   'icon' => 'list-filter', 'hint' => 'Total hasil sorting'],
        ['key' => 'unprocess', 'label' => 'Unprocess', 'icon' => 'package-open','hint' => 'Stok mentah belum diproses'],
    ];

    // Warna per komoditas untuk Pie Chart Stok
    $palette = [
        'Kedelai'      => '#059669', // Emerald
        'Kacang Hijau' => '#0EA5E9', // Sky Teal
        'Kacang Tanah' => '#F59E0B', // Amber Gold
    ];

    $commodityTotals = [];
    foreach ($commodities as $c) {
        $commodityTotals[$c] = (float) array_sum($stock[$c]);
    }
    $grandTotalStock = (float) array_sum($commodityTotals);

    $radius       = 96;
    $currentAngle = -M_PI / 2; // Mulai dari arah jam 12
    $pieSlices    = [];

    foreach ($commodities as $c) {
        $val   = $commodityTotals[$c];
        $ratio = $grandTotalStock > 0 ? ($val / $grandTotalStock) : (1 / max(1, count($commodities)));
        $angle = $ratio * 2 * M_PI;

        $startAngle = $currentAngle;
        $endAngle   = $currentAngle + $angle;
        $midAngle   = $startAngle + ($angle / 2);

        if ($angle >= (2 * M_PI - 0.0001)) {
            $path = sprintf(
                'M 0 %F A %F %F 0 1 1 0 %F A %F %F 0 1 1 0 %F Z',
                -$radius, $radius, $radius, $radius, $radius, $radius, -$radius
            );
            $tx = 0;
            $ty = 0;
        } elseif ($angle > 0.0001) {
            $x1       = $radius * cos($startAngle);
            $y1       = $radius * sin($startAngle);
            $x2       = $radius * cos($endAngle);
            $y2       = $radius * sin($endAngle);
            $largeArc = $angle > M_PI ? 1 : 0;
            $path     = sprintf(
                'M 0 0 L %F %F A %F %F 0 %d 1 %F %F Z',
                $x1, $y1, $radius, $radius, $largeArc, $x2, $y2
            );
            $tx = round(7 * cos($midAngle), 2);
            $ty = round(7 * sin($midAngle), 2);
        } else {
            $path = '';
            $tx   = 0;
            $ty   = 0;
        }

        $lx = round(($radius * 0.6) * cos($midAngle), 2);
        $ly = round(($radius * 0.6) * sin($midAngle), 2);

        $pieSlices[] = [
            'commodity'  => $c,
            'color'      => $palette[$c] ?? '#059669',
            'total'      => $val,
            'total_fmt'  => $kg($val),
            'pct'        => $grandTotalStock > 0 ? round($ratio * 100, 1) : 0,
            'path'       => $path,
            'tx'         => $tx,
            'ty'         => $ty,
            'lx'         => $lx,
            'ly'         => $ly,
            'show_label' => $ratio >= 0.08,
            'classes'    => [
                'BS' => $kg($stock[$c]['BS'] ?? 0),
                'FS' => $kg($stock[$c]['FS'] ?? 0),
                'SS' => $kg($stock[$c]['SS'] ?? 0),
            ],
        ];

        $currentAngle = $endAngle;
    }
@endphp

<div class="nv-page-head">
    <div>
        <h1>Beranda</h1>
        <p>Ringkasan data benih BRMP Aneka Kacang</p>
    </div>
    <div class="nv-page-head__tools">
        <button class="nv-btn" onclick="window.location.reload()">
            <i data-lucide="refresh-cw"></i> Refresh
        </button>
    </div>
</div>

<div class="nv-dash-stack">
    <div class="nv-panel nv-reveal" style="--i:1">
        <div class="nv-panel__body">
            <div class="nv-panel__head">
                <div class="nv-panel__title"><i data-lucide="cog"></i> Produksi</div>
                <span class="nv-cell-muted" style="font-size: var(--nv-text-xs);">dalam kg</span>
            </div>
            <div class="nv-prod">
                @foreach($productionCols as $col)
                <div class="nv-prod__col">
                    <div class="nv-prod__title">
                        <i data-lucide="{{ $col['icon'] }}"></i>
                        <div>
                            <strong>{{ $col['label'] }}</strong>
                            <span>{{ $col['hint'] }}</span>
                        </div>
                    </div>
                    @foreach($commodities as $commodity)
                    <div class="nv-kv">
                        <span>{{ $commodity }}</span>
                        <strong>{{ $kg($production[$col['key']][$commodity]) }} <small>kg</small></strong>
                    </div>
                    @endforeach
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="nv-panel nv-reveal" style="--i:2">
        <div class="nv-panel__body">
            <div class="nv-panel__head">
                <div class="nv-panel__title"><i data-lucide="truck"></i> Distribusi</div>
                <span class="nv-cell-muted" style="font-size: var(--nv-text-xs);">pesanan selesai (kg)</span>
            </div>
            <div class="nv-kv nv-kv--summary">
                <span><i data-lucide="users"></i> Jumlah pesanan</span>
                <strong>{{ number_format($customerCount) }}</strong>
            </div>
            <div class="nv-dist-label">Benih tersalur</div>
            <div class="nv-table__scroll" style="overflow: visible; max-height: none;">
                <table class="nv-table" style="min-width: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>Komoditas</th>
                            @foreach($classes as $class)
                                <th class="num">{{ $class }}</th>
                            @endforeach
                            <th class="num">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($commodities as $commodity)
                        @php $distTotal = array_sum($distributed[$commodity]); @endphp
                        <tr>
                            <td class="nv-cell-strong">{{ $commodity }}</td>
                            @foreach($classes as $class)
                                <td class="num">{{ $kg($distributed[$commodity][$class]) }} <span class="nv-cell-muted" style="font-size: var(--nv-text-xs);">kg</span></td>
                            @endforeach
                            <td class="num nv-cell-strong">{{ $kg($distTotal) }} <span class="nv-cell-muted" style="font-size: var(--nv-text-xs); font-weight: 400;">kg</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="nv-panel nv-reveal" style="--i:3">
        <div class="nv-panel__body">
            <div class="nv-panel__head">
                <div class="nv-panel__title"><i data-lucide="warehouse"></i> Stok</div>
                <span class="nv-cell-muted" style="font-size: var(--nv-text-xs);">
                    Total Stok Bersih: <strong style="color: var(--nv-text);">{{ $kg($grandTotalStock) }} kg</strong> (arahkan kursor pada grafik untuk rincian kelas BS, FS, SS)
                </span>
            </div>

            <div class="nv-stock-layout" style="display: grid; grid-template-columns: minmax(260px, 340px) minmax(0, 1fr); gap: 20px; padding: 16px; align-items: center;">
                <div class="nv-pie-box" style="position: relative; display: flex; flex-direction: column; align-items: center; justify-content: center; background: var(--nv-surface-muted); border: 1px solid var(--nv-border); border-radius: var(--nv-radius); padding: 18px 14px 14px;">
                    <svg id="nv-stock-pie" class="nv-pie-svg" width="210" height="210" viewBox="-115 -115 230 230" style="width: 210px; height: 210px; overflow: visible; display: block;" aria-label="Pie Chart Stok Benih">
                        @foreach($pieSlices as $idx => $slice)
                            @if($slice['path'] !== '')
                            <g style="cursor: pointer;"
                               data-idx="{{ $idx }}"
                               data-commodity="{{ $slice['commodity'] }}"
                               data-color="{{ $slice['color'] }}"
                               data-total="{{ $slice['total_fmt'] }}"
                               data-pct="{{ $slice['pct'] }}"
                               data-bs="{{ $slice['classes']['BS'] }}"
                               data-fs="{{ $slice['classes']['FS'] }}"
                               data-ss="{{ $slice['classes']['SS'] }}"
                               data-tx="{{ $slice['tx'] }}"
                               data-ty="{{ $slice['ty'] }}"
                               onmouseenter="nvShowPieTip(this, event)"
                               onmousemove="nvMovePieTip(event)"
                               onmouseleave="nvHidePieTip()">
                                <path id="nv-pie-path-{{ $idx }}"
                                      d="{{ $slice['path'] }}"
                                      fill="{{ $slice['color'] }}"
                                      stroke="#FFFFFF"
                                      stroke-width="2.5"
                                      class="nv-pie-slice"
                                      style="transition: transform 180ms ease, opacity 150ms ease;">
                                </path>
                                @if($slice['show_label'])
                                <text x="{{ $slice['lx'] }}"
                                      y="{{ $slice['ly'] }}"
                                      text-anchor="middle"
                                      dominant-baseline="central"
                                      fill="#FFFFFF"
                                      style="font-size: 11px; font-weight: 700; pointer-events: none; text-shadow: 0 1px 2px rgba(0,0,0,0.35);">
                                    {{ $slice['pct'] }}%
                                </text>
                                @endif
                            </g>
                            @endif
                        @endforeach
                    </svg>

                    <div class="nv-pie-legend" style="display: flex; flex-wrap: wrap; justify-content: center; gap: 8px 10px; margin-top: 12px; width: 100%;">
                        @foreach($pieSlices as $idx => $slice)
                            <div class="nv-pie-legend__item"
                                 id="nv-pie-leg-{{ $idx }}"
                                 style="display: inline-flex; align-items: center; gap: 6px; font-size: var(--nv-text-xs); padding: 4px 8px; border-radius: var(--nv-radius-sm); background: var(--nv-surface); border: 1px solid var(--nv-border); cursor: pointer; transition: border-color 150ms ease, background 150ms ease;"
                                 data-idx="{{ $idx }}"
                                 data-commodity="{{ $slice['commodity'] }}"
                                 data-color="{{ $slice['color'] }}"
                                 data-total="{{ $slice['total_fmt'] }}"
                                 data-pct="{{ $slice['pct'] }}"
                                 data-bs="{{ $slice['classes']['BS'] }}"
                                 data-fs="{{ $slice['classes']['FS'] }}"
                                 data-ss="{{ $slice['classes']['SS'] }}"
                                 data-tx="{{ $slice['tx'] }}"
                                 data-ty="{{ $slice['ty'] }}"
                                 onmouseenter="nvShowPieTip(this, event)"
                                 onmousemove="nvMovePieTip(event)"
                                 onmouseleave="nvHidePieTip()">
                                <span style="width: 9px; height: 9px; border-radius: 50%; display: inline-block; background: {{ $slice['color'] }};"></span>
                                <span style="font-weight: 500;">{{ $slice['commodity'] }}</span>
                                <strong style="font-variant-numeric: tabular-nums;">{{ $slice['total_fmt'] }} kg</strong>
                            </div>
                        @endforeach
                    </div>

                    <div id="nv-pie-tooltip"
                         style="display: none; position: fixed; z-index: 999; min-width: 215px; background: rgba(28, 29, 31, 0.96); color: #FFFFFF; border: 1px solid rgba(255, 255, 255, 0.14); border-radius: 10px; padding: 10px 12px; box-shadow: 0 12px 32px rgba(0,0,0,0.25); pointer-events: none; font-size: 0.78rem;">
                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 10px; padding-bottom: 6px; margin-bottom: 6px; border-bottom: 1px solid rgba(255, 255, 255, 0.15);">
                            <span style="display: inline-flex; align-items: center; gap: 6px; font-weight: 700; color: #FFFFFF;">
                                <span id="nv-tip-dot" style="width: 9px; height: 9px; border-radius: 50%; display: inline-block; background: #059669;"></span>
                                <span id="nv-tip-name">Kedelai</span>
                            </span>
                            <span id="nv-tip-total" style="font-weight: 600; color: #A7F3D0;">0 kg</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 3px 0; color: rgba(255,255,255,0.85);">
                            <span>Kelas BS</span>
                            <strong id="nv-tip-bs" style="color: #FFFFFF;">0 kg</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 3px 0; color: rgba(255,255,255,0.85);">
                            <span>Kelas FS</span>
                            <strong id="nv-tip-fs" style="color: #FFFFFF;">0 kg</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 3px 0; color: rgba(255,255,255,0.85);">
                            <span>Kelas SS</span>
                            <strong id="nv-tip-ss" style="color: #FFFFFF;">0 kg</strong>
                        </div>
                    </div>
                </div>

                <div class="nv-table__scroll" style="overflow: visible; max-height: none;">
                    <table class="nv-table" style="min-width: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Komoditas</th>
                                @foreach($classes as $class)
                                    <th class="num">Kelas {{ $class }}</th>
                                @endforeach
                                <th class="num">Total Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pieSlices as $idx => $slice)
                            <tr style="cursor: pointer;"
                                data-idx="{{ $idx }}"
                                data-commodity="{{ $slice['commodity'] }}"
                                data-color="{{ $slice['color'] }}"
                                data-total="{{ $slice['total_fmt'] }}"
                                data-pct="{{ $slice['pct'] }}"
                                data-bs="{{ $slice['classes']['BS'] }}"
                                data-fs="{{ $slice['classes']['FS'] }}"
                                data-ss="{{ $slice['classes']['SS'] }}"
                                data-tx="{{ $slice['tx'] }}"
                                data-ty="{{ $slice['ty'] }}"
                                onmouseenter="nvShowPieTip(this, event)"
                                onmousemove="nvMovePieTip(event)"
                                onmouseleave="nvHidePieTip()">
                                <td class="nv-cell-strong">
                                    <span style="display: inline-flex; align-items: center; gap: 8px;">
                                        <span style="width: 9px; height: 9px; border-radius: 50%; display: inline-block; background: {{ $slice['color'] }};"></span>
                                        {{ $slice['commodity'] }}
                                    </span>
                                </td>
                                @foreach($classes as $class)
                                    <td class="num">{{ $slice['classes'][$class] }} <span class="nv-cell-muted" style="font-size: var(--nv-text-xs);">kg</span></td>
                                @endforeach
                                <td class="num nv-cell-strong" style="color: var(--nv-accent-strong);">
                                    {{ $slice['total_fmt'] }} <span class="nv-cell-muted" style="font-size: var(--nv-text-xs); font-weight: 400;">kg</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function nvShowPieTip(el, evt) {
        var tip = document.getElementById('nv-pie-tooltip');
        if (!tip) return;

        var activeIdx = el.getAttribute('data-idx');
        var tx = el.getAttribute('data-tx') || 0;
        var ty = el.getAttribute('data-ty') || 0;

        document.getElementById('nv-tip-dot').style.background = el.getAttribute('data-color');
        document.getElementById('nv-tip-name').textContent = el.getAttribute('data-commodity');
        document.getElementById('nv-tip-total').textContent = el.getAttribute('data-total') + ' kg (' + el.getAttribute('data-pct') + '%)';
        document.getElementById('nv-tip-bs').textContent = el.getAttribute('data-bs') + ' kg';
        document.getElementById('nv-tip-fs').textContent = el.getAttribute('data-fs') + ' kg';
        document.getElementById('nv-tip-ss').textContent = el.getAttribute('data-ss') + ' kg';

        var paths = document.querySelectorAll('#nv-stock-pie .nv-pie-slice');
        paths.forEach(function(p, i) {
            if (String(i) === String(activeIdx)) {
                p.style.transform = 'translate(' + tx + 'px, ' + ty + 'px)';
                p.style.opacity = '1';
            } else {
                p.style.transform = 'translate(0, 0)';
                p.style.opacity = '0.72';
            }
        });

        tip.style.display = 'block';
        nvMovePieTip(evt);
    }

    function nvMovePieTip(evt) {
        var tip = document.getElementById('nv-pie-tooltip');
        if (!tip || !evt) return;
        tip.style.left = (evt.clientX + 16) + 'px';
        tip.style.top = (evt.clientY - 12) + 'px';
    }

    function nvHidePieTip() {
        var tip = document.getElementById('nv-pie-tooltip');
        if (tip) tip.style.display = 'none';

        var paths = document.querySelectorAll('#nv-stock-pie .nv-pie-slice');
        paths.forEach(function(p) {
            p.style.transform = 'translate(0, 0)';
            p.style.opacity = '1';
        });
    }
</script>
@endsection
