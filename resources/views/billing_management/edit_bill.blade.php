@php
    $imagepath = asset('storage/images/product/' . $product->image);
    $img_default = asset('pos/assets/img/logo-fav.png');
    $img = $product->image != null ? $imagepath : $img_default;
@endphp

<div class="text-center input-file">
    <div class="file-action">
        <img class="rounded-circle mr-2 mb-2 picture-preview profile-picture" src="{{ $img }}" alt="Placeholder"
            width="140" height="140">
        <div class="rounded-circle mr-2 mb-2 file-action-buttons">
            <button class="btn btn-space btn-primary btn-xs change-picture" type="button">
                <i class="icon mdi mdi-edit"></i>
            </button>
            <button class="btn btn-space btn-danger btn-xs delete-picture"  type="button">
                <i class="icon mdi mdi-delete"></i>
            </button>
        </div>
    </div>
    <input type="file" name="image" style="display: none;">
    <input type="hidden" name="old_image">
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Product Name</label>
            <input class="form-control form-control-xs" type="text" name="name" value="{{ $product->name }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Price</label>
            <input class="form-control form-control-xs" type="text" name="price" value="{{ $product->price }}">
        </div>
    </div>

    <div class="row w-100 mt-3">

        <div class="col-12">
            <i class="icon icon-left mdi mdi-plus plus plus_ingredient float-right" onclick="add_ingreddients()"></i>
        </div>
    </div>
    {{-- @dd($stock_units) --}}
    <div class="col-md-6  mt-3">
        <div class="form-group">
            <label>Ingredients</label>
            <select name="stock[]" class="form-control select2 select2-sm select2me" style="height: 40px">
                <option></option>
                @foreach ($stock_units as $stock)
                    <option value="{{ $stock->id }}"><b>{{ $stock->name }} </b>
                        (<sup class="unit_name">{{ $stock->unit_name }}</sup class="unit_name">)
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-6 mt-3">
        <div class="form-group">
            <label>Quantity</label>
            <input class="form-control form-control-xs" type="number" name="stock_quantity[]"
                placeholder="Enter quantity" style="height: 40px">
        </div>
    </div>

    <div class="ingredients">

    </div>
    @foreach ($product->stock as $ingredient)
        {{-- @dd($ingredient->name) --}}
        <div class="d-flex ingredient_{{ $ingredient->pivot->id }}">

            <div class="col-md-6 mt-3">
                <div class="form-group">
                    <input class="form-control form-control-xs" type="text" name="quantity"
                        value="{{ $ingredient->name }}" readonly="">
                </div>
            </div>
            <div class="col-md-6 mt-3">
                <div class="form-group">
                    <input class="form-control form-control-xs" type="number" name="quantity"
                        value="{{ $ingredient->pivot->quantity }}" readonly="">
                </div>
            </div>
            {{-- @dd( $ingredient->pivot->id) --}}
            <div class="row w-100 text-end  mt-3" style="font-size: 20px; font-weight:bolder">

                <i class="icon mdi mdi-delete mt-2 " onclick="removestock({{ $ingredient->pivot->id }})"></i>
            </div>
        </div>
    @endforeach
    <input type="hidden" name="id" value="{{ $product->id }}">
</div>
<script>
    function removestock(id) {
        console.log('id: ', id);
        var url = '{{ route('product.delete_ingredient', ':id') }}';
        url = url.replace(':id', id);
       $.ajax({
                type: 'GET',
                url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {

                    $('.ingredient_' + id).remove();

                },
            });
    }
    $("div.input-file div.file-action-buttons button.change-picture").on("click", function() {
                var input_file_div = $(this).closest("div.input-file");
                $(input_file_div).find("input[type=file]").click();
            });
            $("div.input-file div.file-action-buttons button.delete-picture").on("click", function() {
                var input_file_div = $(this).closest("div.input-file");
                $(input_file_div).find("input[type=file]").val('');
                $(input_file_div).find("img.picture-preview").attr("src",
                    "{{ asset('pos/assets/img/140x140.png') }}");
                $(input_file_div).find("input[name=old_image]").val("");
            });
</script>
