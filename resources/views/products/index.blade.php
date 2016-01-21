@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    Product Views Here <br/>
                    <form action="Sync">
                    <input type="submit" value="Sync">
                    </form>     
                </div>

                <div class="panel-body">
                    <table class="table-bordered">
                        <tr>
                            <td width="100px">SKU</td>
                            <td width="200px">Product Name</td>
                            <td width="50px">Quantity</td>
                            <td width="100px">Price</td>
                        </tr>
                        @foreach ($rProd as $rP)

                        <tr>
                            <td>{{$rP['sku']}}</td>
                            <td>{{$rP['product_name']}}</td>
                            <td>{{$rP['quantity']}}</td>
                            <td>{{$rP['price']}}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection