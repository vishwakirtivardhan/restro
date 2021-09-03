@extends('layouts.app')

@section('content')


<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Button trigger modal -->

<div class="container">
    <br><br><br>

    <div class="form-group " style="
    border-radius: 7px;
    padding: 50px;
    border: 1px solid #007bff73;
    box-shadow: 5px 7px 5px #9699967a;
">
        <button type="button" class="btn btn-primary popitem" data-toggle="modal" data-target="#exampleModal">
            Add Items to Lists
        </button>
        <br><br><br>
        <form id="order_form" class="row" action="save_menu" method="post" style="display:none">
            {{ csrf_field() }}
            <!-- <button type="button" class="btn btn-primary " id="total_bill">
        Total Amount : 0
    </button> -->

            <div class="form-group col-md-3">
                <label for="formGroupExampleInput">Customer Name</label>
                <input type='text' name="cust_name" class="form-control" placeholder="customer_name">
            </div>
            <div class="form-group col-md-3">
                <label for="formGroupExampleInput">Customer Phone</label>
                <input type='number' name="cust_phone" class="form-control" placeholder="customer_phone" required="">
            </div>
            <div class="form-group col-md-3">
                <label for="formGroupExampleInput">Order Type</label>
                <select class="form-control " name="order_type" onchange="fun_ordertype(this)" required=""
                    id="order_type">
                    <option value="">Select option</option>
                    <option value="Cash">Cash</option>
                    <option value="Online">Online</option>
                    <option value="Zomato">Zomato</option>
                </select>
            </div>

            <div class="form-group col-md-3">
                <label for="formGroupExampleInput">Discount %</label>
                <input type='number' name="discount_per" class="form-control" placeholder="discount %"
                    id="disount_enter" on>
            </div>

            <input type='hidden' class="form-control" name="dis_amount" id="dis_amount" placeholder="dis_amount"
                required="">

            <input type='hidden' class="form-control" name="totall_amount" id="totall_amount"
                placeholder="totall_amount">

            <table id="tableForm" style="margin:auto">
                <tbody>
                    <tr>
                        <th>Items</th>
                        <th>Price</th>
                        <th>Quantity</th>
                    </tr>
                </tbody>
            </table>
            <button type="button" class="btn btn-danger" id="total_bill" disabled>
                Total Amount : 0
            </button>
            <div class="col-md-12">

                <button type="Submit" class="btn btn-primary" name="submit" id="order_bill">
                    CheckOut
                </button>
            </div>
        </form>
    </div>

    <br><br>



    <table id="table_id" class="display">
        <thead>
            <tr>
                <th>Order id</th>
                <th>Customer Name</th>
                <th>Customer Phone</th>
                <th>Total Price</th>
                <th>Order Type</th>
                <th>Menu</th>
                <th> Order Created By</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($all_order as $key=>$val){ ?>
            <tr id="{{ $val['id'] }}">
                <td>{{ $val['id'] }} <br> <b> Token: </b>{{ $val['bill_no'] }}</td>
                <td>{{ $val['cust_name'] }}</td>
                <td>{{ $val['cust_phone'] }}</td>
                <td>{{ $val['total_price'] }}</td>
                <td>{{ $val['order_type'] }}</td>
                <td><?php foreach($val['order_lists'] as $key){ echo '<b> Item: </b>'.$key['name'].'<b> Qty:</b>'.$key['quantity'].'<b> T.Cost: </b>'.$key['total_cost'].'<br>'; } ?>
                </td>
                <td>{{$val['emp_name']}}</td>
                <td><button
                        class="btn  <?php if($val['orderStatus']!='Cancel'){ ?>btn-warning order-status <?php } else{ ?>btn-danger<?php }  ?>"
                        data-type="Cancel"> <?php if($val['orderStatus']!='Cancel'){ ?> Cancel
                        <?php } else{ ?>Cancelled<?php }  ?></button>
                    <!-- <button class="btn btn-danger order-status" data-type="Delete">Delete</button> -->
                </td>
            </tr>
            <?php } ?>
            <!-- <tr>
            <td>Row 2 Data 1</td>
            <td>Row 2 Data 2</td>
        </tr> -->
        </tbody>
    </table>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
