<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\FoodItem;
use App\Order;
use Illuminate\Support\Facades\Hash;
use Auth;
class NormalController extends Controller
{
    public function register(Request $request){
        $validated = $request->validate([
            'email'=>'email|required|unique:users',
            'password'=>'required|confirmed'
        ]);
        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);


        $token = $user->createToken('auth')->accessToken;
        return response(['user'=>$user, 'token'=>$token]);
    }

    public function login(Request $request){
        $loginData = $request->validate([
            'email'=>'email|required',
            'password'=>'required'
        ]);
        //return $loginData;
        //$userdata = array('username'=> $request->username, 'password' => $request->password);

        $user = User::where('email', $loginData['email'])->first();
        if ($user){
                if (Hash::check($request->password, $user->password)){
                    $token = $user->createToken('auth',['be_shoppers'])->accessToken;
                    return response(['user'=>$user, "token"=>$token]);
                }
        }

        return response()->json(['error' => 'wrong details'], 500);


    }

    public function get(Request $request){
        return FoodItem::all();
    }

    public function points(Request $request){
        $user = User::find($request->id);

        $user->points = $user->points + $request->change;
        $user->save();
        return response($user->points);
    }

    public function order(Request $request){
        $validate = $request->validate([
            'items' => 'required',
        ]);

        foreach ($validate['items'] as $order){
            try{
            Order::create($order);
            } catch (\Exception $e){
                return "Invalid item";
            }
        }
        return "Sucess";
    }

    public function getOrders(User $user){
        return Order::where('user_id', $user->id)->get();
    }

}
