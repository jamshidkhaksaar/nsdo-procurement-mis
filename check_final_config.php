<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Host: " . config('mail.mailers.smtp.host') . PHP_EOL;
echo "Port: " . config('mail.mailers.smtp.port') . PHP_EOL;
echo "Encryption: " . config('mail.mailers.smtp.encryption') . PHP_EOL;
echo "Username: " . config('mail.mailers.smtp.username') . PHP_EOL;
echo "From: " . config('mail.from.address') . PHP_EOL;
