<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'ad_header' => SiteSetting::get('ad_header', ''),
            'ad_mid1' => SiteSetting::get('ad_mid1', ''),
            'ad_mid2' => SiteSetting::get('ad_mid2', ''),
            'ad_sidebar' => SiteSetting::get('ad_sidebar', ''),
            'ad_footer' => SiteSetting::get('ad_footer', ''),
            'site_name' => SiteSetting::get('site_name', config('app.name')),
            'site_logo' => SiteSetting::get('site_logo', ''),
            'site_description' => SiteSetting::get('site_description', ''),
            'contact_email' => SiteSetting::get('contact_email', ''),
            'facebook_url' => SiteSetting::get('facebook_url', ''),
            'youtube_url' => SiteSetting::get('youtube_url', ''),
            'instagram_url' => SiteSetting::get('instagram_url', ''),
            'tiktok_url' => SiteSetting::get('tiktok_url', ''),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'ad_header' => 'nullable|string',
            'ad_mid1' => 'nullable|string',
            'ad_mid2' => 'nullable|string',
            'ad_sidebar' => 'nullable|string',
            'ad_footer' => 'nullable|string',
            'site_name' => 'nullable|string|max:255',
            'site_description' => 'nullable|string',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'contact_email' => 'nullable|email',
            'facebook_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'tiktok_url' => 'nullable|url',
        ]);

        // Handle Logo Upload
        if ($request->hasFile('site_logo')) {
            $imageName = 'logo.' . $request->site_logo->extension();
            $request->site_logo->move(public_path('images'), $imageName);
            $validated['site_logo'] = 'images/' . $imageName;

            // Also copy as favicon.ico for browser compatibility
            try {
                if (file_exists(public_path('images/' . $imageName))) {
                    copy(public_path('images/' . $imageName), public_path('favicon.ico'));
                }
            } catch (\Exception $e) {
                // Ignore copy errors, partial support is better than crash
            }
        }

        foreach ($validated as $key => $value) {
            // Skip site_logo in loop if it wasn't uploaded (to avoid overwriting with null if logic differs, 
            // but here validated contains it only if present or null. 
            // Actually, we should check if it exists in validated before saving if we want to preserve old one when not uploaded? 
            // The validate rule is nullable. If not in request, it might not be in validated?
            // Actually, for file inputs, if not uploaded, it's not in the request usually or null.
            // Let's ensure we don't overwrite with null if not uploaded.

            if ($key === 'site_logo' && !$request->hasFile('site_logo')) {
                continue;
            }

            SiteSetting::set($key, $value);
        }

        // Clear cache
        Cache::forget('homepage_data');
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully!');
    }

    public function ads()
    {
        $settings = [
            'ads_enabled' => SiteSetting::get('ads_enabled', '1'), // Default to enabled
            'ad_mid1' => SiteSetting::get('ad_mid1', ''),
            'ad_mid2' => SiteSetting::get('ad_mid2', ''),
            'ad_sidebar' => SiteSetting::get('ad_sidebar', ''),
            'ad_footer' => SiteSetting::get('ad_footer', ''),
            'lyrics_fixed_ad' => SiteSetting::get('lyrics_fixed_ad', ''),
            'ad_popup_image' => SiteSetting::get('ad_popup_image', ''),
            'ad_popup_link' => SiteSetting::get('ad_popup_link', ''),
        ];

        return view('admin.settings.ads', compact('settings'));
    }

    public function updateAds(Request $request)
    {
        $validated = $request->validate([
            'ads_enabled' => 'nullable|boolean', // toggle sends 1 or null/0
            'ad_mid1' => 'nullable|string',
            'ad_mid2' => 'nullable|string',
            'ad_sidebar' => 'nullable|string',
            'ad_footer' => 'nullable|string',
            'lyrics_fixed_ad' => 'nullable|string',
            'ad_popup_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'ad_popup_link' => 'nullable|url',
        ]);



        // Handle Image Upload
        if ($request->hasFile('ad_popup_image')) {
            $imageName = 'popup_ad.' . $request->ad_popup_image->extension();
            $request->ad_popup_image->move(public_path('images/ads'), $imageName);
            $validated['ad_popup_image'] = 'images/ads/' . $imageName;
        }

        // Handle toggle checkbox (if unchecked, it's not in request, so default to 0)
        $validated['ads_enabled'] = $request->has('ads_enabled') ? '1' : '0';

        foreach ($validated as $key => $value) {
            // Skip image if not uploaded to avoid overwriting, UNLESS we are deleting it
            if ($key === 'ad_popup_image' && !$request->hasFile('ad_popup_image') && !$request->has('remove_popup_image')) {
                continue;
            }
            // Also skip if it is the remove flag itself (not a setting)
            if ($key === 'remove_popup_image') {
                continue;
            }

            SiteSetting::set($key, $value);
        }

        Cache::forget('homepage_data');
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');

        return redirect()->route('admin.ads.index')
            ->with('success', 'Ad settings updated successfully!');
    }

    public function deletePopupImage()
    {
        $currentImage = SiteSetting::get('ad_popup_image');
        if ($currentImage && file_exists(public_path($currentImage))) {
            @unlink(public_path($currentImage));
        }

        SiteSetting::set('ad_popup_image', '');

        Cache::forget('homepage_data');
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');

        return back()->with('success', 'Popup image deleted successfully!');
    }

    public function reports(Request $request)
    {
        $query = Report::with('song.artist');

        // Filter by type if specified
        if ($request->has('type') && in_array($request->type, ['copyright', 'wrong_lyrics'])) {
            $query->where('type', $request->type);
        }

        $reports = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.settings.reports', compact('reports'));
    }

    public function showReport(Report $report)
    {
        $report->load('song.artist');
        return view('admin.settings.reports.show', compact('report'));
    }

    public function updateReportStatus(Request $request, Report $report)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,reviewed,resolved',
        ]);

        $report->update($validated);

        return back()->with('success', 'Report status updated successfully!');
    }

    public function destroy(Report $report)
    {
        $report->delete();
        return back()->with('success', 'Report deleted successfully!');
    }
}
