
@extends('format.nav')

@section('title', 'Client Management')

@section('content')
    <div class="hero" style="padding: 2rem 0; text-align: left;">
        <h1 style="margin-bottom: 0.5rem;">Client <span class="text-gradient">Information</span></h1>
        <p style="margin-bottom: 2rem;">Overview of all registered students and clients.</p>
    </div>

    <div class="card" style="padding: 2rem; margin-bottom: 4rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h3 style="margin: 0;">Client Directory</h3>
            <div style="display: flex; gap: 1rem;">
                <span class="badge badge-primary">Total: {{ count($students) }}</span>
            </div>
        </div>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 2px solid var(--border-color); text-align: left;">
                        <th style="padding: 1rem; font-size: 0.75rem; text-transform: uppercase; color: var(--text-muted);">Name</th>
                        <th style="padding: 1rem; font-size: 0.75rem; text-transform: uppercase; color: var(--text-muted);">Gender</th>
                        <th style="padding: 1rem; font-size: 0.75rem; text-transform: uppercase; color: var(--text-muted);">Age</th>
                        <th style="padding: 1rem; font-size: 0.75rem; text-transform: uppercase; color: var(--text-muted);">Location</th>
                        <th style="padding: 1rem; font-size: 0.75rem; text-transform: uppercase; color: var(--text-muted);">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $client)
                        @php
                            $displayAge = $client['age'] ?? (
                                !empty($client['birthdate'])
                                    ? \Carbon\Carbon::parse($client['birthdate'])->age
                                    : null
                            );
                        @endphp
                        <tr style="border-bottom: 1px solid var(--border-color); transition: var(--transition-fast);" onmouseover="this.style.backgroundColor='var(--bg-main)'" onmouseout="this.style.backgroundColor='transparent'">
                            <td style="padding: 1.25rem 1rem; font-weight: 600;">{{$client['name']}}</td>
                            <td style="padding: 1rem; color: var(--text-muted);">{{$client['sex']}}</td>
                            <td style="padding: 1rem; color: var(--text-muted);">{{$displayAge ?? 'N/A'}}</td>
                            <td style="padding: 1rem; color: var(--text-muted);">{{$client['city']}}</td>
                            <td style="padding: 1rem;"><span class="badge" style="background: #f0fdf4; color: #22c55e;">Active</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding: 4rem; text-align: center; color: var(--text-muted);">
                                <div style="font-size: 3rem; margin-bottom: 1rem;">📭</div>
                                <p>No clients found in the database.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('footer')
    @parent
@endsection
