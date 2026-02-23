<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\TeamMember;

$member = TeamMember::latest()->first();

if ($member) {
    echo "ID: " . $member->id . "\n";
    echo "Name: " . $member->name . "\n";
    echo "Image Path in DB: " . $member->image . "\n";
    echo "Full Public Path: " . public_path($member->image) . "\n";
    echo "File Exists in Public: " . (file_exists(public_path($member->image)) ? 'Yes' : 'No') . "\n";

    // Check storage path directly
    $storagePath = storage_path('app/public/' . str_replace('storage/', '', $member->image));
    echo "Full Storage Path: " . $storagePath . "\n";
    echo "File Exists in Storage: " . (file_exists($storagePath) ? 'Yes' : 'No') . "\n";
} else {
    echo "No team members found.\n";
}
