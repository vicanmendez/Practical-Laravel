@extends('layouts.admin') @section('title', $viewData["title"])
@section('content')
<div class="card mb-4">
   
           
    <div class="card">
        <span class="text-info"> Client name: {{ $viewData["order"]->getUser()->getName() }} </span>
        <span class="text-info"> Order Date: {{ $viewData["order"]->getCreatedAt() }} </span>

        <div class="card-header">
            Order Details
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">Product</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                   </tr>
                </thead>
                <tbody>
                    @foreach ($viewData["items"] as $item)
                    <tr>
                        <td> <a href="{{route('admin.product.edit', ['id'=> $item->getProductId()])}}"> {{ $item->product->getName() }} </a> </td>
                        <td>{{ $item->getPrice() }}</td>
                        <td> {{ $item->getQuantity() }}</td>
                      
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection