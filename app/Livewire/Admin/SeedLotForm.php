<?php

namespace App\Livewire\Admin;

use App\Enums\LotStatus;
use App\Enums\SeedCategory;
use App\Models\Seed;
use App\Models\SeedLot;
use Livewire\Component;

class SeedLotForm extends Component
{
    public ?SeedLot $seedLot = null;
    public string $seed_id = '';
    public string $lot_number = '';
    public ?string $harvest_date = null;
    public ?string $origin_weight = null;
    public ?string $origin_moisture = null;
    public ?string $arrival_weight = null;
    public ?string $arrival_moisture = null;
    public string $status = 'Raw';
    public bool $autoLotNumber = true;

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
            'status'           => 'required|in:Raw,Processing,Quarantine,Ready,Depleted',
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
            $this->status           = $seedLot->status->value;
            $this->autoLotNumber    = false;
        } else {
            $this->generateLotNumber();
        }
    }

    public function updatedSeedId(): void
    {
        if ($this->autoLotNumber) {
            $this->generateLotNumber();
        }
    }

    public function generateLotNumber(): void
    {
        if (!$this->seed_id) {
            $this->lot_number = '';
            return;
        }
        $seed = Seed::find($this->seed_id);
        if (!$seed) return;

        $abbr  = $seed->category->abbr();
        $year  = now()->format('Y');
        $count = SeedLot::whereHas('seed', fn($q) => $q->where('category', $seed->category->value))
            ->whereYear('created_at', $year)
            ->count() + 1;

        $this->lot_number = sprintf('LOT-%s-%s-%03d', $abbr, $year, $count);
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
