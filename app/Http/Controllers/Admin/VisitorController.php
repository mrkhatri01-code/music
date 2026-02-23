<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function index()
    {
        $visits = \App\Models\VisitLog::latest()->paginate(20);

        // Optional: Resolve locations for new IPs (simple synchronous approach for demo)
        // In production, this should be a queued job or resolved on middleware async
        foreach ($visits as $visit) {
            if (!$visit->location_data && $visit->ip_address !== '127.0.0.1') {
                $location = $this->getLocation($visit->ip_address);
                if ($location) {
                    $visit->update(['location_data' => $location]);
                }
            }
        }

        // Calculate Top Location (Country)
        $topCountry = \App\Models\VisitLog::whereNotNull('location_data')
            ->get()
            ->flatMap(function ($visit) {
                return isset($visit->location_data['country']) && !empty($visit->location_data['country'])
                    ? [$visit->location_data['country']]
                    : [];
            })
            ->countBy()
            ->sortDesc()
            ->keys()
            ->first();

        return view('admin.visitors.index', compact('visits', 'topCountry'));
    }

    private function getLocation($ip)
    {
        try {
            $response = \Illuminate\Support\Facades\Http::get("http://ip-api.com/json/{$ip}");
            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Exception $e) {
            // Log error or ignore
        }
        return null;
    }
}
