@extends('admin.layout')
@section('title', 'Tambah Proses Produksi')
@section('content')
<div class="page-header">
    <div><h1 class="page-title">Tambah Proses Produksi</h1></div>
    <a href="{{ route('admin.production-processes.index') }}" class="btn btn-ghost">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali
    </a>
</div>

@if($errors->any())
<div class="alert alert-error" style="margin-bottom:var(--space-md)">
    <ul style="margin:0;padding-left:1.5rem">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('admin.production-processes.store') }}" id="ppForm">
    @csrf

    {{-- HEADER:diisisekali --}}
    <div class="form-card" style="margin-bottom:var(--space-md)">
        <div style="font-weight:600;font-size:0.85rem;color:var(--color-text-muted);text-transform:uppercase;letter-spacing:.05em;margin-bottom:var(--space-md)">
            Informasi Proses
        </div>
        <div style="display:grid;grid-template-columns:2fr 1fr;gap:var(--space-md);margin-bottom:var(--space-md)">
            <div class="form-group" style="margin-bottom:0">
                <label class="form-label required">Lot Benih</label>
                <select name="seed_lot_id" id="seed_lot_id" class="form-control @error('seed_lot_id') is-invalid @enderror">
                    <option value="">-- Pilih Lot --</option>
                    @foreach($lots as $lot)
                    <option value="{{ $lot->id }}" {{ old('seed_lot_id') == $lot->id ? 'selected' : '' }}>
                        {{ $lot->lot_number }} &mdash; {{ $lot->seed->var_name }}
                    </option>
                    @endforeach
                </select>
                @error('seed_lot_id') <span class="form-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group" style="margin-bottom:0">
                <label class="form-label required">Jenis Proses</label>
                <select name="process_type" id="process_type" class="form-control @error('process_type') is-invalid @enderror">
                    @foreach($types as $type)
                    <option value="{{ $type->value }}" {{ old('process_type') === $type->value ? 'selected' : '' }}>
                        {{ $type->label() }}
                    </option>
                    @endforeach
                </select>
                @error('process_type') <span class="form-error">{{ $message }}</span> @enderror
            </div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 2fr;gap:var(--space-md)">
            <div class="form-group" style="margin-bottom:0">
                <label class="form-label">Tanggal Proses</label>
                <input type="date" name="processed_at" class="form-control" value="{{ old('processed_at') }}">
            </div>
            <div class="form-group" style="margin-bottom:0">
                <label class="form-label">Catatan <span style="font-weight:400;color:var(--color-text-muted)">(opsional)</span></label>
                <input type="text" name="notes" class="form-control" placeholder="Catatan proses (opsional)" value="{{ old('notes') }}">
            </div>
        </div>
    </div>

    {{-- TABEL PEKERJA: baris yang di-loop --}}
    <div class="form-card" style="margin-bottom:var(--space-md)">
        <div style="font-weight:600;font-size:0.85rem;color:var(--color-text-muted);text-transform:uppercase;letter-spacing:.05em;margin-bottom:var(--space-md)">
            Data Pekerja &amp; Hasil Proses
        </div>

        <div style="overflow-x:auto">
            <table style="width:100%;border-collapse:collapse" id="worker-table">
                <thead>
                    <tr style="border-bottom:1px solid var(--color-border)">
                        <th style="text-align:left;padding:var(--space-sm) var(--space-md);font-size:0.82rem;font-weight:600;color:var(--color-text-muted);white-space:nowrap;width:25%">Pekerja</th>
                        <th style="text-align:left;padding:var(--space-sm) var(--space-md);font-size:0.82rem;font-weight:600;color:var(--color-text-muted);white-space:nowrap">Input (kg)</th>
                        <th style="text-align:left;padding:var(--space-sm) var(--space-md);font-size:0.82rem;font-weight:600;color:var(--color-text-muted);white-space:nowrap">Output (kg)</th>
                        <th style="text-align:left;padding:var(--space-sm) var(--space-md);font-size:0.82rem;font-weight:600;color:var(--color-text-muted);white-space:nowrap">Sortir (kg)</th>
                        <th style="text-align:left;padding:var(--space-sm) var(--space-md);font-size:0.82rem;font-weight:600;color:var(--color-text-muted);white-space:nowrap">Limbah (kg)</th>
                        <th style="width:40px"></th>
                    </tr>
                </thead>
                <tbody id="worker-tbody">
                    {{-- Baris pertama --}}
                    <tr class="worker-row" data-idx="0">
                        <td style="padding:var(--space-sm) var(--space-md);vertical-align:top">
                            <select name="rows[0][worker_id]" class="form-control" style="min-width:160px">
                                <option value="">-- Tanpa Pekerja --</option>
                                @foreach($workers as $w)
                                <option value="{{ $w->id }}">{{ $w->name }}{{ $w->code ? ' ('.$w->code.')' : '' }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td style="padding:var(--space-sm) var(--space-md);vertical-align:top">
                            <input type="number" name="rows[0][input_quantity]" step="0.01" min="0.01" class="form-control field-input" placeholder="0.00" style="min-width:90px">
                            <span class="form-error" style="display:none"></span>
                        </td>
                        <td style="padding:var(--space-sm) var(--space-md);vertical-align:top">
                            <input type="number" name="rows[0][output_quantity]" step="0.01" min="0" class="form-control field-output" placeholder="0.00" style="min-width:90px">
                            <span class="form-error" style="display:none"></span>
                        </td>
                        <td style="padding:var(--space-sm) var(--space-md);vertical-align:top">
                            <input type="number" name="rows[0][sortir_quantity]" step="0.01" min="0" value="0" class="form-control field-sortir" placeholder="0.00" style="min-width:90px">
                        </td>
                        <td style="padding:var(--space-sm) var(--space-md);vertical-align:top">
                            <input type="number" name="rows[0][waste_quantity]" step="0.01" min="0" value="0" class="form-control field-waste" placeholder="0.00" style="min-width:90px">
                        </td>
                        <td style="padding:var(--space-sm) var(--space-md);vertical-align:middle;text-align:center">
                            <button type="button" class="btn btn-danger btn-sm btn-remove-row" style="display:none" title="Hapus baris">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Tombol Tambah Pekerja --}}
        <div style="margin-top:var(--space-md);padding-top:var(--space-md);border-top:1px dashed var(--color-border)">
            <button type="button" id="btn-add-row" class="btn btn-ghost" style="display:flex;align-items:center;gap:var(--space-sm)">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Pekerja Lain
            </button>
        </div>
    </div>

    <div style="display:flex;justify-content:flex-end;gap:var(--space-sm)">
        <a href="{{ route('admin.production-processes.index') }}" class="btn btn-ghost">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan Semua</button>
    </div>
