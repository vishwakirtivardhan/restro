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
        if(isset($orderType) && !empty($orderType) ){
        foreach($orderType as $key=>$val){ ?>
        <div class="card mb-4 box-shadow">
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
    </div>

    <br>
    <h3>Orders Discount</h3>
    <div class="card-deck mb-3 text-center">
        <?php
        if(isset($orderType_d) && !empty($orderType_d) ){
        foreach($orderType_d as $key=>$val){ ?>
        <div class="card mb-4 box-shadow">
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
    </div>

    <br>
    <h3>Orders Cancel</h3>
    <div class="card-deck mb-3 text-center">
        <?php
        if(isset($orderType_c) && !empty($orderType_c) ){
        foreach($orderType_c as $key=>$val){ ?>
        <div class="card mb-4 box-shadow">
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
    </div>



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

</div>
@endsection