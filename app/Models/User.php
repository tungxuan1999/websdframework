<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role() {
        return $this->belongsTo('App\Models\Role');
    }

    public function hasRole($role) {
        // switch($this->role->name)
        // {
        //     case 'admin':{
        //         return false;
        //     }
        //     case 'editor':{
        //         if($role == 'viewer')
        //             return false;
        //         if($role == 'editor')
        //             return false;
        //         return true;
        //     }
        //     case 'viewer':{
        //         if($role == 'viewer')
        //             return false;
        //         return true;
        //     }
        // }
        // // if($this->role->name == 'admin')
        // //     return true;
        // // else
            if(strcmp('admin', $this->role->name)==0)
                return true;
            if(strcmp('editor', $this->role->name)==0 && (strcmp('viewer', $role)==0 || strcmp('editor', $role)==0))
                return true;
            return strcmp($role, $this->role->name)==0 ;
     }
}
