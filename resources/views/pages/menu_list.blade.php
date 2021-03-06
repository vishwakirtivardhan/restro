@extends('layouts.app')

@section('content')

<?php //print_r($menuList); ?>
<div class="container">
    <br>
    <h3>Add New Item</h3>
    <form action="menu_save" method="Post" class="row" style="padding: 54px;
    border: 1px solid #00000352;
    box-shadow: 5px 7px 5px #9699967a;
    border-radius: 7px;">
        {{ csrf_field() }}

        <div class="form-group col-md-4">
            <label for="formGroupExampleInput">Items Name</label>
            <input type='text' name="menu_name" class="form-control">
        </div>

        <div class="form-group col-md-4">
            <label for="formGroupExampleInput">Items Price (Single Item)</label>
            <input type='number' name="price" class="form-control">
        </div>

        <div class="form-group col-md-4">
            <label for="formGroupExampleInput">Select Category</label>
            <select name='status' class="form-control">
                <option value="A">Active</option>
                <option value="N">Disable</option>
            </select>
        </div>

        <div class="form-group col-md-4">
            <label for="formGroupExampleInput">Action</label>
            <select name='category' class="form-control">
                <option value="Farali">Farali</option>
                <option value="Chinese">Chinese</option>
                <option value="Jain">Jain</option>
                <option value="Normal">Normal</option>
            </select>
        </div>

        <div class="form-group col-md-4">
            <!-- <label for="formGroupExampleInput">Items Price (Single Item)</label> -->
            <input type="submit" class="form-control btn btn-primary">
        </div>


    </form>

    <hr>
    <h3> Update Status </h3>
    <form action="category_action" method="Post" class="row" style="padding: 54px;
    border: 1px solid #00000352;
    box-shadow: 5px 7px 5px #9699967a;
    border-radius: 7px;">
        {{ csrf_field() }}
        <div class="form-group col-md-4">
            <label for="formGroupExampleInput">Category</label>
            <select name='category' class="form-control">
                <option value="Farali">Farali</option>
                <option value="Chinese">Chinese</option>
                <option value="Jain">Jain</option>
                <option value="Normal">Normal</option>
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="formGroupExampleInput">Action </label>
            <select name='status' class="form-control">
                <option value="A">Active</option>
                <option value="N">Disable</option>
            </select>
        </div>



        <div class="form-group col-md-4">
            <!-- <label for="formGroupExampleInput">Items Price (Single Item)</label> -->
            <input type="submit" class="form-control btn btn-primary">
        </div>


    </form>

    <hr>
    <h3>Item List</h3>
    <table id="table_id" class="display">
        <thead>
            <tr>
                <th>id</th>
                <th>Name</th>
                <th>Price</th>
                <th>Category</th>
                <th>status</th>

                <th>Updated At</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(isset($menuList)){
            foreach($menuList as $key=>$val){ ?>
            <tr id="{{ $val['id'] }}">
                <td>{{ $val['id'] }}</td>
                <td>{{ $val['name'] }}</td>
                <td class="priceChange">{{ $val['price'] }}</td>
                <td>{{$val['category']}}</td>
                <td>{{ $val['status'] }}</td>
                <td>{{ $val['updated_at'] }}</td>
                <td>{{ $val['created_at'] }}</td>
                <td> <select class="btn menuchange">
                        <option value="">
                            -- Select Action --
                        </option>
                        <option value="A">
                            Active
                        </option>
                        <option value="N">
                            disabled
                        </option>
                    </select>
                    <button class="btn btn-danger order-status" data-type="Delete">Delete</button>
                </td>
            </tr>
            <?php } } ?>
            <!-- <tr>
            <td>Row 2 Data 1</td>
            <td>Row 2 Data 2</td>
        </tr> -->
        </tbody>
    </table>
</div>
<script>
$(".menuchange").change(function() {
    // confirm('Do you Want to change the Status ?');
    type = $('option:selected', this).val();
    let menu_ids = $(this).closest('tr').attr('id');
    // alert(menu_ids);

    if (menu_ids != null && menu_ids !== '' && type !== null && type !== '') {
        $.ajax({
            url: "http://localhost:8080/restro/menuStatus?id=" + menu_ids + "&type=" + type,
            type: 'GET',
            //dataType: 'json', // added data type
            success: function(res) {
                //console.log(res);
                alert(res);

                location.reload();
            }
        });


        // alert("Order : " + type);
    } else {
        alert('Some thing is Worng. Pls connect company');
    }
});

$(".priceChange").click(function() {
    //alert('check');
    let price = $(this).text();
    // alert(price);
    let updatePrice = prompt("Please enter New Price", $(this).text());
    //alert(updatePrice);
    // let type = $(this).attr('data-type');
    // // alert(type);
    // $(this).addClass('btn-danger');
    let menu_ids = $(this).closest('tr').attr('id');
    //alert(menu_ids);
    if (menu_ids != null && menu_ids !== '' && updatePrice !== null && updatePrice !== price) {
        $.ajax({
            url: "http://localhost:8080/restro/updatePrice?id=" + menu_ids + "&updatePrice=" +
                updatePrice,
            type: 'GET',
            // dataType: 'json', // added data type
            success: function(res) {
                // console.log(res);
                alert(res);
                location.reload();
            }

        });


        // alert("Order : " + type);
    } else {
        alert('You have not change he Cost');
    }
});
</script>
@endsection