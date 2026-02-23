@extends('layouts.app')

@section('title', 'Report Issue - ' . $song->title_nepali)

@section('content')
    {{-- Success Notification --}}
    @if(session('success'))
        <div id="successToast"
            style="position: fixed; top: 80px; right: 20px; background: #48bb78; color: white; padding: 1rem 1.5rem; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); z-index: 9999; display: flex; align-items: center; gap: 0.75rem; animation: slideIn 0.3s ease;">
            <i class="fa-solid fa-circle-check" style="font-size: 1.2rem;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="container" style="max-width: 800px; margin: 3rem auto; padding: 0 1.5rem;">
        {{-- Back Button --}}
        <a href="{{ route('song.show', [($song->artist ?? $song->writer)->slug ?? 'unknown', $song->slug]) }}"
            style="display: inline-flex; align-items: center; gap: 0.5rem; color: #667eea; text-decoration: none; margin-bottom: 2rem; font-weight: 500;">
            <i class="fa-solid fa-arrow-left"></i> Back to Song
        </a>

        {{-- Report Form Card --}}
        <div style="background: white; padding: 2.5rem; border-radius: 16px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);">
            {{-- Header --}}
            <div style="text-align: center; margin-bottom: 2rem;">
                <div
                    style="width: 60px; height: 60px; background: linear-gradient(135deg, #ed8936 0%, #f56565 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                    <i class="fa-solid fa-triangle-exclamation" style="font-size: 1.75rem; color: white;"></i>
                </div>
                <h1 style="font-size: 2rem; color: #2d3748; margin-bottom: 0.5rem; font-weight: 700;">Report an Issue</h1>
                <p style="color: #718096; font-size: 1rem;">Help us improve the quality of our content</p>
            </div>

            {{-- Song Info --}}
            <div
                style="background: #f7fafc; padding: 1.5rem; border-radius: 12px; margin-bottom: 2rem; border-left: 4px solid #667eea;">
                <div style="font-weight: 600; color: #2d3748; margin-bottom: 0.5rem; font-size: 1.1rem;">
                    {{ $song->title_nepali }}
                </div>
                <div style="color: #718096; font-size: 0.95rem;">
                    {{ $song->title_english }} • by
                    {{ $song->artist->name_english ?? $song->writer->name_english ?? 'Unknown Artist' }}
                </div>
            </div>

            {{-- Report Form --}}
            <form action="{{ route('song.report', $song->slug) }}" method="POST">
                @csrf

                {{-- Issue Type --}}
                <div style="margin-bottom: 1.5rem;">
                    <label
                        style="display: block; margin-bottom: 0.75rem; font-weight: 600; color: #2d3748; font-size: 0.95rem;">
                        <i class="fa-solid fa-circle-exclamation" style="color: #ed8936; margin-right: 0.5rem;"></i>
                        What type of issue are you reporting? *
                    </label>
                    <select name="type" id="reportType" required onchange="toggleCopyrightFields()"
                        style="width: 100%; padding: 0.875rem 1rem; border-radius: 10px; border: 2px solid #e2e8f0; font-size: 1rem; transition: all 0.2s; background: white;">
                        <option value="">Select an issue type</option>
                        <option value="wrong_lyrics">Wrong or Incorrect Lyrics</option>
                        <option value="copyright">Copyright Claim</option>
                    </select>
                </div>

                {{-- Copyright Claim Contact Fields (Hidden by default) --}}
                <div id="copyrightFields"
                    style="display: none; margin-bottom: 1.5rem; padding: 1.5rem; background: #fffaf0; border: 2px solid #fed7aa; border-radius: 12px;">
                    <h4 style="color: #c05621; margin-bottom: 1rem; font-size: 1rem; font-weight: 600;">
                        <i class="fa-solid fa-user-shield" style="margin-right: 0.5rem;"></i>
                        Copyright Claimant Information
                    </h4>
                    <p style="color: #92400e; font-size: 0.85rem; margin-bottom: 1.25rem; line-height: 1.5;">
                        Please provide your contact information so we can verify and process your copyright claim.
                    </p>

                    {{-- Name --}}
                    <div style="margin-bottom: 1rem;">
                        <label
                            style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #2d3748; font-size: 0.9rem;">
                            <i class="fa-solid fa-user" style="color: #667eea; margin-right: 0.5rem;"></i>
                            Full Name *
                        </label>
                        <input type="text" name="claimant_name" id="claimantName" placeholder="Enter your full name"
                            style="width: 100%; padding: 0.75rem 1rem; border-radius: 8px; border: 2px solid #e2e8f0; font-size: 0.95rem; transition: all 0.2s;">
                    </div>

                    {{-- Email --}}
                    <div style="margin-bottom: 1rem;">
                        <label
                            style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #2d3748; font-size: 0.9rem;">
                            <i class="fa-solid fa-envelope" style="color: #667eea; margin-right: 0.5rem;"></i>
                            Email Address *
                        </label>
                        <input type="email" name="claimant_email" id="claimantEmail" placeholder="your.email@example.com"
                            style="width: 100%; padding: 0.75rem 1rem; border-radius: 8px; border: 2px solid #e2e8f0; font-size: 0.95rem; transition: all 0.2s;">
                    </div>

                    {{-- Phone (Optional) --}}
                    <div style="margin-bottom: 0;">
                        <label
                            style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #2d3748; font-size: 0.9rem;">
                            <i class="fa-solid fa-phone" style="color: #667eea; margin-right: 0.5rem;"></i>
                            Phone Number <span style="color: #a0aec0; font-weight: 400;">(Optional)</span>
                        </label>
                        <input type="tel" name="claimant_phone" placeholder="+977 98XXXXXXXX"
                            style="width: 100%; padding: 0.75rem 1rem; border-radius: 8px; border: 2px solid #e2e8f0; font-size: 0.95rem; transition: all 0.2s;">
                    </div>
                </div>

                {{-- Description --}}
                <div style="margin-bottom: 2rem;">
                    <label
                        style="display: block; margin-bottom: 0.75rem; font-weight: 600; color: #2d3748; font-size: 0.95rem;">
                        <i class="fa-solid fa-message" style="color: #667eea; margin-right: 0.5rem;"></i>
                        Additional Details (Optional)
                    </label>
                    <textarea name="description" rows="5"
                        placeholder="Please provide any additional information that might help us address this issue..."
                        style="width: 100%; padding: 0.875rem 1rem; border-radius: 10px; border: 2px solid #e2e8f0; font-size: 1rem; transition: all 0.2s; font-family: inherit; resize: vertical;"></textarea>
                    <div style="color: #a0aec0; font-size: 0.85rem; margin-top: 0.5rem;">
                        Maximum 1000 characters
                    </div>
                </div>

                {{-- Error Messages --}}
                @if ($errors->any())
                    <div
                        style="background: #fff5f5; border: 2px solid #feb2b2; color: #c53030; padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem;">
                        <div style="font-weight: 600; margin-bottom: 0.5rem;">
                            <i class="fa-solid fa-circle-xmark"></i> Please fix the following errors:
                        </div>
                        <ul style="margin-left: 1.5rem;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Action Buttons --}}
                <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                    <button type="submit"
                        style="flex: 1; min-width: 200px; padding: 1rem 2rem; background: linear-gradient(135deg, #ed8936 0%, #f56565 100%); color: white; border: none; border-radius: 10px; cursor: pointer; font-size: 1rem; font-weight: 600; transition: all 0.3s; box-shadow: 0 4px 15px rgba(237, 137, 54, 0.3);">
                        <i class="fa-solid fa-paper-plane"></i> Submit Report
                    </button>
                    <a href="{{ route('song.show', [($song->artist ?? $song->writer)->slug ?? 'unknown', $song->slug]) }}"
                        style="flex: 1; min-width: 200px; padding: 1rem 2rem; background: #e2e8f0; color: #4a5568; border: none; border-radius: 10px; cursor: pointer; font-size: 1rem; font-weight: 600; text-align: center; text-decoration: none; display: inline-block; transition: all 0.3s;">
                        <i class="fa-solid fa-xmark"></i> Cancel
                    </a>
                </div>
            </form>

            {{-- Help Text --}}
            <div
                style="margin-top: 2rem; padding-top: 1.5rem; border-top: 2px solid #edf2f7; color: #718096; font-size: 0.9rem; line-height: 1.6;">
                <i class="fa-solid fa-circle-info" style="color: #4299e1;"></i>
                <strong>Note:</strong> Your report will be reviewed by our team. We typically respond within 24-48 hours.
                False reports may result in restrictions.
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <style>
        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }

            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }

        select:focus,
        textarea:focus,
        input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        button[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(237, 137, 54, 0.4);
        }

        a[style*="background: #e2e8f0"]:hover {
            background: #cbd5e0 !important;
        }
    </style>

    <script>
        // Toggle copyright claimant fields
        function toggleCopyrightFields() {
            const reportType = document.getElementById('reportType').value;
            const copyrightFields = document.getElementById('copyrightFields');
            const claimantName = document.getElementById('claimantName');
            const claimantEmail = document.getElementById('claimantEmail');

            if (reportType === 'copyright') {
                copyrightFields.style.display = 'block';
                claimantName.required = true;
                claimantEmail.required = true;
            } else {
                copyrightFields.style.display = 'none';
                claimantName.required = false;
                claimantEmail.required = false;
                // Clear values when hidden
                claimantName.value = '';
                claimantEmail.value = '';
                document.querySelector('input[name="claimant_phone"]').value = '';
            }
        }

        // Auto-hide success toast
        document.addEventListener('DOMContentLoaded', function () {
            const successToast = document.getElementById('successToast');
            if (successToast) {
                setTimeout(() => {
                    successToast.style.animation = 'slideOut 0.3s ease';
                    setTimeout(() => successToast.remove(), 300);
                }, 4000);
            }
        });
    </script>
@endpush