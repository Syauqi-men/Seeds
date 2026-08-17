<?php

namespace App\Livewire\Admin;

use App\Enums\LotStatus;
use App\Models\Seed;
use App\Models\SeedLot;
use Livewire\Component;

class SeedLotForm extends Component
{
    public ?SeedLot $seedLot = null;
    public string $seed_id          = '';
    public string $lot_number       = '';
    public ?string $harvest_date    = null;
    public ?string $origin_weight   = null;
    public ?string $origin_moisture = null;
    public ?string $arrival_weight  = null;
    public ?string $arrival_moisture= null;
    public string $location         = '';
    public string $lot_code_prefix  = 'KD-DP-NS';
    public string $status           = 'Raw';
    public bool $autoLotNumber      = true;

    // Alias lokasi yang tersedia
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
            'lot_code_prefix'  => 'nullable|string|max:20',
            'status'           => 'required|in:Raw,Processing,Quarantine,Ready,Depleted',
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
            'status.required'           => 'Status lot wajib dipilih.',
            'status.in'                 => 'Status lot tidak valid.',
        ];
    }

    public function mount(?SeedLot $seedLot = null): void
    {
        if ($seedLot && $seedLot->exists) {
            $this->seedLot          = $seedLot;
            $this->seed_id          = (string) $seedLot->seed_id;
            $this->lot_number       = $seedLot->lot_number;
            $this->harvest_date     = $seedLot->harvest_date?->format('Y-m-d');
            $this->origin_weight    = $seedLot->origin_weight;
            $this->origin_moisture  = $seedLot->origin_moisture;
            $this->arrival_weight   = $seedLot->arrival_weight;
            $this->arrival_moisture = $seedLot->arrival_moisture;
            $this->location         = $seedLot->location ?? '';
            $this->lot_code_prefix  = $seedLot->lot_code_prefix ?? 'KD-DP-NS';
            $this->status           = $seedLot->status->value;
            $this->autoLotNumber    = false;
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

    public function updatedLotCodePrefix(): void
    {
        if ($this->autoLotNumber) $this->generateLotNumber();
    }

    /**
     * Format: NNN-[LOT_CODE_PREFIX]-[ALIAS]-[YY]
     * Contoh: 001-KD-DP-NS-KP-26
     */
    public function generateLotNumber(): void
    {
        $prefix = trim($this->lot_code_prefix) ?: 'KD-DP-NS';
        $alias  = $this->location ?: 'XX';
        $year2  = now()->format('y'); // 2-digit year

        $count = SeedLot::whereYear('created_at', now()->year)->count() + 1;

        $this->lot_number = sprintf('%03d-%s-%s-%s', $count, $prefix, $alias, $year2);
    }

    public function save(): void
    {
        $data = $this->validate();

        if ($this->seedLot && $this->seedLot->exists) {
            $this->seedLot->update($data);
            session()->flash('success', 'Lot benih berhasil diperbarui.');
        } else {
            SeedLot::create($data);
            session()->flash('success', 'Lot benih berhasil ditambahkan.');
        }

        $this->redirect(route('admin.seed-lots.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.seed-lot-form', [
            'seeds'    => Seed::orderBy('category')->orderBy('var_name')->get(),
            'statuses' => LotStatus::cases(),
        ]);
    }
}
