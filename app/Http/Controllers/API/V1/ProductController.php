<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        try{

            $user = auth()->user()->parent_id;
            if($user == 0){
               return  $products = Product::with('pimages')->get();
            }else {
                $products = Product::with('pimages')->where('user_id','=',auth()->user()->id)->get();
            }

            if (isset($products)) {

                $result['code'] = config('messages.http_codes.success');
                $result['error'] = false;
                $result['productList'] = $products;
                return response()->json($result);

            } else {

                $result['code'] = config('messages.http_codes.not_found');
                $result['error'] = true;
                $result['message'] = config('messages.error_messages.product_not_found');
                return response()->json($result);
            }


        }catch (Exception $e){

            $exception['code'] = config('messages.http_codes.server');
            $exception['error'] = true;
            $exception['message'] = config('messages.error_messages.server_error');
            //$exception['message'] = $e->getMessage();
            return response()->json($exception);
        }

    }

     /* ==== not in use ==== */
    /* public function getByID(Request $request, $id){
        try{

           
           
            $product = Product::where('id','=',$id)->get();
            

            if (isset($product)) {

                $result['code'] = config('messages.http_codes.success');
                $result['error'] = false;
                $result['productList'] = $product;
                return response()->json($result);

            } else {

                $result['code'] = config('messages.http_codes.not_found');
                $result['error'] = true;
                $result['message'] = config('messages.error_messages.product_not_found');
                return response()->json($result);
            }


        }catch (Exception $e){

            $exception['code'] = config('messages.http_codes.server');
            $exception['error'] = true;
            $exception['message'] = config('messages.error_messages.server_error');
            //$exception['message'] = $e->getMessage();
            return response()->json($exception);
        }
    } */
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     /**
     * Add Product API
     */

    public function addProduct(Request $request){
        
        try{

            $validation = Validator::make($request->all(), [
                'name'             => 'required|string',
                'price'            => 'required|numeric',
                'description'      => 'required|string',
                'category_id'      => 'required|numeric|min:1',
                'offer'            => 'required|numeric',
                'photos'           => 'required'
            ]);

            if ($validation->fails()) {

                $result['code']     = config('messages.http_codes.validation');
                $result['error']    = true;
                $result['message']  = $validation->messages()->first();
                return response()->json($result);
            } 

        
        $product = Product::create([
            'name'                => $request->name,
            'price'               => $request->price,
            'description'         => $request->description,
            'offer'               => $request->offer,
            'category_id'         => $request->category_id,
            'user_id'             => auth()->user()->id,
            'status'              => $request->status
        ]);
    
        /* ====
        **
        ** Product Image Uploading *
        ======*/
        
        $image = array();
        if($file = $request->file('photos')){
        try{
            foreach($file as $file){
                $image_name = md5(rand(1000,10000));
                $ext = strtolower($file->getClientOriginalExtension());
                $image_full_name = $image_name.'.'.$ext;
                $uploade_path = public_path().'/product_images';
                $image_url = $uploade_path.$image_full_name;
                $file->move($uploade_path,$image_full_name);
                $image[] = $image_url;

                ProductImage::create([
                    'product_image' =>$image_full_name,
                    'product_image_name' => config('app.url')."public/product_images".$image_full_name,
                    'product_id' => $product->id,
                    'user_id' => auth()->user()->id
                ]); 
            }
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        } 

        }

        return response()->json([

            'code' => config('messages.http_codes.success'),
            'error' => false,
            'message'=> config('messages.error_messages.product_register_success'),
            'ProductResult' => $product
        ]);

        }catch(Exception $e){

            $exception['code'] = config('messages.http_codes.server');
            $exception['error'] = true;
            $exception['message'] = config('messages.error_messages.server_error');
            //$exception['message'] = $e->getMessage();
            return response()->json($exception);
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request){

    try {

        $validation = Validator::make($request->all(), [
            'productid'  => 'required|numeric'
        ]);

        if ($validation->fails()) {

            $result['code']     = config('messages.http_codes.validation');
            $result['error']    = true;
            $result['message']  = $validation->messages()->first();
            return response()->json($result);
        }

        $product = Product::find($request->productid);

        if (isset($product)) {
            $product->delete();
            $result['code'] = config('messages.http_codes.success');
            $result['error'] = false;
            $result['message'] = config('messages.error_messages.product_delete_success');
            return response()->json($result);

        } else {

            $result['code'] = config('messages.http_codes.not_found');
            $result['error'] = true;
            $result['message'] = config('messages.error_messages.product_not_found');
            return response()->json($result);
        }


    }catch (Exception $e){

        $exception['code'] = config('messages.http_codes.server');
        $exception['error'] = true;
        $exception['message'] = config('messages.error_messages.server_error');
        return response()->json($exception);
    }

    }

     /* ==== not in use === */
  /*   public function addProduct(Request $request){
        
        try{

            $validation = Validator::make($request->all(), [
                'name'             => 'required|string',
                'price'            => 'required|numeric',
                'description'      => 'required|string',
                'category_id'      => 'required||numeric|min:1',
                'product_image'    => 'required|mimes:jpg,jpeg,gif,png'
            ]);

            if ($validation->fails()) {

                $result['code']     = config('messages.http_codes.validation');
                $result['error']    = true;
                $result['message']  = $validation->messages()->first();
                return response()->json($result);
            }

            //return $user = auth()->user();    

            if ($request->hasFile('product_image')) {

                try {

                    $product_image         = $request->file('product_image'); 
                    $fileExtension         = preg_replace('/\s+/', '', $product_image->getClientOriginalName());
                    $file                  = pathinfo($fileExtension, PATHINFO_FILENAME); 
                    $extension             = $request->file('product_image')->getClientOriginalExtension(); 
                    $fileStore             = $file . '_' . time() . '.' . $extension;
                    $request->file('product_image')->move(public_path("product_images/"),$fileStore);
                    $path['product_image']      = env('APP_URL') . "public/product_images/".$fileStore;
                    $path['product_image_name'] = $fileStore;

                } catch (Exception $e) {

                    $exception['code'] = config('messages.http_codes.server');
                    $exception['error'] = true;
                    $exception['message'] = config('messages.error_messages.server_error');
                    return response()->json($exception);
                }
            }


            $product = Product::create([
                'name'                => $request->name,
                'price'               => $request->price,
                'description'         => $request->description,
                'category_id'         => $request->category_id,
                'user_id'             => auth()->user()->id,
                'product_image'       => $path['product_image'],
                'product_image_name'  => $path['product_image_name'],
                'status'              => $request->status
            ]);


            return response()->json([

                'code' => config('messages.http_codes.success'),
                'error' => false,
                'message'=> config('messages.error_messages.product_register_success'),
                'ProductResult' => $product
            ]);

        }catch(Exception $e){

            $exception['code'] = config('messages.http_codes.server');
            $exception['error'] = true;
            $exception['message'] = config('messages.error_messages.server_error');
            //$exception['message'] = $e->getMessage();
            return response()->json($exception);
        }
    }
 */


    /* ====
    **
    ** Product Find By ID *
    **
    ======*/

    public function getProductById(Request $request){

        try {
    
            $validation = Validator::make($request->all(), [
                'productid'  => 'required|numeric'
            ]);
    
            if ($validation->fails()) {
    
                $result['code']     = config('messages.http_codes.validation');
                $result['error']    = true;
                $result['message']  = $validation->messages()->first();
                return response()->json($result);
            }
    
            $product = Product::with('pimages')->find($request->productid);
    
            if (isset($product)) {
            
                $result['code'] = config('messages.http_codes.success');
                $result['error'] = false;
                $result['productList'] = $product;
                return response()->json($result);
    
            } else {
    
                $result['code'] = config('messages.http_codes.not_found');
                $result['error'] = true;
                $result['message'] = config('messages.error_messages.product_not_found');
                return response()->json($result);
            }
    
    
        }catch (Exception $e){
    
            $exception['code'] = config('messages.http_codes.server');
            $exception['error'] = true;
            $exception['message'] = config('messages.error_messages.server_error');
            return response()->json($exception);
        }
    
        }

}
