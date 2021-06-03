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

    public function test_find_the_shortest_path_between_two_friends_case_1()
    {
        $this->importSampleFacebookFriends();

        $aggregator = new FacebookFriendAggregator(new FacebookFriend);
        $search = new BreadthFirstSearchAlgorithm($aggregator);
        $path = $search->search(1, 100)->toArray();

        $this->assertEquals([1, 10, 100], $path);
    }

    public function test_find_the_shortest_path_between_two_friends_case_2()
    {
        $this->importSampleFacebookFriends();

        $aggregator = new FacebookFriendAggregator(new FacebookFriend);
        $search = new BreadthFirstSearchAlgorithm($aggregator);
        $path = $search->search(1, 2000)->toArray();

        $this->assertEquals([1, 10, 100, 1000, 2000], $path);
    }

    public function test_find_the_shortest_path_between_two_friends_case_3()
    {
        $this->importSampleFacebookFriends();

        $aggregator = new FacebookFriendAggregator(new FacebookFriend);
        $search = new BreadthFirstSearchAlgorithm($aggregator);
        $path = $search->search(10, 110)->toArray();

        $this->assertEquals([10, 110], $path);
    }

    protected function importSampleFacebookFriends()
    {
        foreach ($this->fixture('graph') as $primaryFriend => $friendLists) {
            FacebookFriend::factory()
                ->createMany(
                    array_map(
                        function ($friend) use ($primaryFriend) {
                            return [
                                'user_id' => $primaryFriend,
                                'friend_id' => $friend,
                            ];
                        },
                        $friendLists)
                );
        }
    }
}
