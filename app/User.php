<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function senderMessages(){
        return $this->hasMany(Message::class, 'sender_id', 'id');
    }

    public function receiverMessages(){
        return $this->hasMany(Message::class, 'receiver_id', 'id');
    }

    public static function userActive($periodStart, $periodEnd, $dir){
        return self::whereHas('senderMessages', function($query) use ($periodStart, $periodEnd){
            $query->where('created_at', '>', $periodStart)->where('created_at', '<', $periodEnd);
        })->orWhereHas('receiverMessages', function($query) use ($periodStart, $periodEnd){
            $query->where('created_at', '>', $periodStart)->where('created_at', '<', $periodEnd);
        })->get();
    }
}
