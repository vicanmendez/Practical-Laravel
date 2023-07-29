@extends('layouts.app')
@section('title', $viewData["title"])
@section('subtitle', $viewData["subtitle"])
@section('content')
    <div class="card">
    <div class="card-header">
        @if(isset($viewData["error"])) 
            <div class="card-body">
                <div class="alert alert-danger" role="alert">
                {{ $viewData["error"] }}
        @else 
        <div class="card-body">
            <div class="alert alert-success" role="alert">
            Congratulations, purchase completed. Order number is <b>#{{ $viewData["order"]->getId() }}</b>
        </div>
        </div> 
        @endif 
    </div>
    
    </div>
@endsection
