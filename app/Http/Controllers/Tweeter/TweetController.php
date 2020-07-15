<?php

namespace App\Http\Controllers\Tweeter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Interfaces\TweetInterface;

class TweetController extends Controller
{
    protected $tweetService;

    public function __construct(TweetInterface $service)
    {
        $this->tweetService = $service;
    }

    public function tweet(Request $request)
    {
        return $this->tweetService->tweet($request);
    }

    public function tweets(Request $request)
    {
        return $this->tweetService->tweets($request);
    }

    public function comment(Request $request)
    {
        return $this->tweetService->comment($request);
    }

    public function delete(Request $request)
    {
        return $this->tweetService->delete($request);
    }

    public function react(Request $request)
    {
        return $this->tweetService->react($request);
    }
}
