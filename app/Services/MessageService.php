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
  public function get(int $threadId, $userId, int $take, int $skip) {
    $thread = $this->threadService->checkUser($threadId, $userId);
    return $thread->messages()->skip($skip)->take($take)->get();
  }

  
  /**
   *  Add a message
   */
  public function add(int $threadId, int $userId, string $content, $params) {
    $this->threadService->checkUser($threadId, $userId);
    
    return Message::create([
      'thread_id' => $threadId,
      'user_id' => $userId,
      'content' => $content,
      'params' => $params,
    ]);
  }

  

}