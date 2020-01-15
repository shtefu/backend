<?php
namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin;
use App\FoodItem;
use App\Order;
use Illuminate\Support\Facades\Hash;
use Auth;
class AdminController extends Controller
{
    public function register(Request $request){
        $validated = $request->validate([
            'email'=>'email|required|unique:admins',
            'password'=>'required|confirmed'
        ]);
        $validated['password'] = Hash::make($validated['password']);
        $user = Admin::create($validated);


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

        $user = Admin::where('email', $loginData['email'])->first();
        if ($user){
                if (Hash::check($request->password, $user->password)){
                    $token = $user->createToken('auth',['be_shoppers'])->accessToken;
                    return response(['user'=>$user, "token"=>$token]);
                }
        }

        return response()->json(['error' => 'wrong details'], 500);
    }

    public function getFoodItems(){
        return FoodItem::all();
    }

    public function getOrders(){
        return Order::orderBy('fooditem_id', 'desc')->get();
    }

    public function addFoodItem(Request $request){
        $validate = $request->validate([
            'img_url' => 'required',
            'price' => 'required',
            'name' => 'required'
        ]);

        $newItem = FoodItem::create($validate);
        return response($newItem);
    }

    public function deleteFoodItem($id){
        FoodItem::destroy($id);
        return "Success";
    }

    public function newMenu(Request $request){
        $validate = $request->validate([
            'items' => 'required'
        ]);
        FoodItem::truncate(); //Deletes all rows

        foreach ($validate->items as $item){
            try{
                FoodItem::create($item);
                } catch (\Exception $e){
                    return "Invalid item";
                }

        }
        return response(FoodItem::all());
    }
}
