<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ProcessType;
use App\Http\Controllers\Controller;
use App\Models\ProductionProcess;
use App\Models\SeedLot;
use Illuminate\Support\Collection;
use OpenSpout\Common\Entity\Cell;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Writer\XLSX\Writer as XlsxWriter;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    private const TITLE   = 'Laporan Export Benih - BRMP Aneka Kacang';
    private const HEADERS = [
        'Lot Benih',
        'Varietas',
        'Kelas Benih',
        'Komoditas',
        'Berat Awal (kg)',
        'Stok (kg)',
        'Sortir (kg)',
        'Limbah (kg)',
    ];

    /**
     * Halaman menu Export Benih: menampilkan lot yang sudah melewati proses produksi.
     */
    public function index()
    {
        $lotsQuery = SeedLot::has('productionProcesses');

        $summary = [
            'total_lots'    => (clone $lotsQuery)->count(),
            'total_arrival' => (float) (clone $lotsQuery)->sum('arrival_weight'),
            'total_clean'   => (float) (clone $lotsQuery)->sum('clean_stock'),
            'total_sortir'  => (float) ProductionProcess::where('process_type', ProcessType::Sorting)->sum('sortir_quantity'),
            'total_waste'   => (float) ProductionProcess::where('process_type', ProcessType::Sorting)->sum('waste_quantity'),
        ];
        $summary['recovery_rate'] = $summary['total_arrival'] > 0
            ? round(($summary['total_clean'] / $summary['total_arrival']) * 100, 1)
            : 0;

        $lots = SeedLot::with('seed.category')
            ->has('productionProcesses')
            ->withSum(['productionProcesses as sortir_total' => fn ($q) => $q->where('process_type', ProcessType::Sorting)], 'sortir_quantity')
            ->withSum(['productionProcesses as waste_total' => fn ($q) => $q->where('process_type', ProcessType::Sorting)], 'waste_quantity')
            ->orderBy('updated_at', 'desc')
            ->paginate(15);

        return view('admin.reports.index', compact('lots', 'summary'));
    }

    /**
     * Unduh Laporan Export Benih dalam format CSV.
     * Pemisah titik koma dan BOM UTF-8 agar langsung rapi saat dibuka di Excel (locale Indonesia).
     */
    public function stockAvailability(): StreamedResponse
    {
        $now      = now()->timezone('Asia/Jakarta');
        $rows     = $this->rows();
        $filename = $this->filename($now, 'csv');

        return response()->streamDownload(function () use ($rows, $now) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF"); // BOM UTF-8

            fputcsv($out, [self::TITLE], ';');
            fputcsv($out, [$this->periodText($now)], ';');
            fputcsv($out, [], ';');
            fputcsv($out, self::HEADERS, ';');

            foreach ($rows as $r) {
                fputcsv($out, [
                    $r['lot_number'],
                    $r['variety'],
                    $r['class'],
                    $r['category'],
                    number_format($r['arrival_weight'], 2, ',', ''),
                    number_format($r['clean_stock'], 2, ',', ''),
                    number_format($r['sortir'], 2, ',', ''),
                    number_format($r['limbah'], 2, ',', ''),
                ], ';');
            }

            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    /**
     * Unduh Laporan Export Benih dalam format Excel (.xlsx).
     */
    public function stockAvailabilityXlsx(): BinaryFileResponse
    {
        $now  = now()->timezone('Asia/Jakarta');
        $path = tempnam(sys_get_temp_dir(), 'rpt') . '.xlsx';

        $bold   = (new Style())->withFontBold(true);
        $writer = new XlsxWriter();
        $writer->openToFile($path);
        $writer->getCurrentSheet()->setName('Export Benih');

        $boldRow = fn (array $values) => new Row(
            array_map(fn ($v) => Cell::fromValue($v, $bold), $values)
        );

        $writer->addRow($boldRow([self::TITLE]));
        $writer->addRow(Row::fromValues([$this->periodText($now)]));
        $writer->addRow(Row::fromValues([]));
        $writer->addRow($boldRow(self::HEADERS));

        foreach ($this->rows() as $r) {
            $writer->addRow(Row::fromValues([
                $r['lot_number'],
                $r['variety'],
                $r['class'],
                $r['category'],
                round($r['arrival_weight'], 2),
                round($r['clean_stock'], 2),
                round($r['sortir'], 2),
                round($r['limbah'], 2),
            ]));
        }

        $writer->close();

        return response()
            ->download($path, $this->filename($now, 'xlsx'), [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ])
            ->deleteFileAfterSend(true);
    }

    /** Data lot benih yang sudah melalui proses produksi, dipakai bersama oleh CSV dan Excel. */
    private function rows(): Collection
    {
        return SeedLot::with('seed.category')
            ->has('productionProcesses')
            ->withSum(['productionProcesses as sortir_total' => fn ($q) => $q->where('process_type', 'Sorting')], 'sortir_quantity')
            ->withSum(['productionProcesses as waste_total' => fn ($q) => $q->where('process_type', 'Sorting')], 'waste_quantity')
            ->orderBy('updated_at', 'desc')
            ->get()
            ->map(function ($lot) {
                return [
                    'lot_number'     => $lot->lot_number,
                    'variety'        => $lot->seed->var_name ?? '-',
                    'class'          => $lot->seed->var_class?->value ?? '-',
                    'category'       => $lot->seed->category?->name ?? '-',
                    'arrival_weight' => (float) ($lot->arrival_weight ?? 0),
                    'clean_stock'    => (float) ($lot->clean_stock ?? 0),
                    'sortir'         => (float) ($lot->sortir_total ?? 0),
                    'limbah'         => (float) ($lot->waste_total ?? 0),
                ];
            })
            ->values();
    }

    private function periodText($now): string
    {
        return 'Per tanggal: ' . $now->translatedFormat('d F Y, H:i') . ' WIB';
    }

    private function filename($now, string $ext): string
    {
        return 'laporan-export-benih-' . $now->format('Ymd-His') . '.' . $ext;
    }
}
