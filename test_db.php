<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$count = App\Models\User::count();
echo "User count in DB: " . $count . "\n";
$cats = App\Models\Category::count();
echo "Categories count in DB: " . $cats . "\n";
