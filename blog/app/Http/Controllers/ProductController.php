<?php

namespace App\Http\Controllers;

use App\Models\accessory;
use App\Models\base;
use App\Models\brake;
use App\Models\Item;
use App\Models\Order;
use App\Models\product;
use App\Models\saddle;
use App\Models\tyre;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function createPreke(Request $request)
    {

        $product = new product();
        $product->name = $request['pavadinimas'];
        $product->price = $request['kaina'];
        $product->category = $request['kategory'];
        $product->description = $request['tekstas'];
        $product->photo = $request['url'];
        $product->color = $request['color'];
        $product->quantity = $request['quantity'];

        if ($request['kategory'] == product::TYPE_ACC) {
            $type_product = new accessory();
            $type_product->type = $request['type'];
            $type_product->materials = $request['material'];
            $type_product->save();
            $product->fk_acc = $type_product->getAttribute('id');
        }

        if ($request['kategory'] == product::TYPE_BASE) {
            $type_product = new base();
            $type_product->usecase = $request['usecase'];
            $type_product->weight = $request['weight'];
            $type_product->material = $request['material'];
            $type_product->save();
            $product->fk_base = $type_product->getAttribute('id');
        }

        if ($request['kategory'] == product::TYPE_BRAKE) {
            $type_product = new brake();
            $type_product->type = $request['type'];
            $type_product->material = $request['material'];
            $type_product->save();
            $product->fk_break = $type_product->getAttribute('id');
        }

        if ($request['kategory'] == product::TYPE_SADDLE) {
            $type_product = new saddle();
            $type_product->size = $request['size'];
            $type_product->weight = $request['weight'];
            $type_product->maxload = $request['maxweight'];
            $type_product->save();
            $product->fk_saddle = $type_product->getAttribute('id');
        }

        if ($request['kategory'] == product::TYPE_TYRE) {
            $type_product = new tyre();
            $type_product->size = $request['size'];
            $type_product->weight = $request['weight'];
            $type_product->maxload = $request['maxweight'];
            $type_product->save();
            $product->fk_tyres = $type_product->getAttribute('id');
        }

        $product->save();

        return redirect()->route('home');
    }

    public function viewPrekes()
    {
        $products = product::get()->all();
        return view('viewProducts', compact('products'));
    }

    public function deleteProduct(Request $request)
    {
        $product = product::find($request['id']);
        if ($product->fk_base !== null) {
            $part = base::find($product->fk_base);
            $part->delete();
        }
        if ($product->fk_break !== null) {
            $part = brake::find($product->fk_break);
            $part->delete();
        }
        if ($product->fk_saddle !== null) {
            $part = saddle::find($product->fk_saddle);
            $part->delete();
        }
        if ($product->fk_tyres !== null) {
            $part = tyre::find($product->fk_tyres);
            $part->delete();
        }
        if ($product->fk_acc !== null) {
            $part = accessory::find($product->fk_acc);
            $part->delete();
        }
        $product->delete();

        return redirect()->route('viewProducts');
    }

    public function getProduct(Request $request)
    {
        $product = product::find($request['id']);
        return view('updatePreke', compact('product'));
    }

    public function addPreke(Request $request)
    {
        $product = product::find($request['id']);
        $product->quantity = $product->quantity + $request['quantity'];
        $product->save();
        $this->updateOrders($request['id']);
        return redirect()->route('viewProducts');
    }

    public function updatePreke(Request $request)
    {
        $product = product::find($request['id']);
        $product->name = $request['pavadinimas'];
        $product->price = $request['kaina'];
        $product->description = $request['tekstas'];
        $product->photo = $request['url'];
        $product->color = $request['color'];
        $product->quantity = $request['quantity'];
        $product->save();
        $this->updateOrders($request['id']);
        return redirect()->route('viewProducts');
    }

    public function cart()
    {
        return view('cart');
    }

    public function addToCart($id)
    {
        $product = product::find($id);
        if (!$product) {
            abort(404);
        }
        $cart = session()->get('cart');
        // if cart is empty then this the first product
        if (!$cart) {
            $cart = [
                $id => [
                    "name" => $product->name,
                    "quantity" => 1,
                    "maxquantity" => $product->quantity,
                    "price" => $product->price,
                    "photo" => $product->photo
                ]
            ];
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Product added to cart successfully!');
        }
        // if cart not empty then check if this product exist then increment quantity
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Product added to cart successfully!');
        }
        // if item not exist in cart then add to cart with quantity = 1
        $cart[$id] = [
            "name" => $product->name,
            "quantity" => 1,
            "maxquantity" => $product->quantity,
            "price" => $product->price,
            "photo" => $product->photo
        ];
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function update(Request $request)
    {
        if ($request->id and $request->Quantity) {
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->Quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Cart updated successfully');
        }
        return redirect()->back();
    }

    public function remove(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
        }
        return redirect()->back();
    }

    public function buyPreke(Request $request)
    {
        $order = new Order();
        $order->status = 0;
        $order->adress = $request['adress'];
        $order->assembly = $request['assembly'];
        $order->number = $request['number'];
        $order->date = $request['date'];
        $order->cvc = $request['cvc'];
        $order->fk_user = auth()->user()->id;
        $order->save();

        foreach (session('cart') as $id => $details)
        {
            $item = new Item();
            $item->quantity = $details['quantity'];
            $item->fk_order = $order->id;
            $item->fk_product = $id;
            $product = product::find($id);
            if($product->quantity >=  $item->quantity )
            {
                $product->quantity =  $product->quantity - $item->quantity;
                $product->save();
                $item->status = 1;
            } else{
                $item->status = 0;
            }
            $item->save();
        }
        session()->forget('cart');
        return redirect()->route('viewOrders');
    }

    public function updateOrders(int $id)
    {

        $items = Item::where('fk_product',$id)->where('status','0')->get()->all();
        $product = product::find($id);
        if($product->quantity > 0)
        {
            foreach ($items as $item)
            {
                if($product->quantity >= $item->quantity)
                {
                    $product->quantity = $product->quantity - $item->quantity;
                    $item->status = 1;
                    $product->save();
                    $item->save();
                }
            }
        }
        return;
    }

    public function viewPickerPrekes(Request $request)
    {
        if($request['category'] == product::TYPE_BASE){
            $products = product::where('category',$request['category'])->get()->all();
        }
        if($request['category'] == product::TYPE_TYRE){
            $products = product::where('category',$request['category'])->get()->all();
        }
        if($request['category'] == product::TYPE_SADDLE){
            $products = product::where('category',$request['category'])->get()->all();
        }
        if($request['category'] == product::TYPE_BRAKE){
            $products = product::where('category',$request['category'])->get()->all();
        }
        if($request['category'] == product::TYPE_ACC){
            $products = product::where('category',$request['category'])->get()->all();
        }
        return view('viewPickerProducts', compact('products'));
    }

    public function addPickerPreke($id)
    {
        $product = product::find($id);
        if (!$product) {
            abort(404);
        }
        $name = $product->category;
        $cart = session()->get($name);
        // if cart is empty then this the first product
        if (!$cart) {
            $cart = [
                $id => [
                    "name" => $product->name,
                    "quantity" => 1,
                    "maxquantity" => $product->quantity,
                    "price" => $product->price,
                    "photo" => $product->photo
                ]
            ];
            session()->put($name, $cart);
            return redirect()->route('partpicker');
        }
        // if cart not empty then check if this product exist then increment quantity
        if (isset($cart[$id])) {
            return redirect()->route('partpicker');
        }
        // if item not exist in cart then add to cart with quantity = 1
        $cart[$id] = [
            "name" => $product->name,
            "quantity" => 1,
            "maxquantity" => $product->quantity,
            "price" => $product->price,
            "photo" => $product->photo
        ];
        session()->put($name, $cart);
        return redirect()->route('partpicker');
    }

    public function pickerremove(Request $request)
    {
        if ($request->id) {
            $name = $request->category;
            $cart = session()->get($name);
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put($name, $cart);
            }
        }
        return redirect()->back();
    }

    public function buyBike(Request $request)
    {
        $order = new Order();
        $order->status = 0;
        $order->adress = $request['adress'];
        $order->assembly = $request['assembly'];
        $order->number = $request['number'];
        $order->date = $request['date'];
        $order->cvc = $request['cvc'];
        $order->fk_user = auth()->user()->id;
        $order->save();

        $this->helperBuyBike(product::TYPE_BASE,$order->id);
        $this->helperBuyBike(product::TYPE_BRAKE,$order->id);
        $this->helperBuyBike(product::TYPE_SADDLE,$order->id);
        $this->helperBuyBike(product::TYPE_TYRE,$order->id);
        $this->helperBuyBike(product::TYPE_ACC,$order->id);

        return redirect()->route('viewOrders');

    }

    public function helperBuyBike($name, $order_id)
    {
        foreach (session($name) as $id => $details)
        {
            $item = new Item();
            $item->quantity = $details['quantity'];
            $item->fk_order = $order_id;
            $item->fk_product = $id;
            $product = product::find($id);
            if($product->quantity >=  $item->quantity )
            {
                $product->quantity =  $product->quantity - $item->quantity;
                $product->save();
                $item->status = 1;
            } else{
                $item->status = 0;
            }
            $item->save();
        }
        session()->forget($name);
        return;
    }
}
