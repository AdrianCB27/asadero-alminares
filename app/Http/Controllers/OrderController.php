<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Notifications\OrderConfirmed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
   public function index()
   {
      $orders = Order::where('user_id', Auth::id())->where('total',">","0")->orderBy('id', 'desc')->get();
      return view('order.index', compact('orders'));
   }
}
