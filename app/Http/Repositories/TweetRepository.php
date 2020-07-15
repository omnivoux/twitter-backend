<?php

namespace App\Http\Repositories;

use Illuminate\Http\Request;
use App\Http\Interfaces\TweetInterface;
use Carbon\Carbon;
use App\User;
use App\Tweet;
use App\Comment;
use App\Reaction;

class TweetRepository implements TweetInterface{

    protected $tweetModel;
    protected $commentModel;
    protected $reactionModel;

    public function __construct()
    {
        $this->tweetModel = new Tweet();
        $this->commentModel = new Comment();
        $this->reactionModel = new Reaction();
    }

    public function tweet(Request $request)
    {
        $request->validate([
            'tweet'=> 'required|max:99'
        ]);        
        
        $this->store(array_merge($request->only('tweet'),$this->userID()));
        
        return $this->mapTweets(Tweet::orderBy('created_at','asc')->with('user')->get());
    }

    public function tweets(Request $request)
    {
        return $this->mapTweets(Tweet::orderBy('created_at','desc')->with(['comments' => function($comment){
            $comment->with('user');                                   
            return $comment;            
        },'user','reactions'])->get());
    }

    public function store($tweetArray)
    {
        return $this->tweetModel->create($tweetArray);
    }

    public function mapTweets($tweets)
    {    
        return $tweets->map(function($tweet){            
            return [                
                'id' => $tweet->id,
                'comments' => $tweet->comments,
                'reactions' => $tweet->reactions,
                'tweet' => $tweet->tweet,
                'user' => $tweet->user,
                'user_id' => $tweet->user_id,
                'posted_at' => Carbon::parse($tweet->created_at)->diffForHumans(),
                'created_at' => $tweet->created_at,
                'updated_at' => $tweet->updated_at
            ];
        });
    }

    public function comment(Request $request)
    {
        $request->validate([
            'tweet_id' => 'required',
            'comment' => 'required'
        ]);

        return $this->commentModel->create(array_merge($request->all(),$this->userID()));
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required'            
        ]);        

        if($this->first($request))
        {
            $this->first($request)->delete();
        }
    }

    public function first(Request $request)
    {
        return $this->tweetModel->where('id', $request->id)->first();
    }

    public function react(Request $request)
    {
        $request->validate([
            'tweet_id' => 'required'           
        ]);

        return $this->reactionModel->firstOrCreate(array_merge($request->only('tweet_id'), $this->userID()));
    }

    public function userID()
    {
        return [
            'user_id' => Auth()->User()->id
        ];
    }
}