<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{

    public function index()
    {
        //
        return response()->json(['data' =>  Customer::all()], 200);
    }


    public function create(Request $request)
    {
        try {
            // $str = '123456789abcdefgsijklmnopqrstuvwxyz';
            // $done = substr(str_shuffle($str) ,0,8);
            $password = Hash::make("123456");

            $arr = array(
                "name" => $request->input('name'),
                "surname" => $request->input('surname'),
                "email" => $request->input('email'),
                "phone" => $request->input('phone'),
                "password" => $password
            );
            $data =  Customer::create($arr);
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
        //
         // 
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
