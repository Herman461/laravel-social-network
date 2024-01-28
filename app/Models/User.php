<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    public function createApiToken(): string
    {
        $token = str()->random(64);
        $this->api_token = $token;
        $this->save();

        return $token;
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static function boot() {
        parent::boot();

        static::creating(function(User $user) {
            $user->slug = $user->slug ?? str($user->name)->slug();
        });
    }

    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }

//    public function comments(): hasMany
//    {
//        return $this->hasMany(Comment::class);
//    }

    public function likes(): hasMany
    {
        return $this->hasMany(Like::class);
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'author_follower', 'author_id', 'follower_id');
    }

    public function channelOwners(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'author_follower', 'follower_id', 'author_id');
    }

}
