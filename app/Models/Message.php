<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Message
 * @mixin Eloquent
 * @property mixed room
 */
class Message extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'from_user' => 'boolean',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(ChatRoom::class);
    }

    public function user(): User
    {
        return $this->room->user;
    }

    public function nifty_assistant(): NiftyAssistant
    {
        return $this->room->nifty_assistant;
    }
}
