@extends('layouts.app')

@section('content')

<?php //print_r($menuList); ?>
<div class="container">
    <form action="menu_save" method="post" class="row" style="padding: 54px;
    border: 1px solid #00000352;
    margin-top: 50px;
    box-shadow: 5px 7px 5px #9699967a;
    border-radius: 7px;">
        {{ csrf_field() }}

        <div class="form-group col-md-4">
            <label for="formGroupExampleInput">Items Name</label>
            <input type='text' name="menu_name" class="form-control">
        </div>

        <div class="form-group col-md-4">
            <label for="formGroupExampleInput">Items Price (Single Item)</label>
            <input type='text' name="price" class="form-control">
        </div>

        <div class="form-group col-md-4">
            <label for="formGroupExampleInput">Action</label>
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

    <br><br>
    <table id="table_id" class="display">
        <thead>
            <tr>
                <th>id</th>
                <th>Name</th>
                <th>Price</th>
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
                <td>{{ $val['price'] }}</td>
                <td>{{ $val['status'] }}</td>
                <td>{{ $val['updated_at'] }}</td>
                <td>{{ $val['created_at'] }}</td>
                <td><button class="btn btn-warning order-status" data-type="Cancel">Cancel</button> | <button
                        class="btn btn-danger order-status" data-type="Delete">Delete</button></td>
            </tr>
            <?php } } ?>
            <!-- <tr>
            <td>Row 2 Data 1</td>
            <td>Row 2 Data 2</td>
        </tr> -->
        </tbody>
    </table>
</div>

@endsection