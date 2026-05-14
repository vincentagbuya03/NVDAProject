@extends('format.nav')

@section('title', 'Maintenance Manager')

@section('content')
<div style="max-width: 1080px; margin: 2rem auto; padding: 0 1rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; gap: 1rem; margin-bottom: 1.25rem;">
        <div>
            <h1 style="margin: 0; font-size: 1.9rem; color: var(--text-main);">Maintenance Manager</h1>
            <p style="margin: 0.4rem 0 0; color: var(--text-muted);">Select URIs to block without editing code.</p>
        </div>
        <span style="padding: 0.45rem 0.75rem; border-radius: 999px; background: {{ $settings['enabled'] ? '#dcfce7' : '#eef2ff' }}; color: {{ $settings['enabled'] ? '#166534' : '#3730a3' }}; font-size: 0.85rem; font-weight: 700;">
            {{ $settings['enabled'] ? 'Maintenance Active' : 'Maintenance Inactive' }}
        </span>
    </div>

    @if (session('status'))
        <div style="margin-bottom: 1rem; padding: 0.85rem 1rem; border-radius: 10px; background: #dcfce7; color: #166534; font-weight: 600;">
            {{ session('status') }}
        </div>
    @endif

    @if (session('warning'))
        <div style="margin-bottom: 1rem; padding: 0.85rem 1rem; border-radius: 10px; background: #fef3c7; color: #92400e; font-weight: 600;">
            {{ session('warning') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="margin-bottom: 1rem; padding: 0.85rem 1rem; border-radius: 10px; background: #fee2e2; color: #991b1b;">
            <strong>Validation failed:</strong>
            <ul style="margin: 0.5rem 0 0 1.1rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section style="margin-bottom: 1rem; background: linear-gradient(135deg, #0f172a 0%, #111827 100%); color: #e5eefc; border-radius: 16px; padding: 1rem 1.1rem; border: 1px solid rgba(255,255,255,0.08); box-shadow: 0 12px 30px rgba(15, 23, 42, 0.16);">
        <div style="display: flex; justify-content: space-between; gap: 1rem; align-items: flex-start; flex-wrap: wrap; margin-bottom: 0.85rem;">
            <div>
                <div style="font-size: 0.78rem; letter-spacing: 0.08em; text-transform: uppercase; color: rgba(229,238,252,0.7); font-weight: 700;">Live Status</div>
                <div style="font-size: 1.05rem; font-weight: 700; margin-top: 0.3rem;">Current blocked rules</div>
            </div>
            <div style="padding: 0.35rem 0.7rem; border-radius: 999px; background: {{ $settings['enabled'] ? 'rgba(34,197,94,0.14)' : 'rgba(249,115,22,0.14)' }}; color: {{ $settings['enabled'] ? '#86efac' : '#fdba74' }}; font-size: 0.82rem; font-weight: 700; border: 1px solid {{ $settings['enabled'] ? 'rgba(34,197,94,0.25)' : 'rgba(249,115,22,0.25)' }};">
                {{ $settings['enabled'] ? 'Maintenance enabled' : 'Maintenance disabled' }}
            </div>
        </div>

        @php
            $blockedUris = $settings['blocked_uris'] ?? [];
            $blockedRouteNames = $settings['blocked_route_names'] ?? [];
            $exceptUris = $settings['except_uris'] ?? [];
        @endphp

        @if ($settings['block_all'])
            <div style="padding: 0.85rem 0.95rem; border-radius: 12px; background: rgba(249,115,22,0.12); border: 1px solid rgba(249,115,22,0.18); margin-bottom: 0.85rem;">
                <strong>All URIs are blocked</strong>
                <div style="margin-top: 0.25rem; color: rgba(229,238,252,0.75); font-size: 0.93rem;">Only the allowed URIs below will remain accessible.</div>
            </div>
        @endif

        <div style="display: grid; gap: 0.8rem; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));">
            <div style="padding: 0.85rem 0.95rem; border-radius: 12px; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.08);">
                <div style="font-weight: 700; margin-bottom: 0.45rem;">Blocked URIs</div>
                @if (count($blockedUris) > 0)
                    <div style="display: flex; flex-wrap: wrap; gap: 0.45rem;">
                        @foreach ($blockedUris as $uri)
                            <span style="padding: 0.28rem 0.55rem; border-radius: 999px; background: rgba(96,165,250,0.16); color: #dbeafe; border: 1px solid rgba(96,165,250,0.2); font-size: 0.85rem;">{{ $uri }}</span>
                        @endforeach
                    </div>
                @else
                    <div style="color: rgba(229,238,252,0.68); font-size: 0.93rem;">No URIs selected yet.</div>
                @endif
            </div>

            <div style="padding: 0.85rem 0.95rem; border-radius: 12px; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.08);">
                <div style="font-weight: 700; margin-bottom: 0.45rem;">Blocked route names</div>
                @if (count($blockedRouteNames) > 0)
                    <div style="display: flex; flex-wrap: wrap; gap: 0.45rem;">
                        @foreach ($blockedRouteNames as $routeName)
                            <span style="padding: 0.28rem 0.55rem; border-radius: 999px; background: rgba(248,113,113,0.16); color: #fee2e2; border: 1px solid rgba(248,113,113,0.2); font-size: 0.85rem;">{{ $routeName }}</span>
                        @endforeach
                    </div>
                @else
                    <div style="color: rgba(229,238,252,0.68); font-size: 0.93rem;">No route name rules saved.</div>
                @endif
            </div>

            <div style="padding: 0.85rem 0.95rem; border-radius: 12px; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.08);">
                <div style="font-weight: 700; margin-bottom: 0.45rem;">Always allowed</div>
                @if (count($exceptUris) > 0)
                    <div style="display: flex; flex-wrap: wrap; gap: 0.45rem;">
                        @foreach ($exceptUris as $uri)
                            <span style="padding: 0.28rem 0.55rem; border-radius: 999px; background: rgba(34,197,94,0.14); color: #bbf7d0; border: 1px solid rgba(34,197,94,0.2); font-size: 0.85rem;">{{ $uri }}</span>
                        @endforeach
                    </div>
                @else
                    <div style="color: rgba(229,238,252,0.68); font-size: 0.93rem;">No allow-list rules saved.</div>
                @endif
            </div>
        </div>
    </section>

    <form method="POST" action="{{ route('maintenance-manager.update') }}" style="display: grid; gap: 1rem;">
        @csrf

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1rem;">
            <label style="display: flex; gap: 0.6rem; align-items: center; background: #fff; border: 1px solid var(--border-color); border-radius: 12px; padding: 0.9rem 1rem;">
                <input type="checkbox" name="enabled" value="1" {{ $settings['enabled'] ? 'checked' : '' }}>
                <span><strong>Enable maintenance</strong><br><small style="color: var(--text-muted);">Turn maintenance rules on/off</small></span>
            </label>

            <label style="display: flex; gap: 0.6rem; align-items: center; background: #fff; border: 1px solid var(--border-color); border-radius: 12px; padding: 0.9rem 1rem;">
                <input type="checkbox" name="block_all" value="1" {{ $settings['block_all'] ? 'checked' : '' }}>
                <span><strong>Block all URIs</strong><br><small style="color: var(--text-muted);">Except routes listed in "Always allow"</small></span>
            </label>
        </div>

        <section style="background: #fff; border: 1px solid var(--border-color); border-radius: 12px; padding: 1rem;">
            <h2 style="margin: 0 0 0.75rem; font-size: 1.1rem;">Select URIs to Block</h2>
            <p style="margin: 0 0 0.75rem; color: var(--text-muted);">Tick the routes you want blocked. Dynamic routes are auto-converted to wildcard patterns.</p>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 0.5rem; max-height: 260px; overflow: auto; padding-right: 0.25rem;">
                @foreach ($webUris as $uri)
                    @php $isChecked = in_array($uri['pattern'], $settings['selected_uris'] ?? [], true); @endphp
                    <label style="display: flex; align-items: center; gap: 0.5rem; padding: 0.4rem 0.55rem; border: 1px solid #e5e7eb; border-radius: 8px;">
                        <input type="checkbox" name="selected_uris[]" value="{{ $uri['pattern'] }}" {{ $isChecked ? 'checked' : '' }}>
                        <span style="font-size: 0.93rem;">{{ $uri['display'] }}</span>
                    </label>
                @endforeach
            </div>
        </section>

        <section style="background: #fff; border: 1px solid var(--border-color); border-radius: 12px; padding: 1rem; display: grid; gap: 0.9rem;">
            <h2 style="margin: 0; font-size: 1.1rem;">Advanced Patterns</h2>

            <div>
                <label for="custom_blocked_uris" style="display: block; font-weight: 600; margin-bottom: 0.35rem;">Custom blocked URI patterns</label>
                <textarea id="custom_blocked_uris" name="custom_blocked_uris" rows="3" style="width: 100%; border: 1px solid #d1d5db; border-radius: 8px; padding: 0.7rem;" placeholder="administrator/*\nstudents/*">{{ implode(PHP_EOL, $settings['custom_blocked_uris'] ?? []) }}</textarea>
                <small style="color: var(--text-muted);">Use comma or new line separation.</small>
            </div>

            <div>
                <label for="blocked_route_names" style="display: block; font-weight: 600; margin-bottom: 0.35rem;">Blocked route name patterns</label>
                <textarea id="blocked_route_names" name="blocked_route_names" rows="2" style="width: 100%; border: 1px solid #d1d5db; border-radius: 8px; padding: 0.7rem;" placeholder="students.*\nusers.*">{{ implode(PHP_EOL, $settings['blocked_route_names']) }}</textarea>
            </div>

            <div>
                <label for="except_uris" style="display: block; font-weight: 600; margin-bottom: 0.35rem;">Always allow URI patterns</label>
                <textarea id="except_uris" name="except_uris" rows="2" style="width: 100%; border: 1px solid #d1d5db; border-radius: 8px; padding: 0.7rem;" placeholder="up\nmaintenance-manager*\nlogin">{{ implode(PHP_EOL, $settings['except_uris']) }}</textarea>
            </div>
        </section>

        <div style="display: flex; justify-content: flex-end;">
            <button type="submit" class="btn btn-primary" style="padding: 0.7rem 1.2rem;">Save Maintenance Settings</button>
        </div>
    </form>
</div>
@endsection
