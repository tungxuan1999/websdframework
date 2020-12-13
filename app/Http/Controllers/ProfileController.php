<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DB;

class ProfileController extends Controller
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
        $profiles = DB::table('profiles')->get();
        return view('profile.profiles',  ['profiles' => $profiles]);
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
		   $profile =  DB::table('profiles')->where('id',$id)->first();
			return View('profile.show',['profile'=>$profile]);
		}

    public function getProfile(Request $request)
    {
        if(strlen($request->input('user_id'))>0)
        {
            $user = DB::table('profiles')->where('user_id', $request->input('user_id'))->first();
            if($user)
            {
                return response()->json(['msg'=>"Success",'response'=>true,'data'=>$user,'user_id'=>$request->input('user_id')]);
            }
            else {
                return response()->json(['msg'=>"Fail",'response'=>false,'data'=>null,'user_id'=>$request->input('user_id')]);
            }
        }
        else {
            return response()->json(['msg'=>"User ID null",'response'=>false,'data'=>null,'user_id'=>'']);
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
        $profile =  DB::table('profiles')->where('id',$id)->first();
        return View('profile.edit',['profile'=>$profile]);
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
            switch($id)
            {
                case "update":{
                    $idd = $request->input('user_id');
                    $profile = DB::table('profiles')->where('user_id',"$idd")->first();
                    if($profile)
                    {
                        $profile->full_name = $request->input('full_name');
                        $profile->avatar = $request->input('b64');
                        $profile->address = $request->input('address');
                        $profile->birthday = $request->input('birthday');
                        date_default_timezone_set("Asia/Ho_Chi_Minh");
                        $date_update = date("Y-m-d H:i:s");
                        $affected = DB::table('profiles')
                            ->where('user_id', "$idd")
                            ->update(['full_name' =>  $profile->full_name,
                                        'address' =>  $profile->address,
                                        'avatar' => $profile->avatar,
                                        'birthday' =>  $profile->birthday,
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
                        $notification = $this->ShowMessage("Update fail, don't find user_id");
                    }
                return redirect('/profiles')->with('notification',$notification);
                }break;
                // case "add":
                // {
                //     date_default_timezone_set("Asia/Ho_Chi_Minh");
                //     $date_update = date("Y-m-d H:i:s");
                //     $affected = DB::table('profiles')
                //         ->insert([
                //                     'user_id' =>  $request->input('user_id'),
                //                     'full_name' =>  $request->input('full_name'),
                //                     'avatar' => $request->input('b64'),
                //                     'address' =>  $request->input('address'),
                //                     'birthday' =>  $request->input('birthday'),
                //                     'updated_at' => $date_update,
                //                     'created_at' => $date_update
                //             ]);
                //     if($affected)
                //     {
                //         $notification = $this->ShowMessage('Add success');
                //     }
                //     else{
                //         $notification = $this->ShowMessage('Add fail');
                //     }
                // return redirect('/profiles')->with('notification',$notification);
                // }break;
            }
        }

    public function postProfile(Request $request)
    {
        if(strlen($request->input('type'))>0)
        {
            switch($request->input('type'))
            {
                case "update":{
                    $idd = $request->input('user_id');
                    $profile = DB::table('profiles')->where('user_id',"$idd")->first();
                    if($profile)
                    {
                        $profile->full_name = $request->input('full_name');
                        $profile->avatar = $request->input('b64');
                        $profile->address = $request->input('address');
                        $profile->birthday = $request->input('birthday');
                        date_default_timezone_set("Asia/Ho_Chi_Minh");
                        $date_update = date("Y-m-d H:i:s");
                        $affected = DB::table('profiles')
                            ->where('user_id', "$idd")
                            ->update(['full_name' =>  $profile->full_name,
                                        'address' =>  $profile->address,
                                        'avatar' => $profile->avatar,
                                        'birthday' =>  $profile->birthday,
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
                        $notification = "Update fail, don't find user_id";
                    }
                    return response()->json(['msg'=>$notification]);
                }break;
                case "add":
                {
                    $idd = $request->input('user_id');
                    $profile = DB::table('profiles')->where('user_id',"$idd")->first();
                    if(!$profile)
                    {
                        date_default_timezone_set("Asia/Ho_Chi_Minh");
                        $date_update = date("Y-m-d H:i:s");
                        $affected = DB::table('profiles')
                            ->insert([
                                        'user_id' =>  $request->input('user_id'),
                                        'full_name' =>  $request->input('full_name'),
                                        'avatar' => $request->input('b64'),
                                        'address' =>  $request->input('address'),
                                        'birthday' =>  $request->input('birthday'),
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
                        return response()->json(['msg'=>$notification]);
                    }
                    else{
                        return response()->json(['msg'=>"User ID exist"]);
                    }
                }break;
            }
        }
        else return response()->json(['msg'=>"Error server"]);
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
