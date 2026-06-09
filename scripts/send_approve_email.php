<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Mail;
use App\Models\Cafe;
use App\Mail\CafeApproved;

$cafe = Cafe::with('owner')->whereHas('owner', function ($q) {
    $q->whereNotNull('email')->where('email', '!=', '');
})->first();

if (! $cafe) {
    echo "No cafe with owner email found\n";
    exit(1);
}

echo "Found cafe: {$cafe->id} - {$cafe->name}\n";
echo "Sending to: {$cafe->owner->email}\n";

try {
    Mail::to($cafe->owner->email)->send(new CafeApproved($cafe));
    echo "Email sent successfully.\n";
} catch (\Exception $e) {
    echo "Failed to send email: " . $e->getMessage() . "\n";
    exit(1);
}
