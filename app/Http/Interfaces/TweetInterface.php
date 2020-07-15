<?php

namespace App\Http\Interfaces;

use Illuminate\Http\Request;
use App\Http\Repositories\TweetRepository;
use App\User;

interface TweetInterface {    

    public function tweet(Request $request);

    public function tweets(Request $request);
    
    public function mapTweets($tweets);

    public function store(array $tweetArray);

    public function comment(Request $request);

    public function delete(Request $request);

    public function first(Request $request);

    public function react(Request $request);

    public function userID();
}