<?php

namespace App\Services;

use App\Message;

class MessageService {

  private $threadService;
  public function __construct(ThreadService $threadService) {
    $this->threadService = $threadService;
  }

  /**
   * Get thread messages
   */
  public function get(int $threadId, int $take, int $skip) {
    $thread = $this->threadService->checkAndGet($threadId);
    return $thread->messages()->skip($skip)->take($take)->get();
  }

  
  /**
   *  Add a message
   */
  public function add(int $threadId, int $userId, string $content, $params) {
    $this->threadService->checkAndGet($threadId);
    
    return Message::create([
      'thread_id' => $threadId,
      'user_id' => $userId,
      'content' => $content,
      'params' => $params,
    ]);
  }

  

}