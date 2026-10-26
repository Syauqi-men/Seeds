<?php

namespace App\Livewire\Admin;

use App\Models\Seed;
use App\Models\SeedCategory;
use Livewire\Component;

class SeedForm extends Component
{
    public ?Seed $seed = null;
    public string $var_name    = '';
    public string $var_class   = '';
    public string $category_id = '';   
    public string $description = '';

    protected function rules(): array
    {
        $uniqueRule = 'unique:seeds,var_name';
        if ($this->seed) {
            $uniqueRule .= ',' . $this->seed->id . ',id,category_id,' . $this->category_id;
        }

        return [
            'var_name'    => ['required', 'string', 'max:255'],
            'var_class'   => ['required', 'in:BS,FS,SS'],
            'category_id' => ['required', 'exists:seed_categories,id'],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }

    protected function messages(): array
    {
        return [
            'var_name.required'    => 'Nama varietas wajib diisi.',
            'var_name.max'         => 'Nama varietas maksimal 255 karakter.',
            'var_class.required'   => 'Kelas benih wajib dipilih.',
            'var_class.in'         => 'Kelas benih tidak valid.',
            'category_id.required' => 'Kategori benih wajib dipilih.',
            'category_id.exists'   => 'Kategori yang dipilih tidak ditemukan.',
            'description.max'      => 'Deskripsi maksimal 1000 karakter.',
        ];
    }

    public function mount(?Seed $seed = null): void
    {
        if ($seed && $seed->exists) {
            $this->seed        = $seed;
            $this->var_name    = $seed->var_name;
            $this->var_class   = $seed->var_class->value;
            $this->category_id = (string) $seed->category_id;
            $this->description = $seed->description ?? '';
        }
    }

    public function save(): void
    {
        $data = $this->validate();

        if ($this->seed && $this->seed->exists) {
            $this->seed->update($data);
            session()->flash('success', 'Varietas benih berhasil diperbarui.');
        } else {
            Seed::create($data);
            session()->flash('success', 'Varietas benih berhasil ditambahkan.');
        }

        $this->redirect(route('admin.seeds.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.seed-form', [
            'varClasses' => \App\Enums\VarClass::cases(),
            'categories' => SeedCategory::orderBy('name')->get(),
        ]);
    }
}
