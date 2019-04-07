<?php

namespace App\Services;

use Illuminate\Support\Collection;
use App\Exceptions\NoThreadException;
use App\Exceptions\NoAccessException;
use App\Thread;
use App\ClientThread;

class ThreadService {

  /**
  * Check if thread exists
  */
  private function checkAndGet(int $threadId) {
    $thread = Thread::with('clientThreads')->where('id', $threadId)->first();
    if(!$thread) {
      throw new NoThreadException("Thread with id '$threadId' does not exist!");
    }
    return $thread;
  }

  public function checkClient(int $threadId, $clientId) {
    $thread = $this->checkAndGet($threadId);
    if($clientId == null) return $thread;

    if($thread->clientThreads()->where('client_id', $clientId)->count() == 0) {
      throw new NoAccessException("You don't have access to the thread '$threadId'");
    }
    return $thread;
  }

  /**
   * Get client threads
   */
  public function get(string $clientId) {
    return Thread::whereHas('clientThreads', function ($query) use ($clientId) {
      $query->where([['client_id', $clientId], ['disconnected', false]]);
    })->with('clientThreads')->orderBy('created_at', 'desc')->get();
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
   * Disonnect client from the thread
   */
  public function disconnectClient(int $threadId, string $clientId) {
    $clientThread = ClientThread::where([['thread_id', $threadId], ['client_id', $clientId]])->findOrFail();
    $clientThread->disconnected = true;
    $clientThread->save();
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
   * Add clients to thread
   */
  public function addClients(int $threadId, Collection $clientIds) {
    $thread = $this->checkAndGet($threadId);
    $currIds = $thread->clientThreads->map(function($ut) { return $ut->client_id; });

    $clientIds->each(function ($item) use ($threadId, $currIds) {
      if(!$currIds->contains($item))
        ClientThread::create(['client_id' => $item, 'thread_id' => $threadId]);
    });
  }
  
  /**
   * Add clients to thread
   */
  public function removeClients(int $threadId, Collection $clientIds) {
    $this->checkAndGet($threadId);
    ClientThread::where('thread_id', $threadId)->whereIn('client_id', $clientIds->toArray())->delete();
  }

}