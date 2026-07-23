<?php
require __DIR__."/vendor/autoload.php";
$app = require_once __DIR__."/bootstrap/app.php";
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $vehicle = App\Models\Vehicle::first();
    $user = App\Models\User::where("role", "customer")->first();
    auth()->login($user);
    
    // Create a valid coupon for testing
    $coupon = App\Models\Coupon::firstOrCreate(
        ["code" => "VALID123"],
        [
            "name" => "Test Coupon", 
            "type" => "fixed", 
            "value" => 10000, 
            "started_at" => now()->subDay(), 
            "expired_at" => now()->addDays(10), 
            "is_active" => true
        ]
    );
    
    $req = new Illuminate\Http\Request();
    $req->merge([
        "rental_type" => "full_day", 
        "start_date" => date("Y-m-d", strtotime("+1 day")), 
        "end_date" => date("Y-m-d", strtotime("+1 day")), 
        "pickup_location" => "Bali", 
        "coupon_code" => "VALID123"
    ]);
    
    $c = app(App\Http\Controllers\Booking\RentalBookingController::class);
    $request = App\Http\Requests\StoreRentalBookingRequest::createFromBase($req);
    $request->setContainer($app);
    $request->setLaravelSession(new \Illuminate\Session\Store("test", new \Illuminate\Session\NullSessionHandler()));
    $request->setRedirector($app->make(Illuminate\Routing\Redirector::class));
    $request->validateResolved();
    
    $resp = $c->store($request, $vehicle);
    
    echo get_class($resp) . "\n";
    if (method_exists($resp, "getTargetUrl")) {
        echo "Redirecting to: " . $resp->getTargetUrl() . "\n";
    }
} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

