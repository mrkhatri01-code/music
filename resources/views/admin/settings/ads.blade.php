@extends('admin.layout')

@section('title', 'Ad Manager')

@section('content')
    <div class="page-header">
        <h1>Ad Manager</h1>
        <p>Manage your Google AdSense and other ad codes</p>
    </div>

    <div class="card">
        <form action="{{ route('admin.ads.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="alert" style="background: #ebf8ff; color: #2c5282; border: 1px solid #bee3f8;">
                <i class="fa-solid fa-circle-info"></i>
                <span>Paste your ad code snippets (JS/HTML) directly into the fields below. They will be rendered in the
                    respective slots on the frontend.</span>
            </div>

            <div class="form-group">
                <label for="ad_header">Header Ad (Above navigation)</label>
                <textarea id="ad_header" name="ad_header" class="form-control" rows="4"
                    placeholder="<script>...</script>">{{ old('ad_header', $settings['ad_header']) }}</textarea>
            </div>

            <div class="form-group">
                <label for="ad_mid1">Mid Content Ad 1 (Homepage & song pages)</label>
                <textarea id="ad_mid1" name="ad_mid1" class="form-control" rows="4"
                    placeholder="<script>...</script>">{{ old('ad_mid1', $settings['ad_mid1']) }}</textarea>
            </div>

            <div class="form-group">
                <label for="ad_mid2">Mid Content Ad 2 (Song pages only)</label>
                <textarea id="ad_mid2" name="ad_mid2" class="form-control" rows="4"
                    placeholder="<script>...</script>">{{ old('ad_mid2', $settings['ad_mid2']) }}</textarea>
            </div>

            <div class="form-group">
                <label for="ad_sidebar">Sidebar Ad (Desktop only)</label>
                <textarea id="ad_sidebar" name="ad_sidebar" class="form-control" rows="4"
                    placeholder="<script>...</script>">{{ old('ad_sidebar', $settings['ad_sidebar']) }}</textarea>
            </div>

            <div class="form-group">
                <label for="ad_footer">Footer Ad</label>
                <textarea id="ad_footer" name="ad_footer" class="form-control" rows="4"
                    placeholder="<script>...</script>">{{ old('ad_footer', $settings['ad_footer']) }}</textarea>
            </div>

            <div class="form-group">
                <label for="lyrics_fixed_ad">Lyrics Page Fixed Ad (Sticky Bottom-Right)</label>
                <textarea id="lyrics_fixed_ad" name="lyrics_fixed_ad" class="form-control" rows="4"
                    placeholder="<script>...</script>">{{ old('lyrics_fixed_ad', $settings['lyrics_fixed_ad'] ?? '') }}</textarea>
                <small style="color: #718096; display: block; margin-top: 0.5rem;">
                    <i class="fa-solid fa-circle-info"></i> This ad will appear as a fixed/sticky element on the
                    bottom-right corner of lyrics pages. Users can close it.
                </small>
            </div>

            <h3 style="margin: 2rem 0 1rem; border-top: 1px solid #e2e8f0; padding-top: 2rem;">Personal Popup Ad</h3>

            <div class="form-group">
                <label class="checkbox-label"
                    style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem;">
                    <input type="checkbox" name="ad_popup_active" value="1" {{ old('ad_popup_active', $settings['ad_popup_active']) ? 'checked' : '' }}>
                    <span style="font-weight: 600;">Enable Popup Ad</span>
                </label>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label for="ad_popup_image">Popup Image</label>
                    @if($settings['ad_popup_image'])
                        <div style="margin-bottom: 0.5rem;">
                            <img src="{{ asset($settings['ad_popup_image']) }}" alt="Current Ad"
                                style="max-height: 150px; border-radius: 8px; border: 1px solid #cbd5e0;">
                        </div>
                    @endif
                    <input type="file" id="ad_popup_image" name="ad_popup_image" class="form-control" accept="image/*">
                    <small style="color: #718096;">Recommended width: 600-800px</small>
                </div>

                <div class="form-group">
                    <label for="ad_popup_link">Target URL (Optional)</label>
                    <input type="url" id="ad_popup_link" name="ad_popup_link" class="form-control"
                        value="{{ old('ad_popup_link', $settings['ad_popup_link']) }}"
                        placeholder="https://example.com/offer">
                    <small style="color: #718096;">Where should user go when clicking the image?</small>
                </div>
            </div>

            <div class="form-group">
                <label for="ad_popup_pages">Show Popup On</label>
                <select id="ad_popup_pages" name="ad_popup_pages" class="form-control">
                    <option value="all" {{ old('ad_popup_pages', $settings['ad_popup_pages'] ?? 'all') == 'all' ? 'selected' : '' }}>All Pages</option>
                    <option value="homepage" {{ old('ad_popup_pages', $settings['ad_popup_pages'] ?? 'all') == 'homepage' ? 'selected' : '' }}>Homepage Only</option>
                    <option value="lyrics" {{ old('ad_popup_pages', $settings['ad_popup_pages'] ?? 'all') == 'lyrics' ? 'selected' : '' }}>Lyrics Pages Only</option>
                    <option value="artists" {{ old('ad_popup_pages', $settings['ad_popup_pages'] ?? 'all') == 'artists' ? 'selected' : '' }}>Artist Pages Only</option>
                </select>
                <small style="color: #718096; display: block; margin-top: 0.5rem;">
                    <i class="fa-solid fa-circle-info"></i> Choose which pages the popup ad should appear on
                </small>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-save"></i> Save Ad Settings
            </button>
        </form>
    </div>

@endsection