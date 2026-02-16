@extends('admin.layout')

@section('title', 'Contact Message Details')

@section('content')
    {{-- Back Button --}}
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('admin.contacts.index') }}" class="btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Back to Messages
        </a>
    </div>

    {{-- Main Container --}}
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
        {{-- Left Column: Message Details --}}
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            {{-- Message Card --}}
            <div class="card-modern">
                <div class="card-header-modern"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <h2 style="color: white;"><i class="fa-solid fa-envelope-open"></i> Message Details</h2>
                    <div style="display: flex; gap: 0.5rem;">
                        @if($contact->status == 'pending')
                            <span class="badge"
                                style="background: rgba(254, 243, 199, 0.2); color: #fef3c7; border: 1px solid rgba(254, 243, 199, 0.3);">
                                <i class="fa-solid fa-clock"></i> Pending
                            </span>
                        @elseif($contact->status == 'read')
                            <span class="badge"
                                style="background: rgba(186, 230, 253, 0.2); color: #bae6fd; border: 1px solid rgba(186, 230, 253, 0.3);">
                                <i class="fa-solid fa-eye"></i> Read
                            </span>
                        @else
                            <span class="badge"
                                style="background: rgba(134, 239, 172, 0.2); color: #86efac; border: 1px solid rgba(134, 239, 172, 0.3);">
                                <i class="fa-solid fa-check-circle"></i> Replied
                            </span>
                        @endif
                    </div>
                </div>

                <div style="padding: 2rem;">
                    {{-- Subject --}}
                    <div style="margin-bottom: 2rem;">
                        <div
                            style="font-size: 0.75rem; color: var(--color-text-secondary); text-transform: uppercase; font-weight: 600; margin-bottom: 0.5rem; letter-spacing: 0.5px;">
                            <i class="fa-solid fa-bookmark" style="margin-right: 0.5rem;"></i>Subject
                        </div>
                        <div
                            style="font-size: 1.5rem; font-weight: 700; color: var(--color-text-primary); line-height: 1.4;">
                            {{ $contact->subject }}
                        </div>
                    </div>

                    {{-- Message Content --}}
                    <div>
                        <div
                            style="font-size: 0.75rem; color: var(--color-text-secondary); text-transform: uppercase; font-weight: 600; margin-bottom: 0.75rem; letter-spacing: 0.5px;">
                            <i class="fa-solid fa-message" style="margin-right: 0.5rem;"></i>Message
                        </div>
                        <div
                            style="font-size: 1rem; line-height: 1.8; color: var(--color-text-primary); padding: 1.5rem; background: #f9fafb; border-left: 4px solid #667eea; border-radius: 8px; white-space: pre-wrap; word-wrap: break-word;">
                            {{ $contact->message }}</div>
                    </div>
                </div>
            </div>

            {{-- Actions Card --}}
            <div class="card-modern">
                <div class="card-header-modern">
                    <h2><i class="fa-solid fa-sliders"></i> Quick Actions</h2>
                </div>

                <div style="padding: 1.5rem;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <a href="mailto:{{ $contact->email }}?subject=Re: {{ urlencode($contact->subject) }}"
                            class="btn-primary"
                            style="text-decoration: none; text-align: center; justify-content: center; display: flex; align-items: center; gap: 0.5rem; padding: 1rem;">
                            <i class="fa-solid fa-reply"></i> Reply via Email
                        </a>

                        <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" style="margin: 0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger"
                                style="width: 100%; justify-content: center; display: flex; align-items: center; gap: 0.5rem; padding: 1rem;">
                                <i class="fa-solid fa-trash"></i> Delete Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column: Contact Info & Status --}}
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            {{-- Contact Information Card --}}
            <div class="card-modern">
                <div class="card-header-modern">
                    <h2><i class="fa-solid fa-user-circle"></i> Contact Information</h2>
                </div>

                <div style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1.5rem;">
                    {{-- Name --}}
                    <div>
                        <div
                            style="font-size: 0.75rem; color: var(--color-text-secondary); text-transform: uppercase; font-weight: 600; margin-bottom: 0.5rem; letter-spacing: 0.5px;">
                            <i class="fa-solid fa-user" style="margin-right: 0.5rem;"></i>Name
                        </div>
                        <div style="font-size: 1.125rem; font-weight: 600; color: var(--color-text-primary);">
                            {{ $contact->name }}
                        </div>
                    </div>

                    {{-- Email --}}
                    <div>
                        <div
                            style="font-size: 0.75rem; color: var(--color-text-secondary); text-transform: uppercase; font-weight: 600; margin-bottom: 0.5rem; letter-spacing: 0.5px;">
                            <i class="fa-solid fa-envelope" style="margin-right: 0.5rem;"></i>Email
                        </div>
                        <a href="mailto:{{ $contact->email }}"
                            style="font-size: 1rem; font-weight: 500; color: #667eea; text-decoration: none; word-break: break-all;">
                            {{ $contact->email }}
                        </a>
                    </div>

                    {{-- Date --}}
                    <div>
                        <div
                            style="font-size: 0.75rem; color: var(--color-text-secondary); text-transform: uppercase; font-weight: 600; margin-bottom: 0.5rem; letter-spacing: 0.5px;">
                            <i class="fa-solid fa-calendar-days" style="margin-right: 0.5rem;"></i>Submitted
                        </div>
                        <div style="font-size: 1rem; font-weight: 500; color: var(--color-text-primary);">
                            {{ $contact->created_at->format('M d, Y') }}
                            <div style="font-size: 0.875rem; color: var(--color-text-secondary); margin-top: 0.25rem;">
                                {{ $contact->created_at->format('h:i A') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Update Status Card --}}
            <div class="card-modern">
                <div class="card-header-modern">
                    <h2><i class="fa-solid fa-tag"></i> Update Status</h2>
                </div>

                <div style="padding: 1.5rem;">
                    <form action="{{ route('admin.contacts.update-status', $contact) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            <select name="status"
                                style="padding: 0.875rem 1rem; border-radius: 8px; border: 1px solid var(--color-border); font-size: 0.875rem; background: white; font-weight: 500;">
                                <option value="pending" {{ $contact->status == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="read" {{ $contact->status == 'read' ? 'selected' : '' }}>Read</option>
                                <option value="replied" {{ $contact->status == 'replied' ? 'selected' : '' }}>Replied
                                </option>
                            </select>
                            <button type="submit" class="btn-primary"
                                style="width: 100%; justify-content: center; display: flex; align-items: center; gap: 0.5rem; padding: 0.875rem;">
                                <i class="fa-solid fa-check"></i> Update Status
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Stats Card --}}
            <div class="card-modern" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <div style="padding: 1.5rem;">
                    <div style="font-size: 0.875rem; opacity: 0.9; margin-bottom: 0.5rem;">Message ID</div>
                    <div style="font-size: 1.5rem; font-weight: 700;">#{{ $contact->id }}</div>
                    <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.2);">
                        <div style="font-size: 0.875rem; opacity: 0.9;">Received</div>
                        <div style="font-size: 0.875rem; font-weight: 500; margin-top: 0.25rem;">
                            {{ $contact->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Responsive Styles --}}
    <style>
        @media (max-width: 1024px) {
            div[style*="grid-template-columns: 2fr 1fr"] {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
@endsection