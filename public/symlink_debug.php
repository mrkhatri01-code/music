<?php
// symlink_debug.php
// Visit: domain.com/public/symlink_debug.php

echo "<h1>Storage Auto-Fixer</h1>";

$target = __DIR__ . '/../storage/app/public';
$link = __DIR__ . '/storage';

echo "Target: $target<br>";
echo "Link: $link<br><hr>";

// 1. CLEANUP: If 'storage' is a real folder, rename it
if (file_exists($link) && is_dir($link) && !is_link($link)) {
    echo "Files detected in 'public/storage'. Renaming to 'storage_OLD'...<br>";
    if (rename($link, __DIR__ . '/storage_OLD_' . time())) {
        echo "<h3 style='color:green'>SUCCESS: Renamed blocking folder!</h3>";
    } else {
        echo "<h3 style='color:red'>FAILED to rename folder. Permissions denied. You MUST delete 'public/storage' manually in File Manager.</h3>";
    }
}

// 2. CREATE LINK
if (!file_exists($link)) {
    echo "Attempting to create symlink...<br>";
    try {
        if (symlink($target, $link)) {
            echo "<h1 style='color:green'>FIXED! Symlink created.</h1>";
            echo "Images should work now.";
        } else {
            echo "<h3 style='color:red'>PHP symlink() failed.</h3>";
        }
    } catch (Throwable $e) {
        echo "<h3 style='color:red'>Error: " . $e->getMessage() . "</h3>";
    }
} else {
    if (is_link($link)) {
        echo "<h1 style='color:green'>Symlink ALREADY EXISTS!</h1>";
        echo "Points to: " . readlink($link);
    }
}

// 3. CRON COMMAND
echo "<hr><h3>If the above failed, RUN THIS CRON JOB NOW:</h3>";
echo "<pre style='background:#f4f4f4; padding:10px;'>cd " . __DIR__ . " && ln -s ../storage/app/public storage</pre>";
echo "(The blocking folder should be gone now, so this command will finally work!)";
