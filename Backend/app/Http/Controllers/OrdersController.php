<?php

namespace App\Http\Controllers;

use App\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OrdersController extends Controller
{

    public function index()
    {
        //
        return response()->json(['data' =>  Customer::all()], 200);
    }


    public function create(Request $request)
    {
        try {
            $arr = array(
                "price" => $request->input('priceAll'),
                "shipping" => $request->input('shippingAll'),
                "total" => $request->input('totalAll'),
                "user_id" => $request->input('userId'),
                "status" => "0",
            );

            $data =  Orders::create($arr);  
            return response()->json(['data' => $data, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'User Registration Failed!'], 409);
        }
    }


    public function store(Request $request)
    {
        //
    }

    public function show2($id){
        return response()->json(['data' =>  Orders::where('user_id',$id)->orderBy('id','desc')->with('shopsOrders')->get()], 200);
    }

    public function edit(Request $request,$id)
    {
        $data = Customer::findOrFail($id); 
        if($data->fill($request->input())->save())
        { 
          return response()->json(['data' => $data, 'message' => 'Update success'], 201);
        }else {
          return response()->json(['Error' => 'Update Error'], 500);
        }
    }


    public function update(Request $request, Customer $Customer)
    {
        //
    }

    public function destroy($id)
    {
        //
         // 
         if( Customer::destroy($id))
         { 
           return response()->json(['message' => 'Delete success'], 201);
         }else {
           return response()->json(['Error' => 'Update Error'], 500);
         }
    }

    public function getOrders($id){
        return response()->json(['data' =>  Orders::where('user_id',$id)->with('orders')->first()], 200);
    }
}