function fun_ordertype() {
    alert('checls');
    let valiie = $('#order_type').val()
    // console.log(valiie);
    if (valiie == ' q') {
        console.log('check');
        $('.totalpricetotal').removeAttr('readonly');
    } else {
        console.log('checkdone');
        $('.totalpricetotal').attr('readonly', '');
    }
}
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
    $(this).addClass('btn-danger');
    let order_ids = $(this).closest('tr').attr('id');
    // alert(order_ids);
    if (order_ids != null && order_ids !== '' && type !== null && type !== '') {
        $.ajax({
            url: "http://localhost:8080/restro/orderStausChange?id=" + order_ids + "&&type=" + type,
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
    let item_name = $(this).attr('item-name');
    // console.log(listOrder.indexOf(item_name));
    listOrder.splice(listOrder.indexOf(item_name), 1);
    console.log(listOrder);
    $(this).parents('tr').remove();
    totalBillCal();
});
$('.quantity').select2({
    width: '100%',
    placeholder: 'Select Quantity'
});
$('.js-example-basic-single').select2({
    width: '200px',
});
let listOrder = [];
$(".add_item_list").click(function() {
    let appendHTML = '';

    listOrder.push();
    $('#order_form').show();
    let itemprice = $('#items_name').find(':selected').val();
    let item_name = $('#items_name').find(':selected').text();
    let quantity = $('.quantity').find(':selected').val();
    if (listOrder.indexOf(item_name) !== -1) {
        alert('THis is already exits');
    } else {
        listOrder.push(item_name);
        console.log(listOrder);
        //console.log(itemprice);
        let totalprice = quantity * itemprice;
        //console.log(totalprice);
        appendHTML = '<tr><td><input type="hidden" class="form-control" name="item_name[]" value="' +
            item_name +
            '" ><input class="form-control" value="' + item_name +
            '" disabled><input type="hidden" name="item_price[]" id="itemprice" class="form-control" value="' +
            itemprice +
            '" ></td><td><input class="form-control totalprice totalpricetotal" name="item_total_price[]" id="prices" onkeyup="totalBillCal()"  value="' +
            totalprice +
            '" readonly></td><td><input type="number" class="form-control" name="item_quantity[]" S_price="' +
            itemprice +
            '" onchange="quantityUpdate(this)" value="' + quantity +
            '" ></td><td><span class="btn btn-warning remove-item" item-name="' + item_name +
            '" > - </span></td></tr>';

        $('#tableForm tbody').append(appendHTML);
        totalBillCal();
        alert('Add to Cart');
        $(".js-example-basic-single").select2({
            placeholder: "Select a customer",
            initSelection: function(element, callback) {}
        });
    }
    //alert(totalprice);
});

function totalBillCal() {
    console.log('check');
    let totalbill = 0;
    $("#tableForm .totalpricetotal").each(function() {
        // totalbill = parseInt(totalbill);
        totalbill += parseInt($(this).val());
        //console.log('c');
    });
    console.log(totalbill);
    $('#totall_amount').val(totalbill);
    $('#total_bill').text('Total Amount :' + totalbill);
}

function quantityUpdate(data) {
    // alert('checkls');
    let quantity = data.value;
    let price = $(data).attr('S_price');
    let total = quantity * price;
    console.log(total);
    $(data).closest('tr').find('.totalprice').val(total);
    totalBillCal();
}


$("#disount_enter").keyup(function() {
    //alert("Handler for .keyup() called.");
    let dis_a = $(this).val();
    let amount = $('#totall_amount').val();

    let dis_amount = (dis_a * amount) / 100;
    console.log(amount - dis_amount);
    let totollAmount = amount - dis_amount;
    $('#total_bill').html('Totall Amount :' +
        amount + '<br> Total Discount :' + totollAmount);

    $('#dis_amount').val(totollAmount);
});
</script>

@endsection