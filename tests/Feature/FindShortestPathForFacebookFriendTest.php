<?php

namespace Tests\Feature;

use App\Components\ShortestPath\BreadthFirstSearchAlgorithm;
use App\Components\ShortestPath\FacebookFriendAggregator;
use App\Components\ShortestPath\Graph;
use App\Models\FacebookFriend;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FindShortestPathForFacebookFriendTest extends TestCase
{
    use DatabaseMigrations;

    protected $facebookFriends = [];

    public function test_search()
    {
        $this->importSampleFacebookFriends();

        $aggregator = new FacebookFriendAggregator(new FacebookFriend);
        $search = new BreadthFirstSearchAlgorithm($aggregator);
        $path = $search->search(1, 100);

        dd($path);
    }

    protected function importSampleFacebookFriends()
    {
        foreach ($this->fixture('graph') as $primaryFriend => $friendLists) {
            array_map(function ($friend) use ($primaryFriend) {
                FacebookFriend::factory()->create([
                    'user_id' => $primaryFriend,
                    'friend_id' => $friend,
                ]);
            }, $friendLists);
        }
    }
}
