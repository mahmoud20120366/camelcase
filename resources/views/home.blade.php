@extends('layouts.app')

@section('content')
<div class="container" ng-controller="controller">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Products</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <!-- write code-->
                    <ul class="products">
                        @foreach($products as $product)
                            <li>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="thumbnail">
                                        <a href="http://via.placeholder.com/150" target="_blank">
                                            <img src="http://via.placeholder.com/150" alt="Lights" style="width:100%">
                                            <div class="caption">
                                                <p>{{$product->getName()}}</p>
                                            </div>
                                        </a>
                                        <button ng-click="addToOrderCart('{{$product->getId()}}', '{{csrf_token()}}', '{{Auth::user()->id}}');">Add to Cart</button>
                                        like:<input type="checkbox" id = "like" ng-click="addToWishCart('{{$product->getId()}}', '{{csrf_token()}}', '{{Auth::user()->id}}');"/>
                                    </div>
                                </div>
                            </div>
                            </li>
                        @endforeach
                        </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection