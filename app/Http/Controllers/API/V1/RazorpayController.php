<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Exception;
use \Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Razorpay\Api\Api;
use App\Models\Payment;
use Session;

class RazorpayController extends Controller
{
    public function payment(Request $request)
    {     
        try {
    
        $validation = Validator::make($request->all(), [

            'product_id'           => 'required',
            'order_id'             => 'required',
            'razorpay_payment_id'  => 'required'
        ]);

        if ($validation->fails()) {

            $result['code']     = config('messages.http_codes.validation');
            $result['error']    = true;
            $result['message']  = $validation->messages()->first();
            return response()->json($result);
        }

        $input   = $request->all();        
        $api     = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));
        $payment = $api->payment->fetch($input['razorpay_payment_id']);

        if(count($input)  && !empty($input['razorpay_payment_id'])) {
            try  {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount'])); 

            } catch (\Exception $e) {
                $exception['code']     = config('messages.http_codes.server');
                $exception['error']    = true;
                #$exception['message'] = $e->getMessage();
                $exception['message']  = config('messages.error_messages.payment_failed');
                return response()->json($exception);
            }            
        }

        $user = auth()->user();

        $payInfo = [
            'payment_id'    => $payment->razorpay_payment_id,
            'order_id'      => "ORD-".$request->order_id,
            'user_id'       => $user->id,
            'amount'        => $request->amount,
            'email'         => $request->email,
            'total_amount'  => $request->amount,
            'quantity'      => $request->quantity,
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'country'       => $request->country,
            'post_code'     => $request->post_code,
            'address1'      => $request->address1,
            'address2'      => $request->address2,
            'phone'         => $request->phone
        ];
        
        $PaymentRes = Payment::insertGetId($payInfo);  
        return response()->json([
            'code' => config('messages.http_codes.success'),
            'error' => false,
            'message'=> config('messages.error_messages.payment_success'),
            'PaymentResult' => $PaymentRes
        ]);


    }catch (Exception $e){
    
        $exception['code'] = config('messages.http_codes.server');
        $exception['error'] = true;
        $exception['message'] = config('messages.error_messages.server_error');
        return response()->json($exception);
    }

    }
}
