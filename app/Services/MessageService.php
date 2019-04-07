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
  public function get(int $threadId, $clientId, int $take, int $skip) {
    $thread = $this->threadService->checkClient($threadId, $clientId);
    return $thread->messages()->orderBy('created_at', 'desc')->skip($skip)->take($take)->get();
  }

  
  /**
   *  Add a message
   */
  public function add(int $threadId, string $clientId, string $content, $params) {
    $this->threadService->checkClient($threadId, $clientId);
    
    return Message::create([
      'thread_id' => $threadId,
      'client_id' => $clientId,
      'content' => $content,
      'params' => $params,
    ]);
  }

  

}