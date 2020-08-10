<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Region;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Routing\Controller as BaseController;

class RegionController extends BaseController
{

    public function index()
    {
        //
        return response()->json(['data' =>  Region::all()], 200);
    }


    public function create(Request $request)
    {
        $request =  json_decode($request->getContent(), true);
        //validate incoming request
        try {

           $data =  Region::create($request);
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


    public function show()
    {
        //
        return response()->json(['data' =>  Region::with('member')->get()], 200);

    }


    public function edit(Request $request,$id)
    {
        $request =  json_decode($request->getContent(), true);
        $data = Region::findOrFail($id);
        if($data->fill($request)->save())
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
         if(Region::destroy($id))
         {
           return response()->json(['message' => 'Delete success'], 201);
         }else {
           return response()->json(['Error' => 'Update Error'], 500);
         }
    }
}
