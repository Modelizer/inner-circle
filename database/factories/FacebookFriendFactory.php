<?php

namespace Database\Factories;

use App\Models\FacebookFriend;
use Illuminate\Database\Eloquent\Factories\Factory;

class FacebookFriendFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FacebookFriend::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => mt_rand(1, 10),
            'friend_id' => mt_rand(1, 10),
            'friend_name' => $this->faker->name
        ];
    }
}
