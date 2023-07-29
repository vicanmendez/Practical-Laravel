<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminOrderController extends Controller
{

    public function index()
    {
        $viewData = [];
        $viewData["title"] = "Admin Page - Orders - Online Store";
        $viewData["orders"] = Order::all();
        return view('admin.order.index') -> with("viewData", $viewData) ;
    }

    public function show($id)
    {
        $viewData = [];
        $viewData["title"] = "Order Details - Online Store";
        $viewData["order"] = Order::findOrFail($id);
        $viewData["items"] = $viewData["order"]->getItems();
        return view('admin.order.show') -> with("viewData", $viewData) ;
    }
}
