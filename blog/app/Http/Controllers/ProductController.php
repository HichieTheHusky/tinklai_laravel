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
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function createPreke(Request $request)
    {
        $request->validate([
            'pavadinimas' => ['required', 'string', 'max:255'],
            'tekstas' => ['required', 'string', 'max:255'],
            'url' => ['required', 'url', 'string', 'max:255'],
            'color' => ['required', 'string', 'max:255'],
            'kaina' => ['required', 'numeric','regex:/^\d+(\.\d{1,2})?$/'],
            'quantity' => ['required', 'numeric'],
        ],
        [
            'pavadinimas.required' => 'Pavadinimas turi būti įvestas',
            'pavadinimas.max' => 'Pavadinimas turi būti iki 255 simbolių',
            'tekstas.required' => 'Aprašymas turi būti įvestas',
            'tekstas.max' => 'Aprašymas turi būti iki 255 simbolių',
            'url.required' => 'Nuotraukos adresas turi būti įvestas',
            'url.max' => 'Nuotraukos adresas turi būti iki 255 simbolių',
            'url.url' => 'Nuotrauka turi buti korektiškas adresas',
            'color.required' => 'Spalva turi būti įvestas',
            'kaina.required' => 'Kaina turi būti įvestas',
            'kaina.regex' => 'Kaina įvesta buvo nekorektiška, iveskite taip skaicius.skaicius, arba skaicius',
            'quantity.required' => 'Kiekis turi būti įvestas',
        ]);


        $product = new product();
        $product->name = $request['pavadinimas'];
        $product->price = $request['kaina'];
        $product->category = $request['kategory'];
        $product->description = $request['tekstas'];
        $product->photo = $request['url'];
        $product->color = $request['color'];
        $product->quantity = $request['quantity'];

        if ($request['kategory'] == product::TYPE_ACC) {
            $request->validate([
                'type' => ['required', 'string', 'max:255'],
                'materials' => ['required', 'string', 'max:255'],
            ],
            [
                'type.required' => 'Tipas turi būti įvestas',
                'materials.required' => 'Medžiaga turi būti įvestas',
            ]);

            $type_product = new accessory();
            $type_product->type = $request['type'];
            $type_product->materials = $request['material'];
            $type_product->save();
            $product->fk_acc = $type_product->getAttribute('id');
        }

        if ($request['kategory'] == product::TYPE_BASE) {

            $request->validate([
                'usecase' => ['required', 'string', 'max:255'],
                'material' => ['required', 'string', 'max:255'],
                'weight' => ['required', 'numeric'],
            ],
            [
                'usecase.required' => 'Tipas turi būti įvestas',
                'material.required' => 'Medžiaga turi būti įvestas',
                'weight.required' => 'Svoris turi būti įvestas',
                'weight.numeric' => 'Svoris turi būti skaičius',
            ]);

            $type_product = new base();
            $type_product->usecase = $request['usecase'];
            $type_product->weight = $request['weight'];
            $type_product->material = $request['material'];
            $type_product->save();
            $product->fk_base = $type_product->getAttribute('id');
        }

        if ($request['kategory'] == product::TYPE_BRAKE) {
            $request->validate([
                'type' => ['required', 'string', 'max:255'],
                'material' => ['required', 'string', 'max:255'],
            ],
                [
                    'type.required' => 'Tipas turi būti įvestas',
                    'material.required' => 'Medžiaga turi būti įvestas',
                ]);
            $type_product = new brake();
            $type_product->type = $request['type'];
            $type_product->material = $request['material'];
            $type_product->save();
            $product->fk_break = $type_product->getAttribute('id');
        }

        if ($request['kategory'] == product::TYPE_SADDLE) {
            $request->validate([
                'size' => ['required', 'string', 'max:255'],
                'weight' => ['required', 'numeric'],
                'maxweight' => ['required', 'numeric'],
            ],
                [
                    'size.required' => 'Dydis turi būti įvestas',
                    'weight.required' => 'Svoris turi būti įvestas',
                    'weight.numeric' => 'Svoris turi būti skaičius',
                    'maxweight.required' => 'Maksimalus svoris turi būti įvestas',
                    'maxweight.numeric' => 'Maksimalus svoris turi būti skaičius',
                ]);

            $type_product = new saddle();
            $type_product->size = $request['size'];
            $type_product->weight = $request['weight'];
            $type_product->maxload = $request['maxweight'];
            $type_product->save();
            $product->fk_saddle = $type_product->getAttribute('id');
        }

        if ($request['kategory'] == product::TYPE_TYRE) {
            $request->validate([
                'size' => ['required', 'string', 'max:255'],
                'weight' => ['required', 'numeric'],
                'maxweight' => ['required', 'numeric'],
            ],
                [
                    'size.required' => 'Dydis turi būti įvestas',
                    'weight.required' => 'Svoris turi būti įvestas',
                    'weight.numeric' => 'Svoris turi būti skaičius',
                    'maxweight.required' => 'Maksimalus svoris turi būti įvestas',
                    'maxweight.numeric' => 'Maksimalus svoris turi būti skaičius',
                ]);
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

    public function viewPreke(Request $request)
    {
        $product = product::find($request['id']);
        if($product->category == product::TYPE_BASE){
            $specific_product = base::find($product->fk_base);
        }
        if($product->category == product::TYPE_BRAKE){
            $specific_product = brake::find($product->fk_break);
        }
        if($product->category == product::TYPE_SADDLE){
            $specific_product = saddle::find($product->fk_saddle);
        }
        if($product->category == product::TYPE_TYRE){
            $specific_product = tyre::find($product->fk_tyres);
        }
        if($product->category == product::TYPE_ACC){
            $specific_product = accessory::find($product->fk_acc);
        }
        return view('viewProduct', compact('product','specific_product'));
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
        $validator = Validator::make($request->all(),
        [
            'quantity' => ['required', 'numeric'],
        ],
        [
            'quantity.required' => 'Kiekis turi būti įvestas',
            'quantity.numeric' => 'Kiekis turi būti skaičius',
        ]);
        if ($validator->fails()) {
            $product = product::find($request['id']);
            return view('updatePreke', compact('product'))
                ->withErrors($validator);
        }

        $product = product::find($request['id']);
        $product->quantity = $product->quantity + $request['quantity'];
        $product->save();
        $this->updateOrders($request['id']);
        return redirect()->route('viewProducts');
    }

    public function updatePreke(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
            'pavadinimas' => ['required', 'string', 'max:255'],
            'tekstas' => ['required', 'string', 'max:255'],
            'url' => ['required', 'url', 'string', 'max:255'],
            'color' => ['required', 'string', 'max:255'],
            'kaina' => ['required', 'numeric','regex:/^\d+(\.\d{1,2})?$/'],
            'quantity' => ['required', 'numeric'],
            ],
            [
            'pavadinimas.required' => 'Pavadinimas turi būti įvestas',
            'pavadinimas.max' => 'Pavadinimas turi būti iki 255 simbolių',
            'tekstas.required' => 'Aprašymas turi būti įvestas',
            'tekstas.max' => 'Aprašymas turi būti iki 255 simbolių',
            'url.required' => 'Nuotraukos adresas turi būti įvestas',
            'url.max' => 'Nuotraukos adresas turi būti iki 255 simbolių',
            'url.url' => 'Nuotrauka turi buti korektiškas adresas',
            'color.required' => 'Spalva turi būti įvestas',
            'kaina.required' => 'Kaina turi būti įvestas',
            'kaina.regex' => 'Kaina įvesta buvo nekorektiška, iveskite taip skaicius.skaicius, arba skaicius',
            'quantity.required' => 'Kiekis turi būti įvestas',
            ]);

        if ($validator->fails()) {
            $product = product::find($request['id']);
            return view('updatePreke', compact('product'))->withErrors($validator);
        }

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

        $request->validate([
            'adress' => ['required', 'string', 'max:255'],
            'number' => ['required', 'string', 'min:16', 'max:16'],
            'date' => ['required', 'string', 'min:5', 'max:5'],
            'cvc' => ['required', 'string', 'min:3', 'max:3'],
        ],
        [
            'adress.required' => 'Adresas turi būti įvestas',
            'adress.max' => 'Adresas turi būti iki 255 simbolių',
            'number.required' => 'Numeris turi būti įvestas',
            'number.max' => 'Numeris turi būti 16 simbolų',
            'number.min' => 'Numeris turi būti 16 simbolų',
            'date.required' => 'Data turi būti įvesta',
            'date.max' => 'Data turi būti 5 simboliau tokiu formatu "12/30"',
            'date.min' => 'Data turi būti 5 simboliau tokiu formatu "12/30"',
            'cvc.required' => 'CVC turi būti įvestas',
            'cvc.max' => 'CVC turi būti iš 3 simboliu',
            'cvc.min' => 'CVC turi būti iš 3 simboliu',
        ]);


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
        $request->validate([
            'adress' => ['required', 'string', 'max:255'],
            'number' => ['required', 'string', 'min:16', 'max:16'],
            'date' => ['required', 'string', 'min:5', 'max:5'],
            'cvc' => ['required', 'string', 'min:3', 'max:3'],
        ],
        [
            'adress.required' => 'Adresas turi būti įvestas',
            'adress.max' => 'Adresas turi būti iki 255 simbolių',
            'number.required' => 'Numeris turi būti įvestas',
            'number.max' => 'Numeris turi būti 16 simbolų',
            'number.min' => 'Numeris turi būti 16 simbolų',
            'date.required' => 'Data turi būti įvesta',
            'date.max' => 'Data turi būti 5 simboliau tokiu formatu "12/30"',
            'date.min' => 'Data turi būti 5 simboliau tokiu formatu "12/30"',
            'cvc.required' => 'CVC turi būti įvestas',
            'cvc.max' => 'CVC turi būti iš 3 simboliu',
            'cvc.min' => 'CVC turi būti iš 3 simboliu',
        ]);


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
