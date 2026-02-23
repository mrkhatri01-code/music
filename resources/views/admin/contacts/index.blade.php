@extends('admin.layout')

@section('title', 'Contact Messages')

@section('content')
    {{-- Modern Page Header --}}
    <div class="page-header-modern">
        <div>
            <h1
                style="font-size: 1.875rem; font-weight: 700; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.75rem;">
                <i class="fa-solid fa-envelope" style="color: var(--color-primary);"></i>
                Contact Messages
            </h1>
            <p style="color: var(--color-text-secondary); font-size: 0.875rem;">Manage user contact form submissions</p>
        </div>
    </div>

    {{-- Stats Summary Cards --}}
    <div
        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
        <div class="stat-mini-card">
            <div class="stat-mini-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <i class="fa-solid fa-envelope"></i>
            </div>
            <div>
                <div class="stat-mini-label">Total Messages</div>
                <div class="stat-mini-value">{{ number_format($contacts->total()) }}</div>
            </div>
        </div>

        <div class="stat-mini-card">
            <div class="stat-mini-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                <i class="fa-solid fa-clock"></i>
            </div>
            <div>
                <div class="stat-mini-label">Pending</div>
                <div class="stat-mini-value">{{ number_format($contacts->where('status', 'pending')->count()) }}</div>
            </div>
        </div>

        <div class="stat-mini-card">
            <div class="stat-mini-icon" style="background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);">
                <i class="fa-solid fa-check-circle"></i>
            </div>
            <div>
                <div class="stat-mini-label">Replied</div>
                <div class="stat-mini-value">{{ number_format($contacts->where('status', 'replied')->count()) }}</div>
            </div>
        </div>
    </div>

    {{-- Modern Table Card --}}
    <div class="card-modern">
        <div class="card-header-modern">
            <h2><i class="fa-solid fa-list"></i> All Messages</h2>
            <div style="display: flex; gap: 0.5rem; align-items: center;">
                {{-- Filter Dropdown --}}
                <form method="GET" action="{{ route('admin.contacts.index') }}" style="margin: 0;">
                    <select name="status" onchange="this.form.submit()"
                        style="padding: 0.5rem 1rem; border-radius: 6px; border: 1px solid var(--color-border); font-size: 0.875rem; cursor: pointer; background: white;">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                            Pending
                        </option>
                        <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>
                            Read
                        </option>
                        <option value="replied" {{ request('status') == 'replied' ? 'selected' : '' }}>
                            Replied
                        </option>
                    </select>
                </form>
                <span class="badge badge-info">{{ $contacts->total() }} total</span>
            </div>
        </div>

        <div class="table-container">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th style="width: 15%;">Name</th>
                        <th style="width: 15%;">Email</th>
                        <th style="width: 20%;">Subject</th>
                        <th style="width: 30%;">Message</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th style="text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contacts as $contact)
                        <tr style="{{ $contact->status === 'pending' ? 'background: #fef3c7;' : '' }}">
                            <td>
                                <div style="font-weight: 600; color: var(--color-text-primary);">
                                    {{ $contact->name }}
                                </div>
                            </td>
                            <td>
                                <a href="mailto:{{ $contact->email }}"
                                    style="color: var(--color-primary); text-decoration: none;">
                                    {{ $contact->email }}
                                </a>
                            </td>
                            <td>
                                <div style="font-weight: 500; color: var(--color-text-primary);">
                                    {{ $contact->subject }}
                                </div>
                            </td>
                            <td>
                                <div style="font-size: 0.875rem; color: var(--color-text-secondary);">
                                    {{ Str::limit($contact->message, 100) }}
                                </div>
                                @if(strlen($contact->message) > 100)
                                    <details style="margin-top: 0.5rem;">
                                        <summary style="cursor: pointer; color: var(--color-primary); font-size: 0.8rem;">Read more
                                        </summary>
                                        <div
                                            style="margin-top: 0.5rem; padding: 0.75rem; background: #f9fafb; border-radius: 6px; font-size: 0.875rem;">
                                            {{ $contact->message }}
                                        </div>
                                    </details>
                                @endif
                            </td>
                            <td style="color: var(--color-text-secondary); font-size: 0.875rem;">
                                {{ $contact->created_at->format('M d, Y') }}
                                <div style="font-size: 0.75rem; color: var(--color-text-muted);">
                                    {{ $contact->created_at->format('h:i A') }}
                                </div>
                            </td>
                            <td>
                                @if($contact->status == 'pending')
                                    <span class="badge" style="background: #fef3c7; color: #92400e;">
                                        <i class="fa-solid fa-clock"></i> Pending
                                    </span>
                                @elseif($contact->status == 'read')
                                    <span class="badge badge-info">
                                        <i class="fa-solid fa-eye"></i> Read
                                    </span>
                                @else
                                    <span class="badge badge-success">
                                        <i class="fa-solid fa-reply"></i> Replied
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; gap: 0.5rem; justify-content: flex-end; align-items: center;">
                                    <a href="{{ route('admin.contacts.show', $contact) }}" class="btn-icon"
                                        style="background: #dbeafe; color: #1e40af;" title="View details">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.contacts.update-status', $contact) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()"
                                            style="padding: 0.5rem 0.75rem; border-radius: 6px; border: 1px solid var(--color-border); font-size: 0.875rem; cursor: pointer;">
                                            <option value="pending" {{ $contact->status == 'pending' ? 'selected' : '' }}>Pending
                                            </option>
                                            <option value="read" {{ $contact->status == 'read' ? 'selected' : '' }}>
                                                Read</option>
                                            <option value="replied" {{ $contact->status == 'replied' ? 'selected' : '' }}>
                                                Replied</option>
                                        </select>
                                    </form>
                                    <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon" style="background: #fee2e2; color: #991b1b;"
                                            title="Delete contact">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-state-table">
                                <i class="fa-solid fa-envelope"></i>
                                <p>No contact messages found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($contacts->hasPages())
            <div style="padding: 1.5rem; border-top: 1px solid var(--color-divider);">
                {{ $contacts->appends(request()->all())->links() }}
            </div>
        @endif
    </div>

@endsection