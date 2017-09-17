<?php

namespace App\Services;

use Faker;
use App\Contracts\SocialNetworkAdapter;

class FakeSocialNetworkAdapter implements SocialNetworkAdapter
{
    public function search(string $query, string $cursor)
    {
        return [
            'id_str' => (string) Faker\Factory::create()->unique()->randomNumber,
            'user' => [
                'id_str' => (string) Faker\Factory::create()->unique()->randomNumber,
                'name' => Faker\Factory::create()->name,
                'screen_name' => Faker\Factory::create()->userName,
            ],
            'text' => Faker\Factory::create()->text(140),
            'created_at' => date('Y-m-d H:i:s')
        ];
    }
}
