<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function result($code , $message , $data ){
        return response()->json([
            "code"=> $code ,
            "message"=> $message ,
            "data"=>$data
        ],$code);
    }
}
