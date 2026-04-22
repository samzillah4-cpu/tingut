<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'chat_id',
        'sender_type',
        'message',
    ];

    protected $casts = [
        'sender_type' => 'string',
    ];

    /**
     * Get the chat this message belongs to.
     */
    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }
}
