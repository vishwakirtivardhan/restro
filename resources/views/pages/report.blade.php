@extends('layouts.app')

@section('content')

<div class="container" class="m-t-5">

    <form class="needs-validation" novalidate action="http://localhost:8080/restro/report" method="get">
        <br><br>
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label for="validationTooltip01">Select Date From:</label>
                <input type="Date" min="2021-07-01" max="2023-07-01" class="form-control" id="validationTooltip01"
                    name='from' required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="validationTooltip02">Select Date To:</label>
                <input type="DAte" name='to' min="2021-07-01" max="2023-07-01" class="form-control" required>
            </div>
        </div>

        <button class="btn btn-primary" type="submit">Submit form</button>
    </form>
    <br>
    <br>

    <h3>Orders Placed</h3>
    <div class="card-deck mb-3 text-center">
        <?php
        $totalcost=0;
        $totalorder=0;
        if(isset($orderType) && !empty($orderType) ){
        foreach($orderType as $key=>$val){ 
            $totalcost+=$val['totalcost'];
            $totalorder+=$val['orderNo'];
            ?>
        <div class="card mb-3 box-shadow">
            <div class="card-header">
                <h4 class="my-0 font-weight-normal"><?php echo $key; ?></h4>
            </div>
            <div class="card-body">
                <h1 class="card-title pricing-card-title"><?php echo $val['orderNo']; ?> <small class="text-muted">/
                        <?php echo $val['totalcost']; ?></small>
                </h1>
            </div>
        </div>
        <?php } } ?>
        <div class="card mb-3 box-shadow">
            <div class="card-header">
                <h4 class="my-0 font-weight-normal">Total</h4>
            </div>
            <div class="card-body">
                <h1 class="card-title pricing-card-title"><?php echo $totalorder; ?> <small class="text-muted">/
                        <?php echo $totalcost; ?></small>
                </h1>
            </div>
        </div>
    </div>
    <br>
    <hr>
    <br>
    <h3>Orders Discount</h3>
    <div class="card-deck mb-3 text-center">
        <?php
        $totalcost_d=0;
        $totalorder_d=0;
        if(isset($orderType_d) && !empty($orderType_d) ){
        foreach($orderType_d as $key=>$val){ 
            $totalcost_d+=$val['totalcost'];
            $totalorder_d+=$val['orderNo'];
            ?>
        <div class="card mb-3 box-shadow">
            <div class="card-header">
                <h4 class="my-0 font-weight-normal"><?php echo $key; ?></h4>
            </div>
            <div class="card-body">
                <h1 class="card-title pricing-card-title"><?php echo $val['orderNo']; ?> <small class="text-muted">/
                        <?php echo $val['totalcost']; ?></small>
                </h1>
            </div>
        </div>
        <?php } } ?>
        <div class="card mb-3 box-shadow">
            <div class="card-header">
                <h4 class="my-0 font-weight-normal">Total</h4>
            </div>
            <div class="card-body">
                <h1 class="card-title pricing-card-title"><?php echo $totalorder_d; ?> <small class="text-muted">/
                        <?php echo $totalcost_d; ?></small>
                </h1>
            </div>
        </div>
    </div>
    <br>
    <hr>
    <br>
    <h3>Orders Cancel</h3>
    <div class="card-deck mb-3 text-center">
        <?php
         $totalcost_c=0;
         $totalorder_c=0;
        if(isset($orderType_c) && !empty($orderType_c) ){
        foreach($orderType_c as $key=>$val){ 
            $totalcost_c+=$val['totalcost'];
            $totalorder_c+=$val['orderNo'];
            ?>
        <div class="card mb-3 box-shadow">
            <div class="card-header">
                <h4 class="my-0 font-weight-normal"><?php echo $key; ?></h4>
            </div>
            <div class="card-body">
                <h1 class="card-title pricing-card-title"><?php echo $val['orderNo']; ?> <small class="text-muted">/
                        <?php echo $val['totalcost']; ?></small>
                </h1>
            </div>
        </div>
        <?php } } ?>
        <div class="card mb-3 box-shadow">
            <div class="card-header">
                <h4 class="my-0 font-weight-normal">Total</h4>
            </div>
            <div class="card-body">
                <h1 class="card-title pricing-card-title"><?php echo $totalorder_c; ?> <small class="text-muted">/
                        <?php echo $totalcost_c; ?></small>
                </h1>
            </div>
        </div>
    </div>

    <br>
    <hr>
    <br>
    <h3>Item Report</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Item Name</th>
                <th scope="col">Quantity</th>
                <th scope="col">Total Cost</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(isset($item_reports) && !empty($item_reports) ){
            $rowC=0;
            foreach($item_reports as $key=>$val){ ?>
            <tr>
                <th scope="row"><?php echo $rowC++; ?></th>
                <td><?php echo $key; ?></td>
                <td><?php echo $val['quantity']; ?></td>
                <td><?php echo $val['total_cost']; ?></td>
            </tr>
            <?php } } ?>
        </tbody>
    </table>
    <br>
    <hr>
    <br>
    <h3>Order List</h3>
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
                <th> Order Created Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            
            foreach($all_order as $key=>$val){ ?>
            <tr id="{{ $val['id'] }}">
                <td>{{ $val['id'] }} <br> <b> Token: </b>{{ $val['bill_no'] }}</td>
                <td>{{ $val['cust_name'] }}</td>
                <td>{{ $val['cust_phone'] }}</td>
                <td>{{ $val['total_price'] }}</td>
                <td>{{ $val['order_type'] }}</td>
                <td><?php foreach($val['order_lists'] as $key){ echo '<b> Item: </b>'.$key['name'].'<b> Qty:</b>'.$key['quantity'].'<b> T.Cost: </b>'.$key['total_cost'].'<br>'; } ?>
                </td>
                <td>{{$val['emp_name']}}</td>
                <td> {{$val['created_at']}}</td>
                <td> {{$val['orderStatus']}}</td>

            </tr>
            <?php } ?>
            <!-- <tr>
            <td>Row 2 Data 1</td>
            <td>Row 2 Data 2</td>
        </tr> -->
        </tbody>
    </table>
</div>
@endsection