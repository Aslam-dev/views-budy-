<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'role',
        'last_seen',
        'wallet',
        'earnings',
        'payout_id',
        'payout_details',
        'creator',
        'google_id',
        'facebook_id',
        'deleted'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function earnings()
    {
        return $this->hasMany(Earning::class);
    }


    public function expiry($id)
    {
        if ($this->expiry_count($id) > 0) {
            $sub = Earning::where('user_id', Auth::user()->id)->where('video_id', $id)->orderByDesc('created_at')->first();
            return $sub->expired_at;
        }
    }

    public function expiry_count($id)
    {
        $ex_count = Earning::where('user_id', Auth::user()->id)->where('video_id', $id)->count();
        return $ex_count;
    }

    public function viewers(){
        return $this->hasMany(Earning::class, 'sender_id')
            ->orderByDesc('created_at')
            ->take(15)
            ->get();
    }

    public function viewers_count(){
        return $this->hasMany(Earning::class, 'sender_id')
            ->where('seen', 1)
            ->orderByDesc('created_at')
            ->count();
    }

    public function search_videos(){
        return $this->hasMany(Video::class, 'user_id');
    }

}
