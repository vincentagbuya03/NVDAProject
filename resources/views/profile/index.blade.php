@extends('format.nav')

@section('title', 'Profiles')

@section('content')
    @php
        $totalProfiles = $profiles->total();
        $withBioCount = $profiles->getCollection()->filter(fn ($profile) => !empty($profile->bio))->count();
        $registeredUsers = $userCount ?? 0;
    @endphp

    <div class="hero" style="padding: 2rem 0; text-align: left;">
        <div style="display: flex; align-items: center; gap: 1.25rem; margin-bottom: 1rem;">
            <div style="width: 64px; height: 64px; background: var(--primary); color: white; border-radius: 1rem; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; box-shadow: var(--shadow-lg);">
                PR
            </div>
            <div>
                <h1 style="margin-bottom: 0.35rem;">Profile <span class="text-gradient">Directory</span></h1>
                <p style="margin-bottom: 0;">List of user profiles from your database.</p>
            </div>
        </div>

        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap; margin-bottom: 2.25rem;">
            <span class="badge badge-primary">Total: {{ $totalProfiles }}</span>
            <span class="badge" style="background: #f0fdf4; color: #16a34a;">With Bio: {{ $withBioCount }}</span>
            <span class="badge" style="background: #eef2ff; color: #4f46e5;">Users: {{ $registeredUsers }}</span>
        </div>
    </div>

    <div class="card" style="padding: 2rem; margin-bottom: 4rem;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 2px solid var(--border-color); text-align: left;">
                        <th style="padding: 1rem; font-size: 0.75rem; text-transform: uppercase; color: var(--text-muted);">User</th>
                        <th style="padding: 1rem; font-size: 0.75rem; text-transform: uppercase; color: var(--text-muted);">Email</th>
                        <th style="padding: 1rem; font-size: 0.75rem; text-transform: uppercase; color: var(--text-muted);">Bio</th>
                        <th style="padding: 1rem; font-size: 0.75rem; text-transform: uppercase; color: var(--text-muted);">Status</th>
                        <th style="padding: 1rem; font-size: 0.75rem; text-transform: uppercase; color: var(--text-muted);">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($profiles as $profile)
                        <tr style="border-bottom: 1px solid var(--border-color); transition: var(--transition-fast);" onmouseover="this.style.backgroundColor='var(--bg-main)'" onmouseout="this.style.backgroundColor='transparent'">
                            <td style="padding: 1.1rem 1rem; font-weight: 600;">{{ $profile->user->name ?? 'N/A' }}</td>
                            <td style="padding: 1rem; color: var(--text-muted);">{{ $profile->user->email ?? 'N/A' }}</td>
                            <td style="padding: 1rem; color: var(--text-muted);">{{ $profile->bio ?? 'No bio' }}</td>
                            <td style="padding: 1rem;">
                                @if (($profile->status ?? 'inactive') === 'active')
                                    <span class="badge" style="background: #ecfdf5; color: #10b981;">Active</span>
                                @else
                                    <span class="badge" style="background: #fefce8; color: #eab308;">Inactive</span>
                                @endif
                            </td>
                            <td style="padding: 1rem;">
                                <a href="{{ route('profiles.show', $profile->id) }}" class="btn btn-secondary" style="padding: 0.45rem 0.85rem;">View</a>
                                <a href="{{ route('profiles.edit', $profile->id) }}" class="btn btn-primary" style="padding: 0.45rem 0.85rem; margin-left: 0.45rem;">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding: 3.5rem 2rem; text-align: center; color: var(--text-muted);">
                                <div style="font-size: 2rem; margin-bottom: 0.75rem;">No Data</div>
                                <p style="margin-bottom: 0.5rem; color: var(--text-main); font-weight: 600;">No profiles found.</p>
                                <p style="margin: 0;">There are {{ $registeredUsers }} user accounts, but no saved profile records yet.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 1.5rem;">
            {{ $profiles->links() }}
        </div>
    </div>
@endsection
