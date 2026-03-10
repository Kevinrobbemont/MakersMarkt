<x-layouts.app :title="'MakersMarkt - Notificaties'">
    <section>
        <h1>Notificaties</h1>
        <p class="muted">Overzicht van al je meldingen en updates.</p>

        @if (session('success'))
        <article class="alert alert-success">
            <p style="margin:0;">{{ session('success') }}</p>
        </article>
        @endif

        @if ($notifications->where('is_read', false)->count() > 0)
        <div style="margin-bottom:1rem;">
            <form method="POST" action="{{ route('notifications.markAllAsRead') }}" style="display:inline;">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-primary">Markeer alles als gelezen</button>
            </form>
        </div>
        @endif

        @if ($notifications->isEmpty())
        <article class="card">
            <p class="muted" style="margin:0;">Je hebt nog geen notificaties.</p>
        </article>
        @else
        <div class="stack">
            @foreach ($notifications as $notification)
            <article class="card {{ !$notification->is_read ? 'notification-unread' : '' }}" style="position:relative;">
                <div class="list-row">
                    <div style="flex:1; min-width:220px;">
                        @if (!$notification->is_read)
                        <span class="muted-chip" style="background:#1b7be8; color:#fff;">
                            NIEUW
                        </span>
                        @endif
                        
                        <p style="margin:0.4rem 0 0.5rem 0; font-weight:700; color:#12213b;">
                            {{ $notification->message }}
                        </p>
                        
                        @if ($notification->product)
                        <a href="{{ route('products.show', $notification->product->id) }}" class="subtle-link">
                            → Bekijk product: {{ $notification->product->name }}
                        </a>
                        @endif
                        
                        <p class="muted" style="margin:0.5rem 0 0 0; font-size:0.875rem;">
                            {{ $notification->created_at->diffForHumans() }}
                        </p>
                    </div>
                    
                    @if (!$notification->is_read)
                    <form method="POST" action="{{ route('notifications.markAsRead', $notification->id) }}" style="margin:0;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-ghost">Markeer als gelezen</button>
                    </form>
                    @endif
                </div>
            </article>
            @endforeach
        </div>
        @endif
    </section>
</x-layouts.app>
