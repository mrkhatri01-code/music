@extends('admin.layout')

@section('content')
    {{-- Header --}}
    <div class="dashboard-header" style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 1.8rem; font-weight: 700; color: #1a202c; margin-bottom: 0.5rem;">
                <i class="fa-solid fa-earth-americas" style="color: #667eea; margin-right: 0.5rem;"></i>
                Visitor Tracker
            </h1>
            <p style="color: #718096;">Monitor real-time visitor traffic and locations</p>
        </div>
        <button onclick="location.reload()" 
                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                       color: white; 
                       border: none; 
                       padding: 0.75rem 1.5rem; 
                       border-radius: 8px; 
                       font-weight: 600; 
                       cursor: pointer; 
                       display: flex; 
                       align-items: center; 
                       gap: 0.5rem;
                       transition: all 0.3s ease;
                       box-shadow: 0 4px 6px rgba(102, 126, 234, 0.2);"
                onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 12px rgba(102, 126, 234, 0.3)';"
                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(102, 126, 234, 0.2)';">
            <i class="fa-solid fa-arrows-rotate"></i>
            Refresh
        </button>
    </div>

    {{-- Stats Grid --}}
    <div class="stats-grid-modern">
        <div class="stat-card-modern" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="stat-content">
                <div class="stat-label">Total Visits</div>
                <div class="stat-value">{{ \App\Models\VisitLog::count() }}</div>
            </div>
            <div class="stat-icon">
                <i class="fa-solid fa-eye"></i>
            </div>
        </div>

        <div class="stat-card-modern" style="background: linear-gradient(135deg, #ed8936 0%, #f6ad55 100%);">
            <div class="stat-content">
                <div class="stat-label">Unique IPs</div>
                <div class="stat-value">{{ \App\Models\VisitLog::distinct('ip_address')->count() }}</div>
            </div>
            <div class="stat-icon">
                <i class="fa-solid fa-fingerprint"></i>
            </div>
        </div>

        <div class="stat-card-modern" style="background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);">
            <div class="stat-content">
                <div class="stat-label">Top Location</div>
                <div class="stat-value" style="font-size: 1.2rem; margin-top: 0.5rem;">
                    {{ $topCountry ?? 'N/A' }}
                </div>
            </div>
            <div class="stat-icon">
                <i class="fa-solid fa-map-location-dot"></i>
            </div>
        </div>
    </div>

    {{-- Visitor Log Table --}}
    <div class="card-modern">
        <div class="card-header-modern">
            <h2><i class="fa-solid fa-list-ul"></i> Visit Logs</h2>
        </div>

        <div class="table-container">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>IP Address</th>
                        <th>Location</th>
                        <th>Page Visited</th>
                        <th>Device/Browser</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($visits as $visit)
                        <tr>
                            <td>
                                <div style="font-weight: 600; color: #2d3748;">
                                    {{ $visit->created_at->format('M d, H:i:s') }}</div>
                                <div style="font-size: 0.75rem; color: #a0aec0;">{{ $visit->created_at->diffForHumans() }}
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-info"
                                    style="font-family: monospace;">{{ $visit->ip_address }}</span>
                            </td>
                            <td>
                                @if($visit->location_data)
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        @if(isset($visit->location_data['countryCode']))
                                            <img src="https://flagcdn.com/24x18/{{ strtolower($visit->location_data['countryCode']) }}.png"
                                                alt="{{ $visit->location_data['country'] }}" style="border-radius: 2px;">
                                        @endif
                                        <div>
                                            <div style="font-weight: 600; font-size: 0.85rem;">
                                                {{ $visit->location_data['city'] ?? '-' }}</div>
                                            <div style="font-size: 0.75rem; color: #718096;">
                                                {{ $visit->location_data['country'] ?? 'Unknown' }}</div>
                                        </div>
                                    </div>
                                @else
                                    <span style="color: #a0aec0; font-size: 0.85rem;">-</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ $visit->url }}" target="_blank"
                                    style="color: #4299e1; text-decoration: none; font-size: 0.9rem; display: block; max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ Str::after($visit->url, request()->root()) ?: '/' }}
                                </a>
                                @if($visit->referral)
                                    <div style="font-size: 0.75rem; color: #a0aec0; margin-top: 2px;">
                                        <i class="fa-solid fa-share" style="font-size: 0.7rem;"></i>
                                        {{ parse_url($visit->referral, PHP_URL_HOST) }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div style="font-size: 0.85rem; color: #4a5568;">
                                    {{-- Simple User Agent Parsing --}}
                                    @php
                                        $agent = $visit->user_agent;
                                        $browser = 'Unknown';
                                        $os = 'Unknown';

                                        if (stripos($agent, 'Chrome') !== false)
                                            $browser = 'Chrome';
                                        elseif (stripos($agent, 'Firefox') !== false)
                                            $browser = 'Firefox';
                                        elseif (stripos($agent, 'Safari') !== false)
                                            $browser = 'Safari';
                                        elseif (stripos($agent, 'Edge') !== false)
                                            $browser = 'Edge';

                                        if (stripos($agent, 'Windows') !== false)
                                            $os = 'Windows';
                                        elseif (stripos($agent, 'Mac') !== false)
                                            $os = 'MacOS';
                                        elseif (stripos($agent, 'Linux') !== false)
                                            $os = 'Linux';
                                        elseif (stripos($agent, 'Android') !== false)
                                            $os = 'Android';
                                        elseif (stripos($agent, 'iPhone') !== false)
                                            $os = 'iOS';
                                    @endphp
                                    {{ $browser }} <span style="color: #cbd5e0;">|</span> {{ $os }}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-table">
                                <i class="fa-solid fa-shoe-prints"></i>
                                <p>No visits recorded yet.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($visits->hasPages())
            <div style="padding: 1.5rem; border-top: 1px solid #e2e8f0;">
                {{ $visits->links() }}
            </div>
        @endif
    </div>
@endsection