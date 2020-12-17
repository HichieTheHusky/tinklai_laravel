<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\product;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function viewOrders()
    {
        $user = auth()->user();
        if($user->user_type == User::ROLE_WORKER){
            $orders= Order::get()->all();
        }

        if($user->user_type == User::ROLE_USER){
            $orders= Order::where('fk_user', $user->id)->get()->all();
        }


        return view('viewOrders', compact('orders'));
    }

    public function deleteOrder(Request $request)
    {
        $order = Order::find($request['id']);
        foreach($order->items as $item)
        {
            if($item->pivot->status == 1)
            {
                $item->quantity = $item->quantity + $item->pivot->quantity;
                $item->save();
            }
        }
        $items = Item::where('fk_order',$request['id'])->get()->all();
        foreach ($items as $item)
        {
            $item->delete();
        }
        $order->delete();
        return redirect()->route('viewOrders');
    }

    public function approveOrder(Request $request)
    {
        $order = Order::find($request['id']);
        $order->status = 1;
        $order->save();

        $to = User::find($order->fk_user);

        Mail::send([], [], function ($message) use ($to) {
            $string = "<h1>Sveiki, jūsų užsakymas buvo patvirtintas!</h1>";
            $message->to($to->email, $to->name)
                ->from('sky.pagalba@gmail.com','SKY pagalba')
                ->subject("užsakymas KTU Tinklu IT projekte")
                ->setBody($string,'text/html'); // for HTML rich messages
        });

        return redirect()->route('viewOrders');
    }
}
