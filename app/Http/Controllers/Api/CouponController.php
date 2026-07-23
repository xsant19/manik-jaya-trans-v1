<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CouponService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function __construct(protected CouponService $couponService) {}

    /**
     * Validasi kode kupon secara real-time via AJAX.
     *
     * POST /api/coupons/validate
     * Body: { code: string, total_price: numeric }
     */
    public function validate(Request $request): JsonResponse
    {
        $request->validate([
            'code'        => ['required', 'string', 'max:50'],
            'total_price' => ['required', 'numeric', 'min:0'],
        ]);

        $result = $this->couponService->validate(
            $request->input('code'),
            (float) $request->input('total_price'),
        );

        return response()->json([
            'valid'       => $result['valid'],
            'discount'    => $result['discount'],
            'message'     => $result['message'],
            'coupon_name' => $result['coupon_name'] ?? null,
        ]);
    }
}
