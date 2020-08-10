<?php

namespace App\Http\Controllers;

use App\Weight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Routing\Controller as BaseController;


class WeightController extends BaseController
{
    public function index($did)
    {
        // dd(Weight::where('delivery_id',$did)->get());
        return response()->json(['data' =>  Weight::where('delivery_id', $did)->get()], 200);
    }

    public function create(Request $request)
    {
        //
        //validate incoming request  
        try {

            $data =  Weight::create($request->input());
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

    public function show(Weight $Weight)
    {
        //
    }

    public function edit(Request $request, $id)
    {
        $data = Weight::findOrFail($id);
        if ($data->fill($request->input())->save()) {
            return response()->json(['data' => $data, 'message' => 'Update success'], 201);
        } else {
            return response()->json(['Error' => 'Update Error'], 500);
        }
    }

    public function update(Request $request, Weight $Weight)
    {
        //
    }

    public function destroy($id)
    {
        //
        // 
        if (Weight::destroy($id)) {
            return response()->json(['message' => 'Delete success'], 201);
        } else {
            return response()->json(['Error' => 'Update Error'], 500);
        }
    }
}
