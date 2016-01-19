@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    Product Views Here <br/>
                    Display the products here
                    <form action="Sync">
                    <input type="submit" value="Sync">
                    </form>     
                </div>
            </div>
        </div>
    </div>
</div>
@endsection