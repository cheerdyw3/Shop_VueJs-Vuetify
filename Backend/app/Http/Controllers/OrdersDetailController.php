<?php

namespace App\Http\Controllers;

use App\OrdersDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OrdersDetailController extends Controller
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
                "discount" => $request->input('discount'),
                "totalPrice" => $request->input('totalPrice'),
                "deliveryId" => $request->input('deliveryId'),
                "deliveryName" => $request->input('deliveryName'),
                "deliveryPrice" => $request->input('deliveryPrice'),
                "description" => $request->input('description'),
                "name" => $request->input('name'),
                "price" => $request->input('price'),
                "image" => $request->input('image'),
                "souvenir_group_id" => $request->input('souvenir_group_id'),
                "unit_id" => $request->input('unit_id'),
                "weight" => $request->input('weight'),
                "member_id" => $request->input('member_id'),
                "amount" => $request->input('amount'),
                "order_id" => $request->input('ordersId')
            );

            $data =  OrdersDetail::create($arr);
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

    // public function ordersMember($id){
    //     return response()->json(['data' =>  OrdersDetail::where('member_id',$id)->orderBy('id','desc')->get()], 200);
    // }

    public function show($id)
    {
        return response()->json(['data' =>  Customer::where('id',$id)->with('customer')->first()], 200);
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

         if( Customer::destroy($id))
         { 
           return response()->json(['message' => 'Delete success'], 201);
         }else {
           return response()->json(['Error' => 'Update Error'], 500);
         }
    }

    public function Login(Request $request)
    {
        try {
            $check = customer::where('email', $request->input('email'))->first();
            if(!empty($check) && Hash::check($request->input('password'), $check->password)) {
                return response()->json(['data' => $check, 'message' => 'LOGIN SUCCESS'], 201);
            }else {
                return response()->json(['message' => 'Username or password is incorrect'], 201);
            }
        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'User Registration Failed!'], 409);
        }


        
    }
}
