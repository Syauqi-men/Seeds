<?php

namespace App\Livewire;

use App\Enums\SeedCategory;
use App\Enums\VarClass;
use App\Models\Seed;
use Livewire\Component;
use Livewire\WithPagination;

class BenihList extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterCategory = '';
    public string $filterVarClass = '';

    protected $queryString = ['search', 'filterCategory', 'filterVarClass'];

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingFilterCategory(): void { $this->resetPage(); }
    public function updatingFilterVarClass(): void { $this->resetPage(); }

    public function render()
    {
        $query = Seed::with(['seedLots' => function ($q) {
            $q->orderBy('updated_at', 'desc');
        }]);

        if ($this->search) {
            $query->where('var_name', 'ilike', '%' . $this->search . '%');
        }
        if ($this->filterCategory) {
            $query->where('category', $this->filterCategory);
        }
        if ($this->filterVarClass) {
            $query->where('var_class', $this->filterVarClass);
        }

        $seeds = $query->orderBy('category')->orderBy('var_name')->paginate(20);

        return view('livewire.benih-list', [
            'seeds'      => $seeds,
            'categories' => SeedCategory::cases(),
            'varClasses' => VarClass::cases(),
        ]);
    }
}
