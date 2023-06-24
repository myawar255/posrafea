

<div class="row ingredient_{{ $count }}" id="ingredient_{{ $count }}">
    <div class="row w-100 text-end  mt-3" style="font-size: 20px; font-weight:bolder">

        <i class="icon mdi mdi-delete" onclick="removeClubField({{ $count }})"></i>
    </div>


    <div class="col-md-6  mt-2">
        <div class="form-group">
            <select  class="form-control select2 select2-sm select2me" name="stock[]" >
                <option ></option>
                @foreach ($stock_units as $stock)
                    <option value="{{ $stock->id }}" ><b>{{ $stock->name }} </b>
                        (<sup class="unit_name">{{ $stock->unit_name }}</sup class="unit_name">) </option>
                @endforeach
            </select>
        </div>
    </div>




    {{-- <div class="col-md-3 mt-2">
        <div class="form-group">
            <select name="unit_id" class="form-control" style="height: 40px">
                <option selected disabled> select unit</option>
                @foreach ($units as $unit)
                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                @endforeach
            </select>
        </div>
    </div> --}}
    <div class="col-md-6 mt-2">
        <div class="form-group">
            <input class="form-control form-control-xs" type="number" name="stock_quantity[]" placeholder="Enter quantity"
                style="height: 40px">
        </div>
    </div>
</div>


