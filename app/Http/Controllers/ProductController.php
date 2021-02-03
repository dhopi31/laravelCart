<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction_header;
use App\Models\Transaction_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
   
    public function index()
    {
        $product = Product::all();
        return view('product.index', compact('product'));
    }
    
    public function cart()
    {
        return view('product.cart');
    }

    public function cartLive()
    {
        return view('product.cartLive');
    }

    public function addToCart($id)
    {
        $product = Product::find($id);
        if(!$product) {
            abort(404);
        }

        $cart = session()->get('cart');

        if(!$cart) {
            $cart = [
                    $id => [
                        "name" => $product->name,
                        "quantity" => 1,
                        "price" => $product->price,
                        "photo" => $product->photo
                    ]
            ];
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Product added to cart successfully!');
        }

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'The Same Product added to cart successfully!');
        }

         // if item not exist in cart then add to cart with quantity = 1
         $cart[$id] = [
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price,
            "photo" => $product->photo
        ];

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function update(Request $request)
    {
        if($request->id and $request->quantity)
        {
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Cart updated successfully');
        }
    }

    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Product removed successfully');
        }
    }

    public function checkOut(Request $request)
    {   
        $jml_item = count($request->item_code);

        if(empty(Transaction_header::all()->toArray())){
            $trans_code = 'TRANS'.'/'.Now()->year.'/0001';
        }
        else
        {
            $max_id = Transaction_header::max('trans_code');
            $code = Str::substr($max_id, 11);
            $code_cont = $code+1;
            $gen_code = str_pad($code_cont, 4, '0', STR_PAD_LEFT);
            $trans_code = 'TRANS'.'/'.Now()->year.'/'.$gen_code;
        }
            
        Transaction_header::create([
                'trans_code' => $trans_code,
                'user_id' => Auth::id(),
                'total' => $request->total,
        ]);
        for ($i=0; $i < $jml_item; $i++) { 
            Transaction_detail::create([
                    'trans_code' => $trans_code,
                    'item_id' => $request->item_code[$i],
                    'quantity' => $request->qty[$i],
            ]);
            $cart = session()->get('cart');
            if(isset($cart[$request->item_code[$i]])) {
                unset($cart[$request->item_code[$i]]);
                session()->put('cart', $cart);
            }
        }
        session()->flash('success', 'Product confirm successfully');
        return redirect('/product');
    }

}
