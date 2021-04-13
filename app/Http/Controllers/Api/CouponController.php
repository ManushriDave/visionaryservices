<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Controller;
use App\Repositories\CouponRepository;
use App\Repositories\Interfaces\CouponRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class CouponController extends Controller
{
    private CouponRepositoryInterface $couponRepo;

    /**
     * CouponController constructor.
     * @param $couponRepo
     */
    public function __construct(CouponRepositoryInterface $couponRepo)
    {
        $this->couponRepo = $couponRepo;
    }

    public function index(): Collection
    {
        return $this->couponRepo->getAll();
    }

    public function apply(Request $request)
    {
        $coupon = Str::upper($request->input('coupon'));
        $total = $request->input('total');

        $coupons = $this->couponRepo->getAll();

        if ($coupons->contains('coupon', $coupon)) {
            $coupon = $coupons->where('coupon', $coupon)->first();

            if ((int) $coupon->minimum_value <= $total) {
                return (int) $coupon->discount;
            } else {
                return response()->json(['errors' => ['message' => ['Total value is less than coupon value.']]], 422);
            }
        }
        return response()->json(['errors' => ['message' => ['Coupon is Invalid.']]], 422);
    }
}
