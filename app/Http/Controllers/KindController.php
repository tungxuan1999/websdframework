<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kind;
use Illuminate\Http\Request;
use DB;

class KindController extends Controller
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
        $kinds = DB::table('kinds')->get();
        return view('kind.list',  ['kinds' => $kinds]);
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
    }

    public function getKinds(Request $request)
    {
        $user = DB::table('kinds')->get();
        if($user)
        {
            return response()->json(['msg'=>"Success",'response'=>true,'data'=>$user]);
        }
        else {
            return response()->json(['msg'=>"Fail",'response'=>false,'data'=>null]);
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
        if(strlen($abc->input('name')) == 0)
            return $this->ShowMessage("Name null");
        if(strlen($abc->input('detail')) == 0)
            return $this->ShowMessage("Detail null");
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
                $profile = DB::table('products')->find($idd);
                if($profile)
                {
                    date_default_timezone_set("Asia/Ho_Chi_Minh");
                    $date_update = date("Y-m-d H:i:s");
                    $affected = DB::table('products')
                        ->where('id', $idd)
                        ->update(['name' =>  $request->input('name'),
                                    'price' =>  $request->input('price'),
                                    'detail' =>  $request->input('detail'),
                                    'image' =>  $request->input('b64'),
                                    'sex' =>  $request->input('sex'),
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
                else{
                    $notification = $this->ShowMessage("Update fail, don't find id");
                }
            }
            return redirect('/products')->with('notification',$notification);
            } break;
            case "add":
            {
                $notification = $this->checkNull($request);
                if($notification == "")
                {
                    date_default_timezone_set("Asia/Ho_Chi_Minh");
                    $date_update = date("Y-m-d H:i:s");
                    $affected = DB::table('products')
                        ->insert([
                                    'name' =>  $request->input('name'),
                                    'price' =>  $request->input('price'),
                                    'detail' =>  $request->input('detail'),
                                    'image' =>  $request->input('b64'),
                                    'sex' =>  $request->input('sex'),
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
                return redirect('/products')->with('notification',$notification);
            }break;
            case 'delete':
            {
                $idd = $request->input('id');
                if($idd != "")
                {
                    $user = DB::table('products')->where('id', $idd);
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
                    return redirect('/products')->with('notification',"ID null");
                }
                return redirect('/products')->with('notification',$notification);
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
