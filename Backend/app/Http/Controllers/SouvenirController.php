<?php

namespace App\Http\Controllers;

use App\Souvenir;
use App\SouvenirDelivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Routing\Controller as BaseController;


class SouvenirController extends BaseController
{

    public function index()
    {
        //
        return response()->json(['data' =>  Souvenir::with('delivery')->get()], 200);
    }

    public function create(Request $request)
    {  
        
        //validate incoming request  
        try {

            $data =  Souvenir::create($request->input());  
            foreach($request->input('delivery') as $key=>$value){
                $d = array(
                    'souvenir_id' => $data->id, 
                    'delivery_id' => $value,
                );
                 
                SouvenirDelivery::create($d);
            }
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


    public function show(Souvenir $Souvenir)
    {
        //
    }

    public function edit(Request $request,$id)
    {
        $data = Souvenir::findOrFail($id);  
        if($data->fill($request->input())->save())
        { 
            SouvenirDelivery::where('souvenir_id', $id)->delete();
            foreach($request->input('delivery') as $key=>$value){
                $d = array(
                    'souvenir_id' => $id, 
                    'delivery_id' => $value,
                );
                    
                SouvenirDelivery::create($d);
            } 
          return response()->json(['data' => $data, 'message' => 'Update success'], 201);
        }else {
          return response()->json(['Error' => 'Update Error'], 500);
        }
    }


    public function update(Request $request, Souvenir $Souvenir)
    {
        //
    }


    public function destroy($id)
    {
        //
         // 
         if( Souvenir::destroy($id))
         { 
           return response()->json(['message' => 'Delete success'], 201);
         }else {
           return response()->json(['Error' => 'Update Error'], 500);
         }
    }
}
