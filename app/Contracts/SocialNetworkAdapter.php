<?php

namespace App\Contracts;

interface SocialNetworkAdapter
{
	public function search(string $query, string $cursor);
}
