<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;

use Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use helpers;

class CartController extends Controller
{


    protected $product=null;
    public function __construct(Product $product){
        $this->product=$product;
    }

    public function addToCart(Request $request){
        
        try{

            $validation = Validator::make($request->all(), [
                'product_id'      => 'required|numeric:min:1',               
            ]);

            if ($validation->fails()) {

                $result['code']     = config('messages.http_codes.validation');
                $result['error']    = true;
                $result['message']  = $validation->messages()->first();
                return response()->json($result);
            }

            $product = Product::where('id', $request->product_id)->first();

            if(empty($product)){

                $error['code']    = config('messages.http_codes.validation');
                $error['error']   = true;
                $error['message'] = config('messages.error_messages.product_not_exist');
                return response()->json($error);
            }

            $already_cart  = Cart::with('product')->where('user_id', auth()->user()->id)->where('order_id',null)->where('product_id', $product->id)->first();

            if(!empty($already_cart)) {

                $already_cart->quantity   = $already_cart->quantity + 1;
                $already_cart->amount     = $product->price + $already_cart->amount;
                
                if ($already_cart->product->stock < $already_cart->quantity || $already_cart->product->stock <= 0){

                    $error['code']    = config('messages.http_codes.validation');
                    $error['error']   = true;
                    $error['message'] = config('messages.error_messages.stock_not_sufficient');
                    return response()->json($error);

                } else if($already_cart->save()){

                    $result['code']     = config('messages.http_codes.success');
                    $result['error']    = false;
                    $result['message']  = config('messages.error_messages.cart_update_success');
                    return response()->json($result);
                }

            } else {
                
                $cart               = new Cart;
                $cart->user_id      = auth()->user()->id;
                $cart->product_id   = $product->id;
                $cart->price        = ($product->price-($product->price*$product->discount)/100);
                $cart->quantity     = 1;
                $cart->amount       = $cart->price*$cart->quantity;

                if ((empty($already_cart->product->stock) < (empty($already_cart->quantity))) || (empty($already_cart->product->stock) <= 0)){

                    $error['code']    = config('messages.http_codes.validation');
                    $error['error']   = true;
                    $error['message'] = config('messages.error_messages.stock_not_sufficient');
                    return response()->json($error);

                } else if($cart->save()){
                    
                    $result['code']     = config('messages.http_codes.success');
                    $result['error']    = false;
                    $result['message']  = config('messages.error_messages.cart_success');
                    return response()->json($result);
                }
            
            }

        }catch(Exception $e){

            $exception['code']    = config('messages.http_codes.server');
            $exception['error']   = true;
            $exception['message'] = config('messages.error_messages.server_error');
            return response()->json($exception);
        }
     
    } 
    
    public function cartDelete(Request $request){
       
        try{

        $cart = Cart::find($request->id);

        if (!empty($cart)) {
            $cart->delete();
            $result['code']     = config('messages.http_codes.success');
            $result['error']    = false;
            $result['message']  = config('messages.error_messages.cart_delete_success');
            return response()->json($result);
        }else {
            $error['code']    = config('messages.http_codes.validation');
            $error['error']   = true;
            $error['message'] = config('messages.error_messages.cart_not_exist');
            return response()->json($error);
        }

        }catch(Exception $e){

            $exception['code']    = config('messages.http_codes.server');
            $exception['error']   = true;
            $exception['message'] = config('messages.error_messages.server_error');
            return response()->json($exception);
        }     
    }   
}
