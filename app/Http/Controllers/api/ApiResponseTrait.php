<?php


namespace App\Http\Controllers\Api;


use Dotenv\Validator;

trait ApiResponseTrait{

    public $paginateNumber = 10 ;

    public function apiResponse($data=null,$error=null,$code=200)
    {

        $array = [

            'data' => $data,
            'status' => in_array($code,$this->successCode()) ? true : false,
            'error' => $error

        ];

        return response($array,$code);
    }

    public function successCode(){

        return [
            200,201,202
        ];
    }

    public function notFoundResponse(){

        return $this->apiResponse(null,'error not found',404);
    }

    public function apiValidation($request,$array){

        $validate = Validator::make($request->all(),$array);

        if ($validate->fails){

            return $this->apiResponse(null,$validate->errors(),422);
        }

    }
}
