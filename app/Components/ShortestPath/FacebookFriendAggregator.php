<?php

namespace App\Components\ShortestPath;

use App\Models\FacebookFriend;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use SplDoublyLinkedList;

/**
 * @author Mohammed Mudassir <hello@mudasir.me>
 */
class FacebookFriendAggregator
{
    public function __construct(protected FacebookFriend $facebookFriend)
    {

    }

    public function findNode($origin, $destination)
    {
        return $this->facebookFriend
            ->newQuery()
            ->whereIn('user_id', [$origin, $destination])
            ->whereIn('friend_id', [$origin, $destination])
            ->first();
    }

    public function getNodeEdges($value, array $exclude = []): array
    {
        // @todo With bigger array the consumption of memory will be too high.
        return $this->facebookFriend
            ->newQuery()
            ->where('user_id', $value)
            ->orWhere('friend_id', $value)
            ->whereNotIn('user_id', $exclude)
            ->whereNotIn('friend_id', $exclude)
            ->get(['user_id', 'friend_id'])
            ->map(function (FacebookFriend $facebookFriend) {
                return [$facebookFriend->user_id, $facebookFriend->friend_id];
            })
            ->flatten()
            ->unique()
            ->filter(function ($key) use ($value) {
                return $key != $value;
            })
            ->toArray();
    }
}
