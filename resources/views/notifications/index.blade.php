@extends('layout')

@section('content')
<div class="container mt-5">
    <h2>Notifications 🔔</h2>

    @forelse(auth()->user()->notifications as $notification)
        <div class="card mb-3 shadow-sm 
            @if(is_null($notification->read_at)) border-primary @endif">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <i class="bi bi-bell-fill text-primary me-2"></i>

                    {{-- message --}}
                    <strong>
                        {{ $notification->data['message'] ?? 'New Notification' }}
                    </strong>

                    <br>

                    📅 {{ $notification->data['date'] ?? '-' }} <br>
                    ⏰ {{ $notification->data['time'] ?? '-' }}
                </div>

                <div class="d-flex gap-2">

                    {{-- bouton mark as read --}}
                    @if(is_null($notification->read_at))
                        <a href="{{ route('notifications.markAsRead', $notification->id) }}" 
                           class="btn btn-success btn-sm">
                            ✔ Lu
                        </a>
                    @endif

                    {{-- delete (optionnel 🔥) --}}
                    <form action="{{ route('notifications.delete', $notification->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">🗑</button>
                    </form>

                </div>

            </div>
        </div>

    @empty
        <p>Aucune notification disponible 😢</p>
    @endforelse

</div>
@endsection
