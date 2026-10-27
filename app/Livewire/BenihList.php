<?php

namespace App\Livewire;

use App\Models\SeedCategory;
use Livewire\Component;

class BenihList extends Component
{
    /** Definisi kelas mutu benih. */
    public const CLASSES = [
        [
            'code'  => 'BS',
            'label' => 'Benih Penjenis',
            'color' => '#1F3D2B',
            'step'  => 1,
            'desc'  => 'Benih sumber yang diproduksi langsung oleh pemulia tanaman. Kelas ini adalah tetua awal untuk tahapan perbanyakan selanjutnya.',
        ],
        [
            'code'  => 'FS',
            'label' => 'Benih Dasar',
            'color' => '#3B7F9E',
            'step'  => 2,
            'desc'  => 'Turunan pertama dari Benih Penjenis. Proses produksinya diawasi ketat untuk menjamin standar mutunya.',
        ],
        [
            'code'  => 'SS',
            'label' => 'Benih Pokok',
            'color' => '#D9A536',
            'step'  => 3,
            'desc'  => 'Hasil perbanyakan dari Benih Dasar. Benih inilah yang nantinya akan diperbanyak lagi menjadi benih sebar untuk petani.',
        ],
    ];

    public static function formatKg(float $value): string
    {
        if (abs($value - round($value)) < 0.005) {
            return number_format($value, 0, ',', '.');
        }

        return rtrim(rtrim(number_format($value, 2, ',', '.'), '0'), ',');
    }

    public function render()
    {
        $classCodes  = array_column(self::CLASSES, 'code');
        $classByCode = array_column(self::CLASSES, null, 'code');

        // Ambil kategori, varietas, dan lot secara real-time
        $categories = SeedCategory::with(['seeds' => function ($q) {
            $q->withSum('seedLots', 'clean_stock')->orderBy('var_name');
        }])->orderBy('id')->get();

        // Flat list: satu entry per (varietas, kelas) yang punya stok > 0
        $cards = [];
        $classTotals = array_fill_keys($classCodes, 0.0);
        $grand = 0.0;

        foreach ($categories as $category) {
            // Grup varietas dalam kategori ini per nama & kelas
            $byVar = [];
            foreach ($category->seeds as $seed) {
                $cls   = $seed->var_class?->value;
                $name  = $seed->var_name;
                $stock = (float) ($seed->seed_lots_sum_clean_stock ?? 0);

                if (! in_array($cls, $classCodes, true)) {
                    continue;
                }

                $byVar[$name][$cls] = ($byVar[$name][$cls] ?? 0.0) + $stock;
                $classTotals[$cls] += $stock;
                $grand             += $stock;
            }

            foreach ($byVar as $varName => $clsStocks) {
                foreach ($classCodes as $code) {
                    $stock = $clsStocks[$code] ?? 0.0;
                    if ($stock <= 0) {
                        continue; // hanya tampilkan yang ada stok
                    }

                    $cls = $classByCode[$code];
                    $cards[] = [
                        'category'   => $category->name,
                        'variety'    => $varName,
                        'class_code' => $code,
                        'class_name' => $cls['label'],
                        'color'      => $cls['color'],
                        'step'       => $cls['step'],
                        'stock'      => self::formatKg($stock),
                        'key'        => $category->id . '-' . $varName . '-' . $code,
                    ];
                }
            }
        }

        // Kelas untuk seksi "Memahami kelas benih" & Hero ledger
        $classes = array_map(function (array $c) use ($classTotals, $grand) {
            $tot = $classTotals[$c['code']] ?? 0.0;

            return [
                'code'      => $c['code'],
                'label'     => $c['label'],
                'color'     => $c['color'],
                'desc'      => $c['desc'],
                'step'      => $c['step'],
                'totalText' => self::formatKg($tot),
                'pct'       => $grand > 0 ? round(($tot / $grand) * 100) . '%' : '0%',
            ];
        }, self::CLASSES);

        $segs = array_map(function (array $c) use ($classTotals, $grand) {
            $tot = $classTotals[$c['code']] ?? 0.0;

            return [
                'color' => $c['color'],
                'pct'   => $grand > 0 ? number_format(($tot / $grand) * 100, 2, '.', '') . '%' : '0%',
            ];
        }, self::CLASSES);

        return view('livewire.benih-list', [
            'classes'   => $classes,
            'segs'      => $segs,
            'grandText' => self::formatKg($grand),
            'cards'     => $cards,
            'noResults' => empty($cards),
        ]);
    }
}
