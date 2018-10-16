<?php

namespace App\Services;

use Illuminate\Support\Collection;
use App\Exceptions\NoThreadException;
use App\Thread;
use App\UserThread;

class ThreadService {

 /**
 * Check if thread exists
 */
  public function checkAndGet(int $threadId) {
    $thread = Thread::find($threadId);
    if(!$thread) {
      throw new NoThreadException("Thread with id '$threadId' does not exist!");
    }
    return $thread;
  }

  /**
   * Get user threads
   */
  public function get(int $userId) {
    return Thread::whereHas('userThreads', function ($query) use ($userId) {
      $query->where('user_id', $userId);
    })->with('userThreads')->get();
  }

  /**
   *  Add a thread
   */
  public function add(String $title, $params) {
    return Thread::create(['title' => $title, 'params' => $params]);
  }

  /**
   * Remove thread
   */
  public function delete(int $threadId) {
    $thread = $this->checkAndGet($threadId);
    $thread->delete();
  }
  
  /**
   * Update thread title and params
   */
  public function update(int $threadId, $title, $params) {
    $thread = $this->checkAndGet($threadId);
    if($title) {
      $thread->title = $title;
    }
    $thread->params = $params;
    $thread->save();

    return $thread;
  }

  /**
   * Add users to thread
   */
  public function addUsers(int $threadId, Collection $userIds) {
    $thread = $this->checkAndGet($threadId);
    $currIds = $thread->userThreads->map(function($ut) { return $ut->user_id; });

    $userIds->each(function ($item) use ($threadId, $currIds) {
      if(!$currIds->contains($item))
        UserThread::create(['user_id' => $item, 'thread_id' => $threadId]);
    });
  }
  
  /**
   * Add users to thread
   */
  public function removeUsers(int $threadId, Collection $userIds) {
    $this->checkAndGet($threadId);

    UserThread::where('thread_id', $threadId)->whereIn('user_id', $userIds->toArray())->delete();
  }

}