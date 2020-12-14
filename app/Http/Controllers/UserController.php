<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use DB;

class UserController extends Controller
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
        $users = DB::table('users')->get();
        return view('user/users',  ['users' => $users]);
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
        return view('user/users', ['users'=> array(User::findOrFail($id))]);
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
            return $this->ShowMessage("NAME null");
        if(strlen($abc->input('email')) == 0)
            return $this->ShowMessage("EMAIL null");
        if(strlen($abc->input('password')) == 0)
            return $this->ShowMessage("PASSWORD null");
        if(strlen($abc->input('remember_token')) == 0)
            return $this->ShowMessage("REMEMBER TOKEN null");
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
                        $profile = DB::table('users')->find($idd);
                        date_default_timezone_set("Asia/Ho_Chi_Minh");
                        $date_update = date("Y-m-d H:i:s");
                        $affected = DB::table('users')
                            ->where('id', $idd)
                            ->update(['name' =>  $request->input('name'),
                                        'password' =>  Hash::make('password'),
                                        'remember_token' =>  $request->input('remember_token'),
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
                    return redirect('/users')->with('notification',$notification);
                }break;
                case "add":
                {
                    $notification = $this->checkNull($request);
                    if($notification == "")
                    {
                        $profile = DB::table('users')->where('email',$request->input('email'))->first();
                        if(!$profile)
                        {
                            date_default_timezone_set("Asia/Ho_Chi_Minh");
                            $date_update = date("Y-m-d H:i:s");
                            $affected = DB::table('users')
                                ->insert([
                                            'name' =>  $request->input('name'),
                                            'email' =>  $request->input('email'),
                                            'password' =>  Hash::make($request->input('password')),
                                            'remember_token' =>  $request->input('remember_token'),
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
                        else{
                            $notification = $this->ShowMessage('Add fail, email exist');
                        }
                    }
                    return redirect('/users')->with('notification',$notification);
                }break;
                case 'delete':
                {
                    $idd = $request->input('id');
                    if($idd != "")
                    {
                        $user = DB::table('users')->where('id', $idd);
                        if($user->first())
                        {
                            $user->delete();
                            if($user)
                            {
                                $notification = $this->ShowMessage('Delete success');
                                $profile = DB::table('profiles')->where('user_id',$idd);
                                if($profile->first())
                                {
                                    $profile->delete();
                                }
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
                        return redirect('/users')->with('notification',"ID null");
                    }
                    return redirect('/users')->with('notification',$notification);
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

    public function checkEmail(Request $request)
    {
        if(strlen($request->input('email'))>0)
        {
            $user = DB::table('users')->where('email', $request->input('email'))->first();
            if($user)
            {
                return response()->json(['msg'=>"Email is exist"]);
            }
            else {
                return response()->json(['msg'=>"You can use email"]);
            }
        }
        else {
            return response()->json(['msg'=>"Email null"]);
        }
    }
}
