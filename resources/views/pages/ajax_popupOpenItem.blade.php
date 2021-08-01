<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<form>
    <div class="row">
        <div class="col">
            <!-- <input type="text" class="form-control" placeholder="First name"> -->
            <lable>Select Item:</lable><br>
            <select data-placeholder="Select an option" class="js-example-basic-single form-control"
                onchange="onselectchange()" name="state" id="items_name">

                @foreach ($menu_lists as $key=>$value)
                <option value="{{ $value['price'] }}" attr-price="{{ $value['price'] }}">{{ $value['name'] }}</option>
                @endforeach
            </select>

        </div>

        <div class="col">
            <lable>Select Quantity:</lable><br>
            <select class="quantity form-control" onchange="onselectchange()" data-placeholder="Select Quantity"
                name="quantity">
                <option value='1'>1</option>
                <option value='2'>2</option>
                <option value='3'>3</option>
                <option value='4'>4</option>
                <option value='5'>5</option>
                <option value='6'>6</option>
                <option value='7'>7</option>
                <option value='8'>8</option>
                <option value='9'>9</option>
                <option value='10'>10</option>
            </select>

        </div>
        <div class="col">
            <lable>Item Price:</lable><br>
            <input type='text' class="form-control" name="amount" id="amount" placeholder="Price" disabled>
        </div>
    </div>
</form>
<script>
$('.js-example-basic-single').select2({
    placeholder: "Select a state"
    //allowClear: true
});


$('.quantity').select2({
    placeholder: "Select a state"
    // allowClear: true
});

function onselectchange() {
    //let itemprice = $("#items_name").select2('data')
    let itemprice = $('#items_name').find(':selected').val();
    let item_name = $('#items_name').find(':selected').text();
    console.log(item_name);

    $('#amount').val(itemprice);
    //let itemprice = $("#items_name").select2().find(":selected").data("attr-price")
    //console.log(itemprice);

}
// $(".add_item_list").click(function() {
//     let appendHTML = '';
//     let itemprice = $('#items_name').find(':selected').val();
//     let item_name = $('#items_name').find(':selected').text();
//     let quantity = $('.quantity').find(':selected').val();

//     let totalprice = quantity * itemprice;

//     appendHTML = '<tr><td><input class="form-control" value="' + item_name +
//         '" disabled></td><td><input class="form-control" value="' + totalprice +
//         '" disabled></td><td><input class="form-control" value="' + quantity +
//         '" ></td><td><button href="javascript:void(0)"> + </button></td><td><button href="javascript:void(0)">-</button></td></tr>';

//     $('table tbody').append(appendHTML);

//     //alert(totalprice);
// });
</script>