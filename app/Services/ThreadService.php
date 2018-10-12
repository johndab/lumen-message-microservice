<?php

namespace App\Services;

use Illuminate\Support\Collection;
use App\Exceptions\NoThreadException;
use App\Thread;
use App\UserThread;
use App\Http\Resources\Thread as ThreadResource;

class ThreadService {

  public function get(int $userId) {
    $threads = Thread::whereHas('userThreads', function ($query) use ($userId) {
      $query->where('user_id', $userId);
    })->with('userThreads')->get();

    return ThreadResource::collection($threads);
  }

  public function add(String $title, $params) {
    return Thread::create(['title' => $title, 'params' => $params]);
  }

  public function addUsers(int $threadId, Collection $userIds) {
    $thread = Thread::find($threadId);
    if(!$thread) {
      throw new NoThreadException("Thread with id '$threadId' does not exist!");
    }

    $userIds->each(function ($item) use ($threadId) {
      UserThread::create(['user_id' => $item, 'thread_id' => $threadId]);
    });
  }

  

}