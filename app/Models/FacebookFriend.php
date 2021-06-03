<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property $id
 * @property $friend_id
 * @property $user_id
 * @package App\Models
 * @author Mohammed Mudassir <hello@mudasir.me>
 */
class FacebookFriend extends Model
{
    use HasFactory;

    public $guarded = ['id'];

    public $timestamps = false;

    protected $casts = [
        'user_id' => 'int',
        'friend_id' => 'int',
    ];

    public function childNode(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(FacebookFriend::class, 'friend_id', 'user_id');
    }
}
