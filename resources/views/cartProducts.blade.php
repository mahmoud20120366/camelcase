@extends('layouts.app')

@section('content')
    <div class="container" ng-controller="controller">
        <h1>{{$type}}</h1>
        @if($type == "wish")
            <ul class="products">
                @foreach($products as $product)
                    <li>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="thumbnail">
                                    <a ng-click="removeWishProduct('{{$product->getId()}}', '{{csrf_token()}}');"><i class="glyphicon glyphicon-remove"></i></a>
                                    <a href="http://via.placeholder.com/150" target="_blank">
                                        <img src="http://via.placeholder.com/150" alt="Lights" style="width:100%">
                                        <div class="caption">
                                            <p>{{$product->getName()}}</p>
                                            <p>
                                                {{$product->getPrice()}}
                                                @if($product->type == "sale")
                                                    -->{{$product->getNewPrice()}}
                                                @endif
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
            <form action="/wishcarts/{{Auth::user()->id}}/edit" method="GET">
                {{csrf_field()}}
                <input type="submit" value="empty">
            </form>
        @else
            <ul class="products">
                @foreach($products as $product)
                    <li>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="thumbnail">
                                    <a ng-click="removeOrderProduct('{{$product->getProduct()->getId()}}', '{{csrf_token()}}');"><i class="glyphicon glyphicon-remove"></i></a>
                                    <a href="http://via.placeholder.com/150" target="_blank">
                                        <img src="http://via.placeholder.com/150" alt="Lights" style="width:100%">
                                        <div class="caption">
                                            <p>{{$product->getProduct()->getName()}}</p>
                                            <p>
                                                {{$product->getProduct()->getPrice()}}
                                                @if($product->getProduct()->type == "sale")
                                                    -->{{$product->getProduct()->getNewPrice()}}
                                                @endif
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
            <form action="/orders" method="POST">
                {{csrf_field()}}
                <input type="submit" value="order">
            </form>
            <form action="/ordercarts/{{Auth::user()->id}}/edit" method="GET">
                {{csrf_field()}}
                <input type="submit" value="empty">
            </form>
        @endif
    </div>
@endsection