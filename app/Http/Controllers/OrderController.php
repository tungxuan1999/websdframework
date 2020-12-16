<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use DB;

class OrderController extends Controller
{
    public function ShowMessage($mess) {
        return "<div class='alert alert-danger'>$mess</div>";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $orders = DB::table('orders')->get();
        return view('order.list',  ['orders' => $orders]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $orders = DB::table('orders')->where('id',$id)->first();
        if($orders)
        {
            $users = DB::table('users')->where('id',$orders->user_id)->first();
            $user = array($users->name,$users->email);
            $orders_products = DB::table('order_product')->where('order_id',$orders->id)->get();
            $products = DB::table('products')->get();
            return view('order/show', ['orders'=> $orders, 'user'=> $user, 'products' => $products, 'orders_products'=>$orders_products]);
        }
        else
            return view('errors/404');
    }

    public function postBuyItem(Request $request)
    {
        if(strlen($request->input('type'))>0)
        {
            switch($request->input('type'))
            {
                case "Update":{
                    $id = $request->input('id');
                    $order_id = $request->input('order_id');
                    $product_id = $request->input('product_id');
                    if(strlen($order_id) != 0 && strlen($product_id) != 0 && strlen($id) != 0)
                    {
                        $orders_products = DB::table('order_product')->where('order_id',"$order_id")->where('product_id',"$product_id")->first();
                        if(!$orders_products)
                        {
                            date_default_timezone_set("Asia/Ho_Chi_Minh");
                            $date_update = date("Y-m-d H:i:s");
                            $affected = DB::table('order_product')
                                ->where('id', "$id")
                                ->update([
                                            'product_id' =>  $request->input('product_id'),
                                            'updated_at' => $date_update
                                    ]);
                            if($affected)
                            {
                                $notification = 'Update success';
                            }
                            else{
                                $notification = 'Update fail';
                            }
                        }
                        else{
                            $notification = "Update fail, you already have to it";
                        }
                    }
                    else {
                        $notification = "Update fail";
                    }
                    
                    return response()->json(['msg'=>$notification]);
                }break;
                case "Add":
                {
                    $order_id = $request->input('order_id');
                    $product_id = $request->input('product_id');
                    if(strlen($order_id) != 0 && strlen($product_id) != 0)
                    {
                        $orders_products = DB::table('order_product')->where('order_id',"$order_id")->where('product_id',"$product_id")->first();
                        if(!$orders_products)
                        {
                            date_default_timezone_set("Asia/Ho_Chi_Minh");
                            $date_update = date("Y-m-d H:i:s");
                            $affected = DB::table('order_product')
                                ->insert([
                                            'order_id' =>  $request->input('order_id'),
                                            'product_id' =>  $request->input('product_id'),
                                            'updated_at' => $date_update,
                                            'created_at' => $date_update
                                    ]);
                            if($affected)
                            {
                                $notification = 'Add success';
                            }
                            else{
                                $notification = 'Add fail';
                            }
                        }
                        else{
                            $notification = "Add fail, you already have to it";
                        }
                    }
                    else {
                        $notification = "Add fail";
                    }
                    
                    return response()->json(['msg'=>$notification]);
                }break;
                case "Delete":
                {
                    $id = $request->input('id');
                    if(strlen($id) != 0)
                    {
                        $orders_products = DB::table('order_product')->where('id',"$id");
                        if($orders_products->first())
                        {
                            $orders_products->delete();
                            if($orders_products)
                            {
                                $notification = 'Delete success';
                            }
                            else{
                                $notification = 'Delete fail';
                            }
                        }
                        else{
                            $notification = "Delete fail, don't find it";
                        }
                    }
                    else {
                        $notification = "Delete fail";
                    }
                    
                    return response()->json(['msg'=>$notification]);
                }break;
                default:{
                    return response()->json(['msg'=>"Error server"]);
                }
            }
        }
        else return response()->json(['msg'=>"Error server"]);
    }
    
    public function postOrder(Request $request)
    {
        switch($request->input('type'))
            {
                case "update":{
                    $notification = $this->checkNull($request);
                    if($notification == "")
                    {
                        $idd = $request->input('id');
                        $profile = DB::table('orders')->find($idd);
                        if($profile)
                        {
                            $user_id = $request->input('user_id');
                            $user = DB::table('users')->where('id',"$user_id");
                            if($user->first())
                            {
                                date_default_timezone_set("Asia/Ho_Chi_Minh");
                                $date_update = date("Y-m-d H:i:s");
                                $affected = DB::table('orders')
                                    ->where('id', $idd)
                                    ->update(['user_id' =>  $request->input('user_id'),
                                                'title' =>  $request->input('title'),
                                                'body' =>  $request->input('body'),
                                                'status' =>  $request->input('status'),
                                                'updated_at' => $date_update
                                        ]);
                                if($affected)
                                {
                                    $notification = ('Update success');
                                }
                                else{
                                    $notification = ('Update fail');
                                }
                            }
                            else {
                                $notification = ("Update fail, don't find user_id");
                            }
                        }
                        else{
                            $notification = ("Update fail, don't find id");
                        }
                    }
                    return response()->json(['msg'=>$notification]);
                }break;
                case "add":
                {
                    $notification = $this->checkNull($request);
                    if($notification == "")
                    {
                        $user_id = $request->input('user_id');
                        $user = DB::table('users')->where('id',"$user_id");
                        if($user->first())
                        {
                            date_default_timezone_set("Asia/Ho_Chi_Minh");
                            $date_update = date("Y-m-d H:i:s");
                            $affected = DB::table('orders')
                                ->insert([
                                            'user_id' =>  $request->input('user_id'),
                                            'title' =>  $request->input('title'),
                                            'body' =>  $request->input('body'),
                                            'status' =>  $request->input('status'),
                                            'updated_at' => $date_update,
                                            'created_at' => $date_update
                                    ]);
                            if($affected)
                            {
                                $notification = ('Add success');
                            }
                            else{
                                $notification = ('Add fail');
                            }
                        }
                        else {
                            $notification = ("Add fail, don't find user_id");
                        }
                    }
                    return response()->json(['msg'=>$notification]);
                }break;
                case 'delete':
                {
                    $idd = $request->input('id');
                    if($idd != "")
                    {
                        $user = DB::table('orders')->where('id', $idd);
                        if($user->first())
                        {
                            $user->delete();
                            if($user)
                            {
                                $notification = ('Delete success');
                            }
                            else{
                                $notification = ('Delete fail');
                            }
                        }
                        else{
                            $notification = ("Delete fail, can't find user_id");
                        }
                    }
                    else{
                        return response()->json(['msg'=>"ID null"]);
                    }
                    return response()->json(['msg'=>$notification]);
                }
                break;
                default:{
                    return response()->json(['msg'=>"Error server"]);
                }
            }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function checkNull($abc)
    {
        if(strlen($abc->input('id')) == 0)
            return $this->ShowMessage("ID null");
        if(strlen($abc->input('user_id')) == 0)
            return $this->ShowMessage("User ID null");
        if(strlen($abc->input('title')) == 0)
            return $this->ShowMessage("Title null");
        if(strlen($abc->input('body')) == 0)
            return $this->ShowMessage("Body null");
        if(strlen($abc->input('status')) == 0)
            return $this->ShowMessage("Status null");
        return "";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        switch($id)
            {
                case "update":{
                    $notification = $this->checkNull($request);
                    if($notification == "")
                    {
                        $idd = $request->input('id');
                        $profile = DB::table('orders')->find($idd);
                        if($profile)
                        {
                            $user_id = $request->input('user_id');
                            $user = DB::table('users')->where('id',"$user_id");
                            if($user->first())
                            {
                                date_default_timezone_set("Asia/Ho_Chi_Minh");
                                $date_update = date("Y-m-d H:i:s");
                                $affected = DB::table('orders')
                                    ->where('id', $idd)
                                    ->update(['user_id' =>  $request->input('user_id'),
                                                'title' =>  $request->input('title'),
                                                'body' =>  $request->input('body'),
                                                'status' =>  $request->input('status'),
                                                'updated_at' => $date_update
                                        ]);
                                if($affected)
                                {
                                    $notification = $this->ShowMessage('Update success');
                                }
                                else{
                                    $notification = $this->ShowMessage('Update fail');
                                }
                            }
                            else {
                                $notification = $this->ShowMessage("Update fail, don't find user_id");
                            }
                        }
                        else{
                            $notification = $this->ShowMessage("Update fail, don't find id");
                        }
                    }
                    return redirect('/orders')->with('notification',$notification);
                }break;
                case "add":
                {
                    $notification = $this->checkNull($request);
                    if($notification == "")
                    {
                        $user_id = $request->input('user_id');
                        $user = DB::table('users')->where('id',"$user_id");
                        if($user->first())
                        {
                            date_default_timezone_set("Asia/Ho_Chi_Minh");
                            $date_update = date("Y-m-d H:i:s");
                            $affected = DB::table('orders')
                                ->insert([
                                            'user_id' =>  $request->input('user_id'),
                                            'title' =>  $request->input('title'),
                                            'body' =>  $request->input('body'),
                                            'status' =>  $request->input('status'),
                                            'updated_at' => $date_update,
                                            'created_at' => $date_update
                                    ]);
                            if($affected)
                            {
                                $notification = $this->ShowMessage('Add success');
                            }
                            else{
                                $notification = $this->ShowMessage('Add fail');
                            }
                        }
                        else {
                            $notification = $this->ShowMessage("Add fail, don't find user_id");
                        }
                    }
                    return redirect('/orders')->with('notification',$notification);
                }break;
                case 'delete':
                {
                    $idd = $request->input('id');
                    if($idd != "")
                    {
                        $user = DB::table('orders')->where('id', $idd);
                        if($user->first())
                        {
                            $user->delete();
                            if($user)
                            {
                                $notification = $this->ShowMessage('Delete success');
                            }
                            else{
                                $notification = $this->ShowMessage('Delete fail');
                            }
                        }
                        else{
                            $notification = $this->ShowMessage("Delete fail, can't find user_id");
                        }
                    }
                    else{
                        return redirect('/orders')->with('notification',"ID null");
                    }
                    return redirect('/orders')->with('notification',$notification);
                }
                break;
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
