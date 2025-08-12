<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Notifications\OrderConfirmed;
use Illuminate\Http\Request;

class OrderController extends Controller
{
     public function confirmOrder(Request $request, Order $order)
    {
        // 1. Lógica para procesar y confirmar el pedido
        $order->status = 'confirmed';
        $order->save();

        // 2. Envía la notificación SMS al usuario del pedido
        // Asegúrate de que el modelo Order tenga una relación 'user' o un campo 'phone_number'.
        $order->user->notify(new OrderConfirmed($order));
        
        return redirect()->back()->with('success', 'Pedido confirmado y SMS enviado al cliente.');
    }
}
