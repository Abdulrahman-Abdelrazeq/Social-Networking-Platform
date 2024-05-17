<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'bio',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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



    // Relations
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function connection(){
        return $this->hasMany(Connection::class);
    }

    public function friends(){
        return $this->belongsToMany(User::class, 'connections', 'user_id', 'friend_id')->wherePivot('status', 'accepted');
    }

    // public function sentFriendRequests()
    // {
    //     return $this->hasMany(Connection::class, 'user_id')->where('status', 'pending');
    // }

    // public function receivedFriendRequests(){
    //     return $this->hasMany(Connection::class, 'friend_id')->where('status', 'pending');
    // }
}
