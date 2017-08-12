<?php

namespace App\Services;

use App\Contracts\SocialNetworkAdapter;

class FakeSocialNetworkAdapter implements SocialNetworkAdapter
{
    public function search(string $query, string $cursor)
    {
        return [
            'id_str' => '6649',
            'user' => [
                'id_str' => '108316',
                'name' => 'Tabitha Borer',
                'screen_name' => 'gmarvin',
            ],
            'text' => 'Dolor eum doloribus culpa dignissimos. Voluptatum velit ducimus similique unde molestiae. Earum quam facilis enim ratione mollitia a eum.',
            'created_at' => 'Sat Aug 12 01:28:06 +0000 2017'
        ];
    }
}
