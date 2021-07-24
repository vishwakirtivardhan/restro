@extends('layouts.app')

@section('content')


<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary popitem" data-toggle="modal" data-target="#exampleModal">
    Add Item
</button>
<br><br><br>
<button type="button" class="btn btn-danger " id="total_bill" disabled>
    Total Amount : 0
</button>
<br><br>
<form id="order_form" action="save/menu" method="post">
    {{ csrf_field() }}
    <!-- <button type="button" class="btn btn-primary " id="total_bill">
        Total Amount : 0
    </button> -->
    <input type='hidden' name="totall_amount" id="totall_amount" placeholder="totall_amount" required="">
    <input type='text' name="cust_name" placeholder="customer_name" required="">
    <input type='text' name="cust_phone" placeholder="customer_phone" required=""><br>
    <select class="js-example-basic-single" name="order_type">
        <option value="Cash">Cash</option>
        <option value="Online">Online</option>
        <option value="Zomato">Zomato</option>
    </select>
    <table>
        <tbody>
            <tr>
                <th>Items</th>
                <th>Price</th>
                <th>Quantity</th>
            </tr>
        </tbody>
    </table>

    <button type="Submit" class="btn btn-primary " name="submit" id="order_bill">
        CheckOut
    </button>
</form>


<table id="table_id" class="display">
    <thead>
        <tr>
            <th>Order id</th>
            <th>Customer Name</th>
            <th>Customer Phone</th>
            <th>Total Price</th>
            <th>Order Type</th>
            <th>Menu</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($all_order as $key=>$val){ ?>
        <tr id="{{ $val['id'] }}">
            <td>{{ $val['id'] }}</td>
            <td>{{ $val['cust_name'] }}</td>
            <td>{{ $val['cust_phone'] }}</td>
            <td>{{ $val['total_price'] }}</td>
            <td>{{ $val['order_type'] }}</td>
            <td><?php foreach($val['order_lists'] as $key){ echo '<b> Item: </b>'.$key['name'].'<b> Qty:</b>'.$key['quantity'].'<b> T.Cost: </b>'.$key['total_cost'].'<br>'; } ?>
            </td>
            <td><button class="btn btn-warning order-status" data-type="Cancel">Cancel</button> | <button
                    class="btn btn-danger order-status" data-type="Delete">Delete</button></td>
        </tr>
        <?php } ?>
        <!-- <tr>
            <td>Row 2 Data 1</td>
            <td>Row 2 Data 2</td>
        </tr> -->
    </tbody>
</table>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="model_body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary add_item_list">Save Item</button>
            </div>
        </div>
    </div>
</div>
<script>
// This taking the disable 
$.fn.serializeIncludeDisabled = function() {
    let disabled = this.find(":input:disabled").removeAttr("disabled");
    let serialized = this.serialize();
    disabled.attr("disabled", "disabled");
    return serialized;
};

$("#order_bill").click(function() {
    let form_details = $('#order_form').serializeArray();
    form_details = JSON.stringify(form_details);
    console.log(form_details);
});


$(".popitem").click(function() {
    $('#model_body').html('');
    $.ajax('popupOpenItem', {
        //dataType: 'json', // type of response data
        //timeout: 500, // timeout milliseconds
        success: function(data) { // success callback function
            //console.log(data);
            $('#model_body').append(data);
            $('.Modal').show();
            //$('p').append(data.firstName + ' ' + data.middleName + ' ' + data.lastName);
        },
        error: function(jqXhr, textStatus, errorMessage) { // error callback 
            alert('contact to developer');
        }
    });

});

$("table .order-status").click(function() {
    //alert('check');
    let type = $(this).attr('data-type');
    // alert(type);
    let order_ids = $(this).closest('tr').attr('id');
    // alert(order_ids);
    if (order_ids != null && order_ids !== '' && type !== null && type !== '') {
        $.ajax({
            url: "http://localhost:8080/blog/orderStausChange?id=" + order_ids + "&&type=" + type,
            type: 'GET',
            dataType: 'json', // added data type
            success: function(res) {
                console.log(res);
                alert(res);
            }

        });
        alert("Order : " + type);
    } else {
        alert('Some thing is Worng. Pls connect company');
    }
});
$("table .add_col").click(function() {
    let cloneTr = $(this).closest('tr').clone().html();
    let tags = '<tr>' + cloneTr + '</tr>';
    let tagname = $(this).parent('tr');
    //console.log(tagname);
    //tagname.after(tags);
    $('table tbody').append(tags);

    $('.js-example-basic-single').select2();
});

$(document).on('click', '.remove-item', function(e) {
    $(this).parents('tr').remove();
    totalBillCal();
});
$('.quantity').select2({
    width: '100%',
    placeholder: 'Select Quantity'
});
$('.js-example-basic-single').select2();

$(".add_item_list").click(function() {
    let appendHTML = '';
    let itemprice = $('#items_name').find(':selected').val();
    let item_name = $('#items_name').find(':selected').text();
    let quantity = $('.quantity').find(':selected').val();

    let totalprice = quantity * itemprice;

    appendHTML = '<tr><td><input class="form-control" name="item_name[]" value="' + item_name +
        '" ><input type="hidden" name="item_price[]" id="itemprice" class="form-control" value="' +
        itemprice +
        '" ></td><td><input class="form-control" name="item_total_price[]" id="prices" value="' +
        totalprice +
        '" ></td><td><input class="form-control" name="item_quantity[]" S_price="' + itemprice +
        '" onchange="quantityUpdate(this)" value="' + quantity +
        '" ></td><td><span class="btn btn-warning remove-item" > - </span></td></tr>';

    $('table tbody').append(appendHTML);
    totalBillCal();
    alert('Add to Cart');
    $(".js-example-basic-single").select2({
        placeholder: "Select a customer",
        initSelection: function(element, callback) {}
    });
    //alert(totalprice);
});

function totalBillCal() {
    let totalbill = 0;
    $("table #prices").each(function(index) {
        // totalbill = parseInt(totalbill);
        totalbill += parseInt($(this).val());

    });
    //console.log(totalbill);totall_amount
    $('#totall_amount').val(totalbill);
    $('#total_bill').text('Total Amount :' + totalbill);
}

function quantityUpdate(data) {
    // alert('checkls');
    let quantity = data.value;
    let price = $(data).attr('S_price');
    let total = quantity * price;
    $(data).closest('tr').find('#prices').val(total);
    totalBillCal();
}


// $(".target").change(function() {

// });
</script>
@endsection