<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Mailer: " . config('mail.default') . PHP_EOL;
echo "Host: " . config('mail.mailers.smtp.host') . PHP_EOL;
echo "Port: " . config('mail.mailers.smtp.port') . PHP_EOL;
echo "User: " . config('mail.mailers.smtp.username') . PHP_EOL;
echo "Encryption: " . config('mail.mailers.smtp.encryption') . PHP_EOL;
echo "From Email: " . config('mail.from.address') . PHP_EOL;
echo "From Name: " . config('mail.from.name') . PHP_EOL;
