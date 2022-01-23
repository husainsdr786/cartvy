<?php

    return [

        'http_codes' => [

            'success'       => 200,
            'validation'    => 400,
            'unauthorized'  => 401,
            'not_found'     => 404,
            'server'        => 500,
        ],

        'radius' => [

            'km' => 15,
        ],

        'currency' => [

            'symbol' => '$',
        ],

        'distance' => [

            'unit' => 'km',
        ],


        'error_messages'  => [

            'unauthorized'                  => 'Unauthorized',
            'user_type_error'               => 'Please enter valid type for User.',
            'exist_mobile'                  => 'Mobile number already registered for User.',
            'mobile_exist'                  => 'Mobile number already registered.',
            'product_not_exist'             => 'Product not exist.',
            'cartin_exist'                  => 'Already exist in cart.',
            'cart_success'                  => 'Product successfully added to cart',
            'cart_update_success'           => 'Cart updated successfully',
            'stock_not_sufficient'          => 'Stock not sufficient!.',
            'cart_delete_success'           => 'Cart successfully removed.',
            'cart_not_exist'                => 'Cart data not found.',



            'user_register_success'         => 'User registered successfully.',
            'account_suspend'               => 'Your account is currently deactivated from Admin. Please  contact for support.',
            'login_success'                 => 'Logged in successfully.',
            'product_delete_success'        => 'Product deleted successfully.',
            'verification_error'            => 'Please verify your account. An OTP sent on your email.',
            'credential_error'              => 'Invalid credentials. Please try again.',
            'email_not_exist'               => 'Email ID does not exist in our records!',
            'otp_sent'                      => 'OTP sent successfully on your email.',
            'otp_verified'                  => 'OTP verified successfully.',
            'server_error'                  => 'Something went wrong!',
            'invalid_otp'                   => 'Invalid OTP.',
            'password_reset'                => 'Password reset has been successfully done.',
            'driver_not_found'              => 'Sorry! No drivers found.',
            'profile_updated'               => 'Your profile has been updated successfully.',
            'password_updated'              => 'Your password has been changed successfully.',
            'old_password_not_match'        => 'Old Password does not match.',
            'driver_details'                => 'Sorry! Driver details not found.',
            'request_error'                 => 'Sorry! You can not send request.',
            'request_sent'                  => 'Your request has been sent successfully to the Driver & notify you shortly.',
            'new_request_title'             => 'New Request',
            'new_request_details'           => 'You have one new request from ',
            'no_request'                    => 'Sorry! No request found.',
            'no_booking'                    => 'Sorry! No booking found.',
            'driver_type_error'             => 'Please enter valid type for Driver.',
            'exist_mobile_driver'           => 'Mobile number already registered for Driver.',
            'product_register_success'      => 'Product created successfully.',
            'status_updated'                => 'Your status updated successfully.',
            'bank_details_exist_error'      => 'Sorry! You have already added your Bank details.',
            'vehicle_details_exist_error'   => 'Sorry! You have already added your Vehicle details.',
            'bank_details_saved'            => 'Your Bank details are saved successfully.',
            'bank_details_updated'          => 'Your Bank details are updated successfully.',
            'bank_details_update_error'     => 'You can not update it, it has been verified by Admin.',
            'vehicle_details_saved'         => 'Your Vehicle details are saved successfully.',
            'vehicle_details_updated'       => 'Your Vehicle details are updated successfully.',
            'vehicle_details_update_error'  => 'You can not update it, it has been verified by Admin.',
            'no_data'                       => 'Sorry! No data found.',
            'vehicle_type_error'            => 'Sorry! Vehicle type not found.',
            'fees_updated'                  => 'Your Booking and Service Fees have been updated successfully.',
            'booking_transit_error'         => 'Sorry! One of your booking is in transit.',
            'request_accepted'              => 'You have successfully accepted the request',
            'request_accepted_title'        => 'Request Accepted.',
            'request_accepted_details'      => 'Driver has approved your request.',
            'location_updated'              => 'Location updated successfully',
            'request_error'                 => 'Sorry! Request not found.',
            'request_exists'                => 'Sorry! One of your request is pending.',
            'request_rejected'              => 'You have successfully rejected the request',
            'request_rejected_title'        => 'Request Rejected.',
            'request_rejected_details'      => 'Driver has rejected your request.',
            'user_request_rejected_details' => 'User has rejected your request.',
            'ride_start'                    => 'Ride started successfully.',
            'ride_end'                      => 'Ride completed successfully.',
            'review_success'                => 'Thanks for submitting your feedback.',
            'params_error'                  => 'Parameters not correctly formed.',
            'product_not_found'             => 'Sorry! Product not found.',
            'network_not_found'             => 'Sorry! Network not found.',
            'payment_success'               => 'Success! Your payment has been done successfully.',
            'payment_failed'                => 'Failed! Your payment does not successfully done',
            'stripe_token_error'            => 'Failed! Stripe Token does not generated successfully',
            'review_error'                  => 'You have already rate for this ride',
        ],

        'credentials'   => [

            'GOOGLE_CONSOLE_KEY'    =>  env('GOOGLE_CONSOLE_KEY'),
            'FCM_SERVER_KEY'        =>  env('SERVER_KEY'),
            'PAYPAL_ACCESS_TOKEN'   =>  env('PAYPAL_SANDBOX_ACCESS_TOKEN'),
        ]

    ];


