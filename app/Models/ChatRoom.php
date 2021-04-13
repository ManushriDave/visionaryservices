<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class ChatRoom
 * @mixin Eloquent
 * @property int user_id
 * @property int nifty_assistant_id
 * @property int id
 * @property mixed nifty_assistant
 * @property mixed user
 * @property mixed messages
 */
class ChatRoom extends Model
{
    protected $guarded = [];

    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function nifty_assistant(): BelongsTo
    {
        return $this->belongsTo(NiftyAssistant::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'room_id', 'id');
    }
}
