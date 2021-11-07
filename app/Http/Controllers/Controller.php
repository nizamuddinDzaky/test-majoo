<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function base_response($is_success, $code, $messages, $data = null, $header_token = "", $title = FALSE){
        return response()->json([
            'success' => $is_success,
            'code'  => $code,
            "message" => $messages,
            'title'=> $title,
            "data" => $data
        ])->withHeaders([
            'Content-Type' => "JSON",
            'Header-Token' => $header_token,
        ]);
    }

    public function failed_response($data, $title=FALSE)
    {
        $message = json_decode($data);
        if(!is_object($message)){
            $message = $data;
        }

        return $this->base_response(FALSE, 500,$message, null, null, $title); 
    }

    public function success_response($messages, $data, $data_header_token = [])
    {
        $header_token = hash_hmac('sha256',json_encode(array_keys($data_header_token)), '123');
        return $this->base_response(TRUE, 200, $messages, $data, $header_token);
    }
    
    public function view($view, $data= [])
    {
        $_data = [];
        foreach($data as $d){
            $_data[$d] = $this->{$d};
        }
        
        return view($view, $_data);
    }
}
