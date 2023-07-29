<h1>New Purchase Notification</h1>
<p>Order ID: {{ $order->getId() }}</p>
<p>Total: ${{ $order->getTotal() }}</p>
<p>Client: {{ $order->getUser()->getName() }}</p>
<p>Products:</p>
<ul>
    @foreach ($order->items as $item)
        <li>{{ $item->product->name }} - ${{ $item->getPrice() }} (Quantity: {{ $item->getQuantity() }})</li>
    @endforeach
</ul>