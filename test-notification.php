<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;
use App\Models\Notification;

$product = Product::first();

if ($product && $product->maker) {
    $notification = Notification::create([
        'user_id' => $product->maker->id,
        'product_id' => $product->id,
        'message' => 'Je hebt een nieuwe review ontvangen voor ' . $product->name,
        'is_read' => false,
    ]);
    
    echo "✓ Notificatie succesvol aangemaakt!\n";
    echo "  Maker: {$product->maker->name}\n";
    echo "  Product: {$product->name}\n";
    echo "  Notificatie ID: {$notification->id}\n";
} else {
    echo "✗ Geen product of maker gevonden\n";
}
