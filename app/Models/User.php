<?php

namespace App\Models;

use Eloquent;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\HasApiTokens;

/**
 * Class User
 *
 * @mixin Eloquent
 * @property int id
 * @property string name
 * @property mixed|string password
 * @property mixed appointments
 * @property mixed invoices
 * @property mixed payments
 * @property mixed wallet
 * @property mixed token
 * @property mixed rooms
 * @property mixed is_admin
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'redirect_data',
        'avatar',
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
        'redirect_data'     => 'array',
        'is_admin'          => 'boolean',
    ];

    public function getAvatarAttribute($value): string
    {
        if (!$value) {
            $avatar = '/assets/frontend/assets/media/avatars/avatar12.jpg';
        } else {
            $avatar = Storage::url($value);
        }
        return config('app.url').$avatar;
    }

    public function isAdmin(): bool
    {
        return $this->is_admin;
    }

    public function appointments(): HasMany
    {
        return $this->hasMany('App\Models\Appointment');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function payments(): Collection
    {
        $payments = collect();
        foreach ($this->appointments as $appointment) {
            $payments->push($appointment->payment);
        }
        return $payments;
    }

    public function billing(): HasOne
    {
        return $this->hasOne('App\Models\Billing');
    }

    public function wallet(): HasOne
    {
        return $this->hasOne('App\Models\NiftyWallet');
    }

    public function token(): hasOne
    {
        return $this->hasOne(Token::class);
    }

    public function rooms(): hasMany
    {
        return $this->hasMany(ChatRoom::class);
    }

    public function canJoinRoom($room_id): bool
    {
        foreach ($this->rooms as $room) {
            if ($room->id == $room_id) {
                return true;
            }
        }
        return false;
    }

    public function routeNotificationForWhatsApp(): string
    {
        return '+919619271512';
    }
}