</form>

<script>
(function () {
    const workerOptions = `{!! $workers->map(fn($w) => '<option value="'.$w->id.'">'.$w->name.($w->code ? ' ('.$w->code.')' : '').'</option>')->implode('') !!}`;

    let rowCount = 1;

    // Tambah baris 
    document.getElementById('btn-add-row').addEventListener('click', function () {
        const idx = rowCount++;
        const tbody = document.getElementById('worker-tbody');
        const tr = document.createElement('tr');
        tr.className = 'worker-row';
        tr.dataset.idx = idx;
        tr.innerHTML = `
            <td style="padding:var(--space-sm) var(--space-md);vertical-align:top">
                <select name="rows[${idx}][worker_id]" class="form-control" style="min-width:160px">
                    <option value="">-- Tanpa Pekerja --</option>${workerOptions}
                </select>
            </td>
            <td style="padding:var(--space-sm) var(--space-md);vertical-align:top">
                <input type="number" name="rows[${idx}][input_quantity]" step="0.01" min="0.01" class="form-control field-input" placeholder="0.00" style="min-width:90px">
                <span class="form-error" style="display:none"></span>
            </td>
            <td style="padding:var(--space-sm) var(--space-md);vertical-align:top">
                <input type="number" name="rows[${idx}][output_quantity]" step="0.01" min="0" class="form-control field-output" placeholder="0.00" style="min-width:90px">
                <span class="form-error" style="display:none"></span>
            </td>
            <td style="padding:var(--space-sm) var(--space-md);vertical-align:top">
                <input type="number" name="rows[${idx}][sortir_quantity]" step="0.01" min="0" value="0" class="form-control field-sortir" placeholder="0.00" style="min-width:90px">
            </td>
            <td style="padding:var(--space-sm) var(--space-md);vertical-align:top">
                <input type="number" name="rows[${idx}][waste_quantity]" step="0.01" min="0" value="0" class="form-control field-waste" placeholder="0.00" style="min-width:90px">
            </td>
            <td style="padding:var(--space-sm) var(--space-md);vertical-align:middle;text-align:center">
                <button type="button" class="btn btn-danger btn-sm btn-remove-row" title="Hapus baris">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </td>
        `;
        tr.querySelector('.btn-remove-row').addEventListener('click', function () {
            tr.remove();
            updateRemoveButtons();
        });
        tbody.appendChild(tr);
        updateRemoveButtons();
    });

    // Hapus baris pertama 
    document.getElementById('worker-tbody').addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-remove-row');
        if (!btn) return;
        const row = btn.closest('.worker-row');
        if (row) {
            row.remove();
            updateRemoveButtons();
        }
    });

    function updateRemoveButtons() {
        const rows = document.querySelectorAll('.worker-row');
        rows.forEach(r => {
            const btn = r.querySelector('.btn-remove-row');
            if (btn) btn.style.display = rows.length > 1 ? '' : 'none';
        });
    }

    // Validasi client-side sebelum submit 
    document.getElementById('ppForm').addEventListener('submit', function (e) {
        let valid = true;

        // Bersihkan error 
        document.querySelectorAll('#worker-tbody .form-error').forEach(el => {
            el.textContent = '';
            el.style.display = 'none';
        });
        document.querySelectorAll('#worker-tbody .form-control').forEach(el => el.classList.remove('is-invalid'));

        // Validasi header
        const lotSel = document.getElementById('seed_lot_id');
        if (!lotSel.value) {
            lotSel.classList.add('is-invalid');
            valid = false;
        }

        // Validasi tiap baris pekerja
        document.querySelectorAll('.worker-row').forEach((row, i) => {
            const inputEl  = row.querySelector('.field-input');
            const outputEl = row.querySelector('.field-output');
            const sortirEl = row.querySelector('.field-sortir');
            const wasteEl  = row.querySelector('.field-waste');

            if (!inputEl.value || parseFloat(inputEl.value) <= 0) {
                showError(inputEl, 'Input wajib diisi (> 0).');
                valid = false;
            }

            if (outputEl.value === '') {
                showError(outputEl, 'Output wajib diisi.');
                valid = false;
            }

            if (inputEl.value && outputEl.value !== '') {
                const inp    = parseFloat(inputEl.value) || 0;
                const out    = parseFloat(outputEl.value) || 0;
                const sortir = parseFloat(sortirEl?.value) || 0;
                const waste  = parseFloat(wasteEl?.value) || 0;
                if (Math.abs((out + sortir + waste) - inp) > 0.01) {
                    showError(outputEl, 'Output + Sortir + Limbah harus sama dengan Input.');
                    valid = false;
                }
            }
        });

        if (!valid) {
            e.preventDefault();
            const firstErr = document.querySelector('.is-invalid');
            if (firstErr) firstErr.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });

    function showError(field, message) {
        field.classList.add('is-invalid');
        let errEl = field.parentElement.querySelector('.form-error');
        if (!errEl) {
            errEl = document.createElement('span');
            errEl.className = 'form-error';
            field.parentElement.appendChild(errEl);
        }
        errEl.textContent = message;
        errEl.style.display = '';
    }
})();
</script>
@endsection
