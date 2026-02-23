@extends('admin.layout')

@section('title', 'Team Members')

@section('content')
    <div class="page-header-modern">
        <div class="page-header-content">
            <h1>Team Members</h1>
            <p>Manage your team members and their profiles</p>
        </div>
        <div class="page-header-actions">
            <a href="{{ route('admin.team-members.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Add New Member
            </a>
        </div>
    </div>

    <div class="card">
        @if($teamMembers->count() > 0)
            <div class="table-container">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th width="80">Order</th>
                            <th width="80">Image</th>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Status</th>
                            <th width="150" class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teamMembers as $member)
                            <tr>
                                <td>
                                    <span class="badge" style="background: var(--color-bg); color: var(--color-text-secondary);">
                                        {{ $member->display_order }}
                                    </span>
                                </td>
                                <td>
                                    @if($member->image)
                                        <img src="{{ asset($member->image) }}" alt="{{ $member->name }}" 
                                            style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover; border: 2px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                                    @else
                                        <div style="width: 48px; height: 48px; border-radius: 50%; background: var(--color-bg); display: flex; align-items: center; justify-content: center; color: var(--color-text-muted);">
                                            <i class="fa-solid fa-user"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div style="font-weight: 600; color: var(--color-text-primary);">{{ $member->name }}</div>
                                    @if(!empty($member->social_links))
                                        <div style="display: flex; gap: 8px; margin-top: 4px;">
                                            @foreach($member->social_links as $platform => $link)
                                                @if($link)
                                                    <a href="{{ $link }}" target="_blank" style="color: var(--color-text-muted); font-size: 12px;" title="{{ ucfirst($platform) }}">
                                                        <i class="fa-brands fa-{{ $platform }}"></i>
                                                    </a>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $member->position }}</td>
                                <td>
                                    @if($member->is_active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-warning">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                        <a href="{{ route('admin.team-members.edit', $member->id) }}" class="btn-icon" title="Edit" style="color: var(--color-primary);">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('admin.team-members.destroy', $member->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon" title="Delete" style="color: var(--color-error); background: none;">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state-table">
                <i class="fa-solid fa-users"></i>
                <h3>No team members found</h3>
                <p>Get started by adding your first team member.</p>
                <div style="margin-top: 1rem;">
                    <a href="{{ route('admin.team-members.create') }}" class="btn btn-primary">
                        <i class="fa-solid fa-plus"></i> Add New Member
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection
