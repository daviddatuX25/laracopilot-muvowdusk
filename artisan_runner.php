<?php
// artisan-runner.php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

use Illuminate\Support\Facades\Artisan;

// Run artisan commands
Artisan::call('config:cache');
Artisan::call('route:cache');
Artisan::call('view:cache');
Artisan::call('optimize');

echo "✅ Artisan commands executed successfully!";
