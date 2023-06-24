@php
    $imagepath = asset('storage/images/product/' . $product->image);
    $img_default = asset('pos/assets/img/logo-fav.png');
    $img = $product->image != null ? $imagepath : $img_default;
@endphp

<div class="text-center">
    <img class="rounded-circle mr-2 mb-2 profile-picture"
        src="{{ $img }}" alt="Placeholder" width="140"
        height="140">
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Product Name</label>
            <input class="form-control form-control-xs" type="text" name="name" value="{{ $product->name }}"
                readonly="">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Price</label>
            <input class="form-control form-control-xs" type="text" name="name" value="{{ $product->price }}"
            readonly="">
        </div>
    </div>
</div>
<div class="row">
    @foreach ($product->stock as $ingredient)
{{-- @dd($ingredient->name) --}}
        <div class="col-md-6">
            <div class="form-group">
                <label>Ingredient</label>
                <input class="form-control form-control-xs" type="text" name="quantity" value="{{ $ingredient->name }}"
                    readonly="">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Quantity</label>
                <input class="form-control form-control-xs" type="number" name="quantity" value="{{$ingredient->pivot->quantity}}"
                    readonly="">
            </div>
        </div>
    @endforeach
</div>
