<?php

namespace App\Livewire\Admin;

use App\Models\Seed;
use App\Models\SeedLot;
use Livewire\Component;

class SeedLotForm extends Component
{
    public ?SeedLot $seedLot     = null;
    public string $seed_id       = '';
    public string $lot_number    = '';
    public ?string $harvest_date = null;
    public ?string $origin_weight    = null;
    public ?string $origin_moisture  = null;
    public ?string $arrival_weight   = null;
    public ?string $arrival_moisture = null;
    public string $location          = '';
    public bool $autoLotNumber       = true;


    // Location alias
    public array $locationOptions = [
        'KP' => 'KP — Kendalpayak',
        'JG' => 'JG — Jambegede',
        'NG' => 'NG — Ngale',
        'MN' => 'MN — Muneng',
        'GT' => 'GT — Genteng',
    ];

    protected function rules(): array
    {
        $lotRule = 'required|string|max:50|unique:seed_lots,lot_number';
        if ($this->seedLot && $this->seedLot->exists) {
            $lotRule .= ',' . $this->seedLot->id;
        }
        return [
            'seed_id'          => 'required|exists:seeds,id',
            'lot_number'       => $lotRule,
            'harvest_date'     => 'nullable|date',
            'origin_weight'    => 'nullable|numeric|min:0',
            'origin_moisture'  => 'nullable|numeric|min:0|max:100',
            'arrival_weight'   => 'nullable|numeric|min:0',
            'arrival_moisture' => 'nullable|numeric|min:0|max:100',
            'location'         => 'nullable|string|max:10',
        ];
    }

    protected function messages(): array
    {
        return [
            'seed_id.required'          => 'Varietas benih wajib dipilih.',
            'seed_id.exists'            => 'Varietas benih yang dipilih tidak ditemukan.',
            'lot_number.required'       => 'Nomor lot wajib diisi.',
            'lot_number.max'            => 'Nomor lot maksimal 50 karakter.',
            'lot_number.unique'         => 'Nomor lot ini sudah digunakan, gunakan nomor yang berbeda.',
            'harvest_date.date'         => 'Tanggal panen tidak valid.',
            'origin_weight.numeric'     => 'Berat asal harus berupa angka.',
            'origin_weight.min'         => 'Berat asal tidak boleh negatif.',
            'origin_moisture.numeric'   => 'Kadar air asal harus berupa angka.',
            'origin_moisture.min'       => 'Kadar air asal minimal 0%.',
            'origin_moisture.max'       => 'Kadar air asal maksimal 100%.',
            'arrival_weight.numeric'    => 'Berat tiba harus berupa angka.',
            'arrival_weight.min'        => 'Berat tiba tidak boleh negatif.',
            'arrival_moisture.numeric'  => 'Kadar air tiba harus berupa angka.',
            'arrival_moisture.min'      => 'Kadar air tiba minimal 0%.',
            'arrival_moisture.max'      => 'Kadar air tiba maksimal 100%.',
        ];
    }

    public function mount(?SeedLot $seedLot = null): void
    {
        if ($seedLot && $seedLot->exists) {
            $this->seedLot         = $seedLot;
            $this->seed_id         = (string) $seedLot->seed_id;
            $this->lot_number      = $seedLot->lot_number;
            $this->harvest_date    = $seedLot->harvest_date?->format('Y-m-d');
            $this->origin_weight   = $seedLot->origin_weight;
            $this->origin_moisture = $seedLot->origin_moisture;
            $this->arrival_weight  = $seedLot->arrival_weight;
            $this->arrival_moisture= $seedLot->arrival_moisture;
            $this->location        = $seedLot->location ?? '';
            $this->autoLotNumber   = false;
        } else {
            $this->generateLotNumber();
        }
    }

    public function updatedSeedId(): void
    {
        if ($this->autoLotNumber) $this->generateLotNumber();
    }

    public function updatedLocation(): void
    {
        if ($this->autoLotNumber) $this->generateLotNumber();
    }

    public function generateLotNumber(): void
    {
        $alias  = $this->location ?: 'XX';
        $year2  = now()->format('y');
        $abbr   = 'XX';  
        $kelas  = 'XX';   

        if ($this->seed_id) {
            $seed = Seed::with('category')->find($this->seed_id);
            if ($seed) {
                $abbr  = strtoupper($seed->category?->abbr ?? 'XX');
                $kelas = $seed->var_class->value;
            }
        }

        $count = SeedLot::whereYear('created_at', now()->year)
            ->where('lot_number', '~', '^\d{3}-')  // PostgreSQL regex: start 3 digit 
            ->count() + 1;

        $this->lot_number = sprintf('%03d-%s-XX-%s-%s-%s', $count, $abbr, $kelas, $alias, $year2);
    }

    public function save(): void
    {
        $data = $this->validate();

        if ($this->seedLot && $this->seedLot->exists) {
            // ── Update lot yang sudah ada 
            $arrivalChanged = (float) ($this->seedLot->arrival_weight ?? 0)
                           !== (float) ($data['arrival_weight'] ?? 0);

            $this->seedLot->update($data);

            // Jika arrival_weight berubah, recalculate stok (raw_stock berdasarkan arrival)
            if ($arrivalChanged) {
                \App\Observers\SeedLotObserver::recalculate($this->seedLot->fresh());
            }

            session()->flash('success', 'Lot benih berhasil diperbarui.');
        } else {
            // ── Buat lot baru ────────────────────────────────────────────
            // raw_stock awal = arrival_weight (berat benih saat tiba)
            // Graded & clean dimulai dari 0, akan bertambah saat proses produksi
            $data['status']      = 'Raw';
            $data['raw_stock']   = (float) ($data['arrival_weight'] ?? 0);
            $data['graded_stock'] = 0;
            $data['clean_stock']  = 0;

            SeedLot::create($data);
            session()->flash('success', 'Lot benih berhasil ditambahkan. Stok mentah diset ke ' .
                number_format($data['raw_stock'], 2) . ' kg sesuai berat tiba.');
        }

        $this->redirect(route('admin.seed-lots.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.seed-lot-form', [
            'seeds' => Seed::with('category')->orderBy('var_name')->get(),
        ]);
    }
}
