<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Controller;
use App\Repositories\Interfaces\CouponRepositoryInterface;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

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

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        $coupons = $this->couponRepo->getAll();
        return view('admin.coupons.index', [
            'coupons' => $coupons,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        return view('admin.coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function store(Request $request)
    {
        $request->validate([
            'minimum_value' => 'required|numeric',
            'discount'      => 'required|numeric',
        ]);
        $data = $request->except('_token');
        $data['coupon'] = strtoupper($data['coupon']);
        $this->couponRepo->create($data);
        flash('Successfully Added Coupon!')->success();
        return redirect(route('admin.coupons.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View|Response
     */
    public function edit(int $id)
    {
        $coupon = $this->couponRepo->get($id);
        return view('admin.coupons.edit', [
            'coupon' => $coupon,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     *
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'minimum_value' => 'required|numeric',
            'discount'      => 'required|numeric',
        ]);
        $this->couponRepo->get($id)->update($request->except('_token', '_method'));
        flash('Successfully Edited Coupon!')->success();
        return redirect(route('admin.coupons.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return RedirectResponse
     *
     * @throws Exception
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->couponRepo->get($id)->delete();
        return back();
    }
}
