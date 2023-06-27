<div class="row product_{{ $count }}" id="product_{{ $count }}">
    <div class="row w-100 text-end  mt-3" style="font-size: 20px; font-weight:bolder">
        <i class="icon mdi mdi-delete" onclick="removeProductField({{ $count }})"></i>
    </div>

    <div class="col-md-4  mt-2">
        <div class="form-group">
            <select id="single" class="form-control product" name="product_id[]" style="height: 40px">
                <option></option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}-{{ $count }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4 mt-2">
        <div class="form-group">
            <input class="form-control form-control-xs price_{{ $count }}" type="number" name="price[]" id="product_price"
                placeholder="Enter price" disabled style="height: 40px">
        </div>
    </div>

    <div class="col-md-4 mt-2">
        <div class="form-group">
            <input class="form-control form-control-xs qty_{{ $count }}" onkeyup="QuantityKeyUp()" type="number" name="product_quantity[]" placeholder="Enter quantity"
                style="height: 40px">
        </div>
    </div>
</div>




