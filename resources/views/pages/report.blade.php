@extends('layouts.app')

@section('content')

<div class="container">
    <form class="needs-validation" novalidate action="http://localhost:8080/restro/report" method="get">
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
    <div class="card-deck mb-3 text-center">
        <?php
        if(isset($order_types) && !empty($order_types) ){
        foreach($order_types as $key=>$val){ ?>
        <div class="card mb-4 box-shadow">
            <div class="card-header">
                <h4 class="my-0 font-weight-normal"><?php echo $key; ?></h4>
            </div>
            <div class="card-body">
                <h1 class="card-title pricing-card-title"><?php echo $val; ?> <small class="text-muted">/ mo</small>
                </h1>
                <!-- <ul class="list-unstyled mt-3 mb-4">
                    <li>10 users included</li>
                    <li>2 GB of storage</li>
                    <li>Email support</li>
                    <li>Help center access</li>
                </ul> -->
                <!-- <button type="button" class="btn btn-lg btn-block btn-outline-primary">Sign up for free</button> -->
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

    <footer class="pt-4 my-md-5 pt-md-5 border-top">
        <div class="row">
            <div class="col-12 col-md">
                <img class="mb-2" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt=""
                    width="24" height="24">
                <small class="d-block mb-3 text-muted">© 2017-2018</small>
            </div>
            <div class="col-6 col-md">
                <h5>Features</h5>
                <ul class="list-unstyled text-small">
                    <li><a class="text-muted" href="#">Cool stuff</a></li>
                    <li><a class="text-muted" href="#">Random feature</a></li>
                    <li><a class="text-muted" href="#">Team feature</a></li>
                    <li><a class="text-muted" href="#">Stuff for developers</a></li>
                    <li><a class="text-muted" href="#">Another one</a></li>
                    <li><a class="text-muted" href="#">Last time</a></li>
                </ul>
            </div>
            <div class="col-6 col-md">
                <h5>Resources</h5>
                <ul class="list-unstyled text-small">
                    <li><a class="text-muted" href="#">Resource</a></li>
                    <li><a class="text-muted" href="#">Resource name</a></li>
                    <li><a class="text-muted" href="#">Another resource</a></li>
                    <li><a class="text-muted" href="#">Final resource</a></li>
                </ul>
            </div>
            <div class="col-6 col-md">
                <h5>About</h5>
                <ul class="list-unstyled text-small">
                    <li><a class="text-muted" href="#">Team</a></li>
                    <li><a class="text-muted" href="#">Locations</a></li>
                    <li><a class="text-muted" href="#">Privacy</a></li>
                    <li><a class="text-muted" href="#">Terms</a></li>
                </ul>
            </div>
        </div>
    </footer>
</div>
@endsection