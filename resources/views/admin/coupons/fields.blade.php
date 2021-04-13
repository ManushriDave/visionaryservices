@csrf
<div class="form-group row">
    <label class="col-sm-4 col-form-label" for="coupon">Coupon</label>
    <div class="col-sm-8">
        <input name="coupon" value="{{ isset($coupon) ? $coupon->coupon : '' }}" class="form-control" placeholder="Enter Coupon Code" id="coupon" required>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-4 col-form-label" for="discount">Discount (in %)</label>
    <div class="col-sm-8">
        <input name="discount" id="discount" value="{{ isset($coupon) ? $coupon->discount : '' }}" class="form-control" placeholder="Enter Discount (in %)" required>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-4 col-form-label" for="minimum_value">Minimum Value</label>
    <div class="col-sm-8">
        <input name="minimum_value" id="minimum_value" value="{{ isset($coupon) ? $coupon->minimum_value : '' }}" class="form-control" placeholder="Enter Minimum Value" required>
    </div>
</div>
<div class="form-group row">
    <div class="col-sm-10">
        <button type="submit" class="btn btn-success">Edit Coupon</button>
    </div>
</div>
