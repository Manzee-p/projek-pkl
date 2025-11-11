@extends('layouts.admin.master')
@section('content')

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', () => {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil! 🎉',
            text: '{{ session('success') }}',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false
        });
    });
</script>
@endif

<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title mb-0">Pusat Notifikasi</h4>
                        @if($notifications->count() > 0)
                            <button id="mark-all-read-btn" class="btn btn-primary btn-sm">
                                <i class="mdi mdi-check-all"></i> Tandai Semua Dibaca
                            </button>
                        @endif
                    </div>

                    <!-- Stats -->
                    <div class="row mb-4 g-3">
                        <div class="col-md-4">
                            <div class="alert alert-primary d-flex justify-content-between align-items-center mb-0">
                                <span><i class="mdi mdi-bell-badge"></i> Total</span>
                                <strong>{{ $notifications->total() }}</strong>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="alert alert-warning d-flex justify-content-between align-items-center mb-0">
                                <span><i class="mdi mdi-email-alert"></i> Belum Dibaca</span>
                                <strong>{{ $notifications->where('status_baca', false)->count() }}</strong>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="alert alert-success d-flex justify-content-between align-items-center mb-0">
                                <span><i class="mdi mdi-check-circle"></i> Sudah Dibaca</span>
                                <strong>{{ $notifications->where('status_baca', true)->count() }}</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive pt-2" style="overflow-x: auto;">
                        @if($notifications->count() > 0)
                        <table class="table table-bordered align-middle text-nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th width="50" class="text-center">#</th>
                                    <th>Pesan</th>
                                    <th width="180">Waktu</th>
                                    <th width="100" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($notifications as $index => $notification)
                                <tr class="{{ !$notification->status_baca ? 'table-info' : '' }} notification-row"
                                    data-notif-id="{{ $notification->notif_id }}"
                                    data-tiket-id="{{ $notification->tiket_id }}"
                                    style="cursor:pointer;">
                                    <td class="text-center align-middle">
                                        @if(!$notification->status_baca)
                                            <i class="mdi mdi-bell-ring text-primary"></i>
                                        @else
                                            <i class="mdi mdi-check text-success"></i>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $notification->pesan }}</strong><br>
                                        @if($notification->tiket)
                                            <small class="text-muted">
                                                <i class="mdi mdi-ticket-outline"></i> Tiket #{{ $notification->tiket->kode_tiket }}
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <i class="mdi mdi-clock-outline"></i>
                                            {{ $notification->waktu_kirim->diffForHumans() }}
                                        </small><br>
                                        <small class="text-muted">{{ $notification->waktu_kirim->format('d/m/Y H:i') }}</small>
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                    id="dropdownMenu{{ $notification->notif_id }}" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                Aksi
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu{{ $notification->notif_id }}">
                                                <li>
                                                    <a class="dropdown-item" href="#"
                                                       onclick="event.preventDefault(); event.stopPropagation();">
                                                        <i class="mdi mdi-eye-outline me-2"></i> Lihat Detail
                                                    </a>
                                                </li>
                                                @if(!$notification->status_baca)
                                                <li>
                                                    <a class="dropdown-item mark-read-single" href="#" 
                                                       data-notif-id="{{ $notification->notif_id }}"
                                                       onclick="event.preventDefault(); event.stopPropagation();">
                                                        <i class="mdi mdi-check me-2"></i> Tandai Dibaca
                                                    </a>
                                                </li>
                                                @endif
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('notifications.destroy', $notification->notif_id) }}" 
                                                          method="POST" 
                                                          class="d-inline"
                                                          onsubmit="event.stopPropagation(); return confirm('Hapus notifikasi ini?')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="mdi mdi-delete-outline me-2"></i> Hapus
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-3">
                            {{ $notifications->links() }}
                        </div>
                        @else
                            <div class="text-center py-5">
                                <i class="mdi mdi-bell-off-outline" style="font-size: 70px; color:#ccc;"></i>
                                <p class="text-muted mt-3 mb-0">Belum ada notifikasi</p>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function() {
    $('.notification-row').click(function(e) {
        if ($(e.target).closest('.dropdown, button, form').length) return;
        const notifId = $(this).data('notif-id');
        const tiketId = $(this).data('tiket-id');
        if (tiketId) {
            $.post(`/notifications/${notifId}/read`, {_token: '{{ csrf_token() }}'})
            .done(() => window.location.href = `/admin/tiket/${tiketId}`);
        }
    });

    $('#mark-all-read-btn').click(function() {
        $(this).prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin"></i> Memproses...');
        $.post('{{ route("notifications.readAll") }}', {_token: '{{ csrf_token() }}'})
        .done(() => location.reload());
    });

    $('.mark-read-single').click(function(e) {
        e.preventDefault();
        const notifId = $(this).data('notif-id');
        $.post(`/notifications/${notifId}/read`, {_token: '{{ csrf_token() }}'})
        .done(() => location.reload());
    });
});
</script>

@endsection
