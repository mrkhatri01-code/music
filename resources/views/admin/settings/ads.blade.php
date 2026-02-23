@extends('admin.layout')

@section('title', 'Ad Manager')

@section('content')
    <div class="page-header"
        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 1.875rem; font-weight: 700; color: var(--color-text-primary); margin-bottom: 0.5rem;">
                Ad Manager
            </h1>
            <p style="color: var(--color-text-secondary);">Manage your Google AdSense and other ad placements.</p>
        </div>

        {{-- Global Toggle --}}
        <div class="card-modern"
            style="padding: 0.75rem 1.5rem; display: flex; align-items: center; gap: 1rem; border: 1px solid var(--color-border);">
            <div class="custom-control custom-switch"
                style="display: flex; align-items: center; gap: 0.75rem; padding-left: 2.25rem;">
                <input type="checkbox" class="custom-control-input" id="ads_enabled" name="ads_enabled" form="adsForm"
                    value="1" {{ $settings['ads_enabled'] == '1' ? 'checked' : '' }}>
                <label class="custom-control-label" for="ads_enabled"
                    style="font-weight: 600; cursor: pointer; margin: 0; color: var(--color-text-primary);">
                    Enable All Ads
                </label>
            </div>
        </div>
    </div>

    <form id="adsForm" action="{{ route('admin.ads.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- General Ads Section --}}
        <div class="card-modern" style="margin-bottom: 2rem;">
            <div class="card-header-modern">
                <h2><i class="fa-solid fa-rectangle-ad"></i> General Placements</h2>
            </div>
            <div style="padding: 1.5rem;">
                <div class="alert alert-info" style="margin-bottom: 2rem;">
                    <i class="fa-solid fa-circle-info"></i>
                    <span>Paste your Google AdSense or custom ad code snippets (JS/HTML) directly into the fields
                        below.</span>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                    <div class="form-group">
                        <label for="ad_mid1"><i class="fa-solid fa-pager"
                                style="color: var(--color-text-muted); margin-right: 5px;"></i> Mid Content Ad 1 (Home &
                            Songs)</label>
                        <textarea id="ad_mid1" name="ad_mid1" class="form-control" rows="5"
                            placeholder="<!-- Ad Code -->">{{ old('ad_mid1', $settings['ad_mid1']) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="ad_mid2"><i class="fa-solid fa-music"
                                style="color: var(--color-text-muted); margin-right: 5px;"></i> Mid Content Ad 2 (Songs
                            Only)</label>
                        <textarea id="ad_mid2" name="ad_mid2" class="form-control" rows="5"
                            placeholder="<!-- Ad Code -->">{{ old('ad_mid2', $settings['ad_mid2']) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="ad_sidebar"><i class="fa-solid fa-table-columns"
                                style="color: var(--color-text-muted); margin-right: 5px;"></i> Sidebar Ad (Desktop)</label>
                        <textarea id="ad_sidebar" name="ad_sidebar" class="form-control" rows="5"
                            placeholder="<!-- Ad Code -->">{{ old('ad_sidebar', $settings['ad_sidebar']) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="ad_footer"><i class="fa-solid fa-shoe-prints"
                                style="color: var(--color-text-muted); margin-right: 5px;"></i> Footer Ad</label>
                        <textarea id="ad_footer" name="ad_footer" class="form-control" rows="5"
                            placeholder="<!-- Ad Code -->">{{ old('ad_footer', $settings['ad_footer']) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Special Placements Grid --}}
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">

            {{-- Sticky Ads --}}
            <div class="card-modern">
                <div class="card-header-modern">
                    <h2><i class="fa-solid fa-thumbtack"></i> Sticky & Floating</h2>
                </div>
                <div style="padding: 1.5rem;">
                    <div class="form-group">
                        <label for="lyrics_fixed_ad">Lyrics Page Fixed Ad</label>
                        <textarea id="lyrics_fixed_ad" name="lyrics_fixed_ad" class="form-control"
                            rows="6">{{ old('lyrics_fixed_ad', $settings['lyrics_fixed_ad'] ?? '') }}</textarea>
                        <small
                            style="display: block; margin-top: 0.75rem; color: var(--color-text-secondary); line-height: 1.5; background: var(--color-bg); padding: 0.75rem; border-radius: 6px;">
                            <i class="fa-solid fa-arrow-turn-up" style="margin-right: 4px;"></i>
                            Appears as a fixed/sticky element on the mobile/desktop bottom-right. Users can close it.
                        </small>
                    </div>
                </div>
            </div>

            {{-- Popup Ad --}}
            <div class="card-modern">
                <div class="card-header-modern">
                    <h2><i class="fa-solid fa-clone"></i> Personal Popup</h2>
                </div>
                <div style="padding: 1.5rem;">
                    <div class="form-group">
                        <label for="ad_popup_image">Popup Image</label>

                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            <input type="file" id="ad_popup_image" name="ad_popup_image" class="form-control"
                                accept="image/*" style="padding: 0.5rem;">
                            <small class="form-text text-muted"><i class="fa-solid fa-crop-simple"></i> Square image
                                recommended (1:1 ratio).</small>

                            @if($settings['ad_popup_image'])
                                <div
                                    style="background: var(--color-bg); padding: 1rem; border-radius: 8px; border: 1px dashed var(--color-border); display: flex; gap: 1rem; align-items: center;">
                                    <img src="{{ asset($settings['ad_popup_image']) }}" alt="Popup Ad"
                                        style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; box-shadow: var(--shadow-sm);">

                                    <div style="flex: 1;">
                                        <div style="font-weight: 600; font-size: 0.875rem; margin-bottom: 0.25rem;">Current
                                            Active Image</div>
                                        <button type="button" class="btn btn-danger btn-sm" style="padding: 0.25rem 0.75rem;"
                                            onclick="confirmDeletePopupImage()">
                                            <i class="fa-solid fa-trash"></i> Delete
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: 1.5rem;">
                        <label for="ad_popup_link">Redirect URL (Optional)</label>
                        <div style="position: relative;">
                            <span
                                style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--color-text-muted);">
                                <i class="fa-solid fa-link"></i>
                            </span>
                            <input type="url" id="ad_popup_link" name="ad_popup_link" class="form-control"
                                placeholder="https://example.com/promo"
                                value="{{ old('ad_popup_link', $settings['ad_popup_link']) }}"
                                style="padding-left: 2.5rem;">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Floating Save Button --}}
        <div
            style="position: fixed; bottom: 0; left: var(--sidebar-width); right: 0; background: white; padding: 1rem 2rem; border-top: 1px solid var(--color-border); box-shadow: 0 -4px 6px -1px rgba(0, 0, 0, 0.1); display: flex; justify-content: flex-end; z-index: 50;">
            <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem; font-size: 1rem;">
                <i class="fa-solid fa-floppy-disk"></i> Save Changes
            </button>
        </div>

        {{-- Spacer for floating button --}}
        <div style="height: 80px;"></div>
    </form>

    <style>
        /* Custom Switch Styling override if needed */
        .custom-switch {
            position: relative;
            padding-left: 2.25rem;
        }

        .custom-control-input {
            position: absolute;
            left: 0;
            z-index: -1;
            width: 1rem;
            height: 1.25rem;
            opacity: 0;
        }

        .custom-control-label {
            position: relative;
            margin-bottom: 0;
            vertical-align: top;
        }

        .custom-control-label::before {
            position: absolute;
            top: 0.15rem;
            left: -2.25rem;
            display: block;
            width: 2rem;
            height: 1rem;
            pointer-events: none;
            content: "";
            background-color: #cbd5e0;
            border-radius: 0.5rem;
            transition: all .15s ease-in-out;
        }

        .custom-control-label::after {
            position: absolute;
            top: 0.15rem;
            left: -2.25rem;
            display: block;
            width: 1rem;
            height: 1rem;
            content: "";
            background: #fff;
            border-radius: 0.5rem;
            transition: all .15s ease-in-out;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        .custom-control-input:checked~.custom-control-label::before {
            background-color: var(--color-success);
        }

        .custom-control-input:checked~.custom-control-label::after {
            transform: translateX(1rem);
        }
    </style>

    <form id="deletePopupImageForm" action="{{ route('admin.ads.delete-popup-image') }}" method="POST"
        style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        document.getElementById('adsForm').addEventListener('submit', function () {
            const fieldsToEncode = ['ad_mid1', 'ad_mid2', 'ad_sidebar', 'ad_footer', 'lyrics_fixed_ad'];
            fieldsToEncode.forEach(function (fieldId) {
                const el = document.getElementById(fieldId);
                if (el && el.value) {
                    // Encode to Base64 to bypass server WAF (ModSecurity) blocks on <script> tags
                    el.value = window.btoa(encodeURIComponent(el.value));
                }
            });

            const flag = document.createElement('input');
            flag.type = 'hidden';
            flag.name = 'is_base64_encoded';
            flag.value = '1';
            this.appendChild(flag);
        });

        function confirmDeletePopupImage() {
            Swal.fire({
                title: 'Delete Popup Image?',
                text: "Are you sure you want to remove the current popup image? This cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                focusCancel: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deletePopupImageForm').submit();
                }
            })
        }
    </script>
@endsection