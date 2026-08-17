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

@if($errors->has('rows'))
<div class="alert alert-error" style="margin-bottom:var(--space-md)">{{ $errors->first('rows') }}</div>
@endif

<form method="POST" action="{{ route('admin.production-processes.store') }}" id="ppForm">
    @csrf
    <div id="pp-rows">
        {{-- Baris pertama (template) --}}
        <div class="form-card pp-row" style="margin-bottom:var(--space-md);position:relative">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:var(--space-md)">
                <span style="font-weight:600;font-size:0.9rem;color:var(--color-text-muted)">Baris #1</span>
                <button type="button" class="btn btn-danger btn-sm btn-remove-row" style="display:none" title="Hapus baris ini">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Hapus Baris
                </button>
            </div>
            <div style="display:grid;grid-template-columns:2fr 1fr 1fr;gap:var(--space-md)">
                <div class="form-group">
                    <label class="form-label required">Lot Benih</label>
                    <select name="rows[0][seed_lot_id]" class="form-control">
                        <option value="">-- Pilih Lot --</option>
                        @foreach($lots as $lot)
                        <option value="{{ $lot->id }}">{{ $lot->lot_number }} &mdash; {{ $lot->seed->var_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label required">Jenis Proses</label>
                    <select name="rows[0][process_type]" class="form-control">
                        @foreach($types as $type)
                        <option value="{{ $type->value }}">{{ $type->label() }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Pekerja</label>
                    <select name="rows[0][worker_id]" class="form-control">
                        <option value="">-- Pilih Pekerja --</option>
                        @foreach($workers as $w)
                        <option value="{{ $w->id }}">{{ $w->name }}{{ $w->code ? ' ('.$w->code.')' : '' }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:var(--space-md)">
                <div class="form-group">
                    <label class="form-label required">Input (kg)</label>
                    <input type="number" name="rows[0][input_quantity]" step="0.01" min="0.01" class="form-control" placeholder="0.00">
                </div>
                <div class="form-group">
                    <label class="form-label required">Output (kg)</label>
                    <input type="number" name="rows[0][output_quantity]" step="0.01" min="0" class="form-control" placeholder="0.00">
                </div>
                <div class="form-group">
                    <label class="form-label">Susut (kg)</label>
                    <input type="number" name="rows[0][shrinkage_quantity]" step="0.01" min="0" value="0" class="form-control" placeholder="0.00">
                </div>
                <div class="form-group">
                    <label class="form-label">Limbah (kg)</label>
                    <input type="number" name="rows[0][waste_quantity]" step="0.01" min="0" value="0" class="form-control" placeholder="0.00">
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 2fr;gap:var(--space-md)">
                <div class="form-group">
                    <label class="form-label">Tanggal Proses</label>
                    <input type="date" name="rows[0][processed_at]" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label">Catatan</label>
                    <input type="text" name="rows[0][notes]" class="form-control" placeholder="Catatan proses (opsional)">
                </div>
            </div>
        </div>
    </div>

    {{-- Tombol Tambah Baris --}}
    <div style="margin-bottom:var(--space-md)">
        <button type="button" id="btn-add-row" class="btn btn-ghost" style="width:100%;border:2px dashed var(--color-border);display:flex;align-items:center;justify-content:center;gap:var(--space-sm)">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Baris Proses Lain
        </button>
    </div>

    <div style="display:flex;justify-content:flex-end;gap:var(--space-sm)">
        <a href="{{ route('admin.production-processes.index') }}" class="btn btn-ghost">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan Semua</button>
    </div>
</form>

<script>
(function () {
    const lotsOptions = `{!! $lots->map(fn($l) => '<option value="'.$l->id.'">'.$l->lot_number.' &mdash; '.$l->seed->var_name.'</option>')->implode('') !!}`;
    const typeOptions = `{!! collect($types)->map(fn($t) => '<option value="'.$t->value.'">'.$t->label().'</option>')->implode('') !!}`;
    const workerOptions = `{!! $workers->map(fn($w) => '<option value="'.$w->id.'">'.$w->name.($w->code ? ' ('.$w->code.')' : '').'</option>')->implode('') !!}`;

    let rowCount = 1;

    document.getElementById('btn-add-row').addEventListener('click', function () {
        const idx = rowCount++;
        const row = document.createElement('div');
        row.className = 'form-card pp-row';
        row.style.cssText = 'margin-bottom:var(--space-md);position:relative';
        row.innerHTML = `
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:var(--space-md)">
                <span style="font-weight:600;font-size:0.9rem;color:var(--color-text-muted)">Baris #${idx + 1}</span>
                <button type="button" class="btn btn-danger btn-sm btn-remove-row" title="Hapus baris ini">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Hapus Baris
                </button>
            </div>
            <div style="display:grid;grid-template-columns:2fr 1fr 1fr;gap:var(--space-md)">
                <div class="form-group">
                    <label class="form-label required">Lot Benih</label>
                    <select name="rows[${idx}][seed_lot_id]" class="form-control">
                        <option value="">-- Pilih Lot --</option>${lotsOptions}
                    </select>
                    <span class="form-error" style="display:none"></span>
                </div>
                <div class="form-group">
                    <label class="form-label required">Jenis Proses</label>
                    <select name="rows[${idx}][process_type]" class="form-control">
                        ${typeOptions}
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Pekerja</label>
                    <select name="rows[${idx}][worker_id]" class="form-control">
                        <option value="">-- Pilih Pekerja --</option>${workerOptions}
                    </select>
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:var(--space-md)">
                <div class="form-group">
                    <label class="form-label required">Input (kg)</label>
                    <input type="number" name="rows[${idx}][input_quantity]" step="0.01" min="0.01" class="form-control" placeholder="0.00">
                    <span class="form-error" style="display:none"></span>
                </div>
                <div class="form-group">
                    <label class="form-label required">Output (kg)</label>
                    <input type="number" name="rows[${idx}][output_quantity]" step="0.01" min="0" class="form-control" placeholder="0.00">
                    <span class="form-error" style="display:none"></span>
                </div>
                <div class="form-group">
                    <label class="form-label">Susut (kg)</label>
                    <input type="number" name="rows[${idx}][shrinkage_quantity]" step="0.01" min="0" value="0" class="form-control" placeholder="0.00">
                </div>
                <div class="form-group">
                    <label class="form-label">Limbah (kg)</label>
                    <input type="number" name="rows[${idx}][waste_quantity]" step="0.01" min="0" value="0" class="form-control" placeholder="0.00">
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 2fr;gap:var(--space-md)">
                <div class="form-group">
                    <label class="form-label">Tanggal Proses</label>
                    <input type="date" name="rows[${idx}][processed_at]" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label">Catatan</label>
                    <input type="text" name="rows[${idx}][notes]" class="form-control" placeholder="Catatan proses (opsional)">
                </div>
            </div>
        `;
        row.querySelector('.btn-remove-row').addEventListener('click', function () {
            row.remove();
            updateRowLabels();
        });
        document.getElementById('pp-rows').appendChild(row);
        // Tampilkan tombol hapus di baris pertama jika ada lebih dari 1 baris
        updateRowLabels();
    });

    function updateRowLabels() {
        const rows = document.querySelectorAll('.pp-row');
        rows.forEach((r, i) => {
            const label = r.querySelector('span');
            if (label) label.textContent = `Baris #${i + 1}`;
            const removeBtn = r.querySelector('.btn-remove-row');
            if (removeBtn) removeBtn.style.display = rows.length > 1 ? '' : 'none';
        });
    }

    // ─── Client-side validation sebelum submit ───────────────────────────────
    document.getElementById('ppForm').addEventListener('submit', function (e) {
        let valid = true;

        // Bersihkan semua error lama
        document.querySelectorAll('#pp-rows .form-error').forEach(el => {
            el.textContent = '';
            el.style.display = 'none';
        });
        document.querySelectorAll('#pp-rows .form-control').forEach(el => el.classList.remove('is-invalid'));

        const rows = document.querySelectorAll('.pp-row');
        rows.forEach((row, i) => {
            const rowNum = i + 1;

            // Lot Benih
            const lotSel = row.querySelector('select[name*="[seed_lot_id]"]');
            if (lotSel && !lotSel.value) {
                showError(lotSel, 'Lot benih wajib dipilih.');
                valid = false;
            }

            // Input (kg)
            const inputQty = row.querySelector('input[name*="[input_quantity]"]');
            if (inputQty && (!inputQty.value || parseFloat(inputQty.value) <= 0)) {
                showError(inputQty, 'Jumlah input (kg) wajib diisi dan harus lebih dari 0.');
                valid = false;
            }

            // Output (kg)
            const outputQty = row.querySelector('input[name*="[output_quantity]"]');
            if (outputQty && outputQty.value === '') {
                showError(outputQty, 'Jumlah output (kg) wajib diisi.');
                valid = false;
            }

            // Cek toleransi output
            if (inputQty && outputQty && inputQty.value && outputQty.value) {
                const inp = parseFloat(inputQty.value);
                const out = parseFloat(outputQty.value);
                if (out > inp * 1.05) {
                    showError(outputQty, `Baris #${rowNum}: Output melebihi input lebih dari toleransi 5%.`);
                    valid = false;
                }
            }
        });

        if (!valid) {
            e.preventDefault();
            // Scroll ke error pertama
            const firstError = document.querySelector('#pp-rows .is-invalid');
            if (firstError) firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
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
