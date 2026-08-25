<?php

namespace App\Livewire;

use App\Enums\VarClass;
use App\Models\Seed;
use App\Models\SeedCategory;
use Livewire\Component;
use Livewire\WithPagination;

class BenihList extends Component
{
    use WithPagination;

    public string $search         = '';
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
        }, 'category']);

        if ($this->search) {
            $query->where('var_name', 'like', '%' . $this->search . '%');
        }
        if ($this->filterCategory) {
            // Filter berdasarkan category_id (ID dari seed_categories)
            $query->where('category_id', $this->filterCategory);
        }
        if ($this->filterVarClass) {
            $query->where('var_class', $this->filterVarClass);
        }

        $seeds = $query->orderBy('var_name')->paginate(20);

        return view('livewire.benih-list', [
            'seeds'      => $seeds,
            'categories' => SeedCategory::orderBy('name')->get(),
            'varClasses' => VarClass::cases(),
        ]);
    }
}
