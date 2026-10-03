<?php

namespace App\Livewire;

use App\Enums\LotStatus;
use App\Models\SeedCategory;
use App\Models\SeedLot;
use Livewire\Component;
use Livewire\WithPagination;

class LotBenihList extends Component
{
    use WithPagination;

    public string $search         = '';
    public string $filterStatus   = '';
    public string $filterCategory = '';

    protected $queryString = ['search', 'filterStatus', 'filterCategory'];

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingFilterStatus(): void { $this->resetPage(); }
    public function updatingFilterCategory(): void { $this->resetPage(); }

    public function render()
    {
        $query = SeedLot::with('seed.category')
            ->join('seeds', 'seed_lots.seed_id', '=', 'seeds.id')
            ->select('seed_lots.*');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('seed_lots.lot_number', 'like', '%' . $this->search . '%')
                  ->orWhere('seeds.var_name', 'like', '%' . $this->search . '%');
            });
        }
        if ($this->filterStatus) {
            $query->where('seed_lots.status', $this->filterStatus);
        }
        if ($this->filterCategory) {
            // Filter by category_id on seeds table
            $query->where('seeds.category_id', $this->filterCategory);
        }

        $lots = $query->orderBy('seed_lots.updated_at', 'desc')->paginate(20);

        return view('livewire.lot-benih-list', [
            'lots'       => $lots,
            'statuses'   => LotStatus::cases(),
            'categories' => SeedCategory::orderBy('name')->get(),
        ]);
    }
}
