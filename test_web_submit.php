<?php
require __DIR__."/vendor/autoload.php";
$app = require_once __DIR__."/bootstrap/app.php";
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::where("role", "customer")->first();
$vehicle = App\Models\Vehicle::first();

$response = (new \Illuminate\Foundation\Testing\Concerns\MakesHttpRequests)->actingAs($user)->post("/booking/vehicles/" . $vehicle->id, [
    "rental_type" => "full_day",
    "start_date" => date("Y-m-d", strtotime("+1 day")),
    "end_date" => date("Y-m-d", strtotime("+1 day")),
    "pickup_location" => "Bali",
    "_token" => csrf_token()
]);

echo $response->status() . "\n";
if ($response->isRedirect()) {
    echo "Redirecting to: " . $response->headers->get("Location") . "\n";
} else {
    echo "Body: " . substr($response->getContent(), 0, 500) . "\n";
}

