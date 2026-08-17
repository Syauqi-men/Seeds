@extends('admin.layout')
@section('title', 'Log Aktivitas')
@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Log Aktivitas</h1>
        <p class="page-subtitle">Audit trail semua perubahan data oleh admin</p>
    </div>
</div>

<div class="form-card mb-lg">
    <form method="GET" action="{{ route('admin.activity-log.index') }}" style="display:flex;gap:var(--space-md);flex-wrap:wrap;align-items:flex-end">
        <div class="form-group" style="margin:0;flex:1;min-width:150px">
            <label class="form-label">Modul</label>
            <select name="log_name" class="form-control">
                <option value="">Semua Modul</option>
                @foreach($logNames as $name)
                <option value="{{ $name }}" {{ request('log_name') === $name ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group" style="margin:0;flex:1;min-width:140px">
            <label class="form-label">Dari Tanggal</label>
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control">
        </div>
        <div class="form-group" style="margin:0;flex:1;min-width:140px">
            <label class="form-label">Sampai Tanggal</label>
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary" style="align-self:flex-end">Filter</button>
        <a href="{{ route('admin.activity-log.index') }}" class="btn btn-ghost" style="align-self:flex-end">Reset</a>
    </form>
</div>

<div class="data-table-wrapper">
    <table class="data-table">
        <thead>
            <tr>
                <th>Deskripsi</th><th>Modul</th><th>Admin</th><th>Perubahan</th><th>Waktu</th>
            </tr>
        </thead>
        <tbody>
            @forelse($activities as $activity)
            <tr>
                <td>{{ $activity->description }}</td>
                <td><span class="badge badge-raw">{{ $activity->log_name }}</span></td>
                <td>{{ $activity->causer->name ?? 'Sistem' }}</td>
                <td>
                    @if($activity->properties->has('attributes'))
                    <span class="text-small text-muted">{{ count($activity->properties['attributes'] ?? []) }} field diubah</span>
                    @else
                    <span class="text-small text-muted">-</span>
                    @endif
                </td>
                <td class="text-small text-muted">{{ $activity->created_at->translatedFormat('d M Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted" style="padding:var(--space-xl)">Belum ada log aktivitas.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="padding:var(--space-md) var(--space-lg)">{{ $activities->links() }}</div>
</div>
@endsection
