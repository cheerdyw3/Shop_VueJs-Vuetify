<?php

namespace App\Http\Controllers;

use App\ShopsOrders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ShopsOrdersController extends Controller
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
                "shop_id" => $request->input('id'),
                "order_id" => $request->input('ordersId'),
                "ordersDetail_id" => $request->input('ordersDetailId'),
                "discount" => $request->input('discount'),
                "price" => $request->input('price'),
                "shipping" => $request->input('shipping'),
                "total" => $request->input('total'),
                "delivery_code" => '',
                "orderStatus" => 0,
                "deliveryNameAddress" => $request->input('deliveryNameAddress'),
                "deliveryAddress" => $request->input('deliveryAddress'),
                "deliveryId" => $request->input('deliveryId'),
                "deliveryName" => $request->input('deliveryName'),
                "deliveryPrice" => $request->input('deliveryPrice')
            );
            $data =  ShopsOrders::create($arr);  
            return response()->json(['data' => $data, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'User Registration Failed!'], 409);
        }
    }

    public function show($id,$status)
    {
        return response()->json(['data' =>  ShopsOrders::where('shop_id',$id)->where('orderStatus',$status)->with('ordersDetail')->get()], 200);
    }


    public function edit(Request $request,$id)
    {
        $data = ShopsOrders::findOrFail($id); 
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

}
