<?php

namespace App\Http\Controllers;

use App\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    public function index()
    {
        //
        return response()->json(['data' =>  Member::all()], 200);
    }

    public function create(Request $request)
    {
        //
        //validate incoming request  
        try {

            $data =  Member::create($request->input());  
            //return successful response
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
        return response()->json(['data' =>  Member::where('id',$id)->with('souvenir')->with('delivery')->first()], 200);
    }


    public function edit(Request $request,$id)
    {
        $data = Member::findOrFail($id); 
        if($data->fill($request->input())->save())
        { 
          return response()->json(['data' => $data, 'message' => 'Update success'], 201);
        }else {
          return response()->json(['Error' => 'Update Error'], 500);
        }
    }


    public function update(Request $request, Member $member)
    {
        //
    }

    public function destroy($id)
    {
        //
         // 
         if( Member::destroy($id))
         { 
           return response()->json(['message' => 'Delete success'], 201);
         }else {
           return response()->json(['Error' => 'Update Error'], 500);
         }
    }

    public function Login(Request $request)
    {
        try {
            $check = Member::where('email', $request->input('email'))->first();
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
