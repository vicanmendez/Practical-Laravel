<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Item;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//Email resources
use App\Mail\PurchaseNotification;
use Illuminate\Support\Facades\Mail;




class CartController extends Controller
{
    //
    public function index(Request $request)
    {
        $total = 0;
        $productsInCart = [];
        $productsInSession = $request -> session() -> get("products");
        if ($productsInSession) {
            $productsInCart = Product::findMany(array_keys($productsInSession));
            $total = Product::sumPricesByQuantities($productsInCart, $productsInSession);
        }
        $viewData = [];
        $viewData["title"] = "Cart - Online Store";
        $viewData["subtitle"] = "Shopping Cart";
        $viewData["total"] = $total;
        $viewData["products"] = $productsInCart;
        return view('cart.index') -> with ("viewData", $viewData) ;
    }

    public function add(Request $request, $id) {
        $products = $request -> session() -> get("products");
        $products[$id] = $request -> input('quantity');
        $request -> session() -> put('products', $products);
        return redirect() -> route('cart.index');
    }

    public function delete(Request $request) {
        $request -> session() -> forget('products');
        return back();
    }

    public function purchase(Request $request) {
    $productsInSession = $request -> session() -> get("products");
    if ($productsInSession) {
        $userId = Auth::user() -> getId();
        $userBalance = Auth::user() -> getBalance();
        $order = new Order();
        $order -> setUserId($userId);
        $order -> setTotal(0);
        $order -> save();
        $total = 0;
        $productsInCart = Product::findMany(array_keys($productsInSession));
        foreach($productsInCart as $product) {
            $quantity = $productsInSession[$product -> getId()];
            $item = new Item();
            $item -> setQuantity($quantity);
            $item -> setPrice($product -> getPrice());
            $item -> setProductId($product -> getId());
            $item -> setOrderId($order -> getId());
            $item -> save();
            $total = $total + ($product -> getPrice() * $quantity);
        }
        $order -> setTotal($total);
        if($userBalance < $total) {
            $viewData = [];
            $viewData["title"] = "Purchase - Online Store";
            $viewData["subtitle"] = "Purchase Status";
            $viewData["order"] = $order;
            $viewData["error"] = "Insufficient funds";
            return view('cart.purchase') -> with ("viewData", $viewData) ;
        }
        else {
            //If the user has enough money, save the order and update balance
            $order -> save();
            $newBalance = Auth::user() -> getBalance() - $total;
            Auth::user() -> setBalance($newBalance);
            Auth::user() -> save();
            $request -> session() -> forget('products');
            $viewData = [];
            $viewData["title"] = "Purchase - Online Store";
            $viewData["subtitle"] = "Purchase Status";
            $viewData["order"] = $order;
            //Send an e-mail notification to the admin
            $adminsEmail = User::where('role', 'admin')->get('email');
            //Disable SSL verification in local environment
            if (config('app.env') === 'local') {
                config([
                    'mail.mailers.smtp.stream' => [
                        'ssl' => [
                            'allow_self_signed' => true,
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                        ],
                    ],
                ]);
            }
            foreach($adminsEmail as $adminEmail) {
                Mail::to($adminEmail)->send(new PurchaseNotification($order));
            }
            //Return to the view
            return view('cart.purchase') -> with ("viewData", $viewData) ;
        }
        
        }
    else {
        return redirect() -> route('cart.index');
    }
}
    

}