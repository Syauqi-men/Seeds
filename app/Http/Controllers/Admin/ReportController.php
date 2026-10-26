<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seed;
use Illuminate\Support\Collection;
use OpenSpout\Common\Entity\Cell;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Writer\XLSX\Writer as XlsxWriter;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    private const TITLE   = 'Laporan Ketersediaan Benih - BRMP Aneka Kacang';
    private const HEADERS = ['Komoditas', 'Varietas', 'Kelas Benih', 'Sisa Stok Bersih (kg)', 'Status Ketersediaan'];

    /**
     * Unduh Laporan Ketersediaan Benih (rekap per varietas dan kelas) dalam format CSV.
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
                    $r['category'],
                    $r['variety'],
                    $r['class'],
                    number_format($r['stock'], 2, ',', ''),
                    $r['status'],
                ], ';');
            }

            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    /**
     * Unduh Laporan Ketersediaan Benih dalam format Excel (.xlsx).
     * Stok ditulis sebagai angka asli agar bisa langsung dijumlahkan / dibuat pivot di Excel.
     */
    public function stockAvailabilityXlsx(): BinaryFileResponse
    {
        $now  = now()->timezone('Asia/Jakarta');
        $path = tempnam(sys_get_temp_dir(), 'rpt') . '.xlsx';

        $bold   = (new Style())->withFontBold(true);
        $writer = new XlsxWriter();
        $writer->openToFile($path);
        $writer->getCurrentSheet()->setName('Ketersediaan Benih');

        $boldRow = fn (array $values) => new Row(
            array_map(fn ($v) => Cell::fromValue($v, $bold), $values)
        );

        $writer->addRow($boldRow([self::TITLE]));
        $writer->addRow(Row::fromValues([$this->periodText($now)]));
        $writer->addRow(Row::fromValues([]));
        $writer->addRow($boldRow(self::HEADERS));

        foreach ($this->rows() as $r) {
            $writer->addRow(Row::fromValues([
                $r['category'],
                $r['variety'],
                $r['class'],
                round($r['stock'], 2),
                $r['status'],
            ]));
        }

        $writer->close();

        return response()
            ->download($path, $this->filename($now, 'xlsx'), [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ])
            ->deleteFileAfterSend(true);
    }

    /** Data rekap per varietas dan kelas, dipakai bersama oleh CSV dan Excel. */
    private function rows(): Collection
    {
        return Seed::with('category')
            ->withSum('seedLots', 'clean_stock')
            ->get()
            ->sortBy([
                fn ($a, $b) => strcmp($a->category?->name ?? '', $b->category?->name ?? ''),
                fn ($a, $b) => strcmp($a->var_name, $b->var_name),
                fn ($a, $b) => strcmp($a->var_class->value, $b->var_class->value),
            ])
            ->map(function ($seed) {
                $stock = (float) ($seed->seed_lots_sum_clean_stock ?? 0);

                return [
                    'category' => $seed->category?->name ?? '-',
                    'variety'  => $seed->var_name,
                    'class'    => $seed->var_class->label(),
                    'stock'    => $stock,
                    'status'   => $stock > 0 ? 'Tersedia' : 'Habis',
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
        return 'laporan-ketersediaan-benih-' . $now->format('Ymd-His') . '.' . $ext;
    }
}
