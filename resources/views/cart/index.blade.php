@extends('layouts.app') 
@section('title', $viewData["title"])
@section('subtitle', $viewData["subtitle"]) 
@section('content')


@php
    $items = [];
@endphp

<div class="card">
    <div class="card-header">
        Products in Cart
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($viewData["products"] as $product)
                <tr>
                    <td>{{ $product->getId() }}</td>
                    <td>{{ $product->getName() }}</td>
                    <td>${{ $product->getPrice() }}</td>
                    <td>{{ session('products')[$product->getId()] }}</td>
                </tr>
                    @php
                        $item = [];
                        $item["title"] = $product->getName();
                        $item["quantity"] = session('products')[$product->getId()];
                        $item["currency_id"] = "USD";
                        $item["unit_price"] = $product->getPrice();
                        array_push($items, $item);
                    @endphp
                @empty
                <tr>
                    <td colspan="4">No products in cart</td>
                </tr>
                @endforelse

            </tbody>
        </table>
        <div class="row">
            <div class="text-end">
                <a class="btn btn-outline-secondary mb-2">
                    <b>Total to pay:</b>
                    ${{ $viewData["total"] }}</a>
                    @if (count($viewData["products"]) > 0)
                        <a href="{{ route('cart.delete') }}">
                            <button class="btn btn-danger mb-2">
                                Remove all products from Cart
                            </button>
                    @endif
                </a>
            </div>
        </div>
        
        @if (count($viewData["products"]) > 0)
            <div class="row">
                <div class="text-end">
                        <div id="wallet_container"> Purchase</div>
                </div>
            </div>
        @endif
    </div>
</div>


@php
    // MercadoPago SDK
    require base_path('/vendor/autoload.php');
    //Get MercadoPago token from .env file
    $mercadopago_token = $viewData["mercadoPagoToken"];
    MercadoPago\SDK::setAccessToken($mercadopago_token);
    // Crea un objeto de preferencia
    $preference = new MercadoPago\Preference();
    // Crea un ítem en la preferencia
    $totalPrice = 0;
    foreach($items as $item) {
        $totalPrice += $item["unit_price"] * $item["quantity"];
    }
    $item = new MercadoPago\Item();
    $item->title = 'Compras OnlineStore';
    $item->quantity = 1;
    $item->unit_price = $totalPrice;
    $item->currency_id = "USD";
    $preference->items = array($item);
    $preference->back_urls = array(
        "success" => route('cart.success'),
        "failure" => route('cart.failure'),
        "pending" => route('cart.pending')
    );
    $preference->save();


@endphp


<div id="wallet_container"></div>



<script src="https://sdk.mercadopago.com/js/v2"></script>
<script> 

    const mp = new MercadoPago('{{ $viewData["mercadoPagoKey"] }}');
    const bricksBuilder = mp.bricks();

</script>

<script>

mp.bricks().create("wallet", "wallet_container", {
   initialization: {
       preferenceId: "{{ $preference->id }}",
   },
});

</script>


@endsection