<x-layouts.app :title="'Accountgoedkeuring - MakersMarkt'">
    <section>
        <h1>Niet-geverifieerde Accounts</h1>
        <p class="muted">Controleer en keur nieuwe accounts goed zodat gebruikers volledige toegang krijgen.</p>

        @if (session('success'))
            <div style="margin: 1rem 0; padding: 1rem; background-color: #d4edda; color: #155724; border-radius: 4px; border-left: 4px solid #28a745;">
                {{ session('success') }}
            </div>
        @endif

        @if (session('warning'))
            <div style="margin: 1rem 0; padding: 1rem; background-color: #fff3cd; color: #856404; border-radius: 4px; border-left: 4px solid #ffc107;">
                {{ session('warning') }}
            </div>
        @endif

        @if ($unapprovedUsers->isEmpty())
            <article class="panel" style="text-align: center; padding: 2rem;">
                <p style="color: #666; font-size: 1.1rem;">✓ Alle accounts zijn goedgekeurd!</p>
                <p class="muted">Er zijn momenteel geen wachtende accounts.</p>
            </article>
        @else
            <div class="panel" style="overflow-x: auto; margin-top: 1.5rem;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 2px solid #e0e0e0; background-color: #f5f5f5;">
                            <th style="padding: 1rem; text-align: left;">Gebruiker</th>
                            <th style="padding: 1rem; text-align: left;">E-mailadres</th>
                            <th style="padding: 1rem; text-align: left;">Accounttype</th>
                            <th style="padding: 1rem; text-align: left;">Aangemaakt</th>
                            <th style="padding: 1rem; text-align: center;">Acties</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($unapprovedUsers as $user)
                            <tr style="border-bottom: 1px solid #e0e0e0;">
                                <td style="padding: 1rem;">
                                    <strong>{{ $user->name }}</strong><br>
                                    <span class="muted">@{{ $user->username }}</span>
                                </td>
                                <td style="padding: 1rem;">{{ $user->email }}</td>
                                <td style="padding: 1rem;">
                                    <span style="display: inline-block; padding: 0.25rem 0.75rem; background-color: #e8f4f8; color: #0c5460; border-radius: 20px; font-size: 0.9rem;">
                                        {{ $user->role?->name ?? 'Geen rol' }}
                                    </span>
                                </td>
                                <td style="padding: 1rem;">
                                    <span class="muted">{{ $user->created_at->format('j M Y, H:i') }}</span>
                                </td>
                                <td style="padding: 1rem; text-align: center;">
                                    <form method="POST" style="display: inline;">
                                        @csrf
                                        <button 
                                            formaction="{{ route('admin.accounts.approve', $user) }}"
                                            type="submit" 
                                            style="padding: 0.5rem 1rem; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 0.9rem; margin-right: 0.5rem;"
                                            onclick="return confirm('Weet je zeker dat je dit account wilt goedkeuren?');"
                                        >
                                            ✓ Goedkeuren
                                        </button>
                                        <button 
                                            formaction="{{ route('admin.accounts.reject', $user) }}"
                                            type="submit" 
                                            style="padding: 0.5rem 1rem; background-color: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 0.9rem;"
                                            onclick="return confirm('Weet je zeker dat je dit account permanent wilt verwijderen? Dit kan niet ongedaan gemaakt worden.');"
                                        >
                                            ✗ Verwijderen
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="padding: 2rem; text-align: center; color: #666;">
                                    Geen niet-geverifieerde accounts gevonden.
                                </td>
                            </tr>
                        @endempty
                    </tbody>
                </table>
            </div>

            @if ($unapprovedUsers->hasPages())
                <div style="margin-top: 2rem;">
                    {{ $unapprovedUsers->links() }}
                </div>
            @endif
        @endif
    </section>
</x-layouts.app>
