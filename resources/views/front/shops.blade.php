@extends('layouts.front')
@section('content')

        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Shop in style</h1>
                    <p class="lead fw-normal text-white-50 mb-0">With this shop hompeage template</p>
                </div>
            </div>
        </header>
        <!-- Section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    @foreach($items as $item)
                        <div class="col mb-5">
                            <div class="card h-100">
                                <!-- Product image-->
                                <img class="card-img-top" src="{{$item->image}}" alt="..." />
                                <!-- Product details-->
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <!-- Product name-->
                                        <h5 class="fw-bolder">{{$item->name}}</h5>
                                        <!-- Product price-->
                                         @if($item->discount > 0)
                                            <span class="text-decoration-line-through ">{{$item->price}}</span>
                                            {{$item->price - ($item->price*($item->discount/100))}} MMK
                                        @else 
                                            {{$item->price}} MMK
                                        @endif
                                    </div>
                                </div>
                                <!-- Product actions-->
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <div class="text-center row">
                                        <div class="col-md-4">
                                            <a class="btn btn-sm btn-outline-dark mt-auto" href="{{route('shop-item', $item->id)}}">Detial</a>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="hidden" name="" class="qty" value="1">
                                            <button class="btn btn-sm btn-dark addToCart" data-id="{{$item->id}}" data-name="{{$item->name}}" data-price="{{$item->price}}" data-discount="{{$item->discount}}" data-image="{{$item->image}}">Add to cart</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div> 
                {{$items->links()}}
            </div>
        </section>
@endsection