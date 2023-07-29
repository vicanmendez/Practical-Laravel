@extends('layouts.admin') @section('title', $viewData["title"])
@section('content')


<div class="card mb-4">
  
    <div class="card-body">
        @if($errors->any())
        <ul class="alert alert-danger list-unstyled">
            @foreach($errors->all() as $error)
            <li>-
                {{ $error }}</li>
            @endforeach
        </ul>
        @endif
       
<div class="card">
    <div class="card-header">
        Order List
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Total</th>
                    <th scope="col">User</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($viewData["orders"] as $order)
                <tr>
                    <td>{{ $order->getId() }}</td>
                    <td>{{ $order->getTotal() }}</td>
                    <td>
                       {{ $order->getUser()->getName() }}
                    </td>
                    <td>
                        {{ $order->getCreatedAt() }}
                    </td>
                    <td> 
                        <a href="{{ route('admin.order.show', ['id'=> $order->getId()]) }}"> <i class="bi-eye"> </i> </a>
                    </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection