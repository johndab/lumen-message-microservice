<?php

namespace App\Http\Controllers;

use App\Services\MessageService;
use Illuminate\Http\Request;
use App\Http\Resources\Message as MessageResource;

class MessageController extends Controller
{

    private $service;
    public function __construct(MessageService $service)
    {
        $this->service = $service;
    }

    /**
     * Get thread messages
     */
    public function get(int $threadId, Request $request) {
        $take = isset($request->take) ? $request->take : 10;
        $skip = isset($request->skip) ? $request->skip : 0;

        $messages = $this->service->get($threadId, $take, $skip);
        return response()->json(
            MessageResource::collection($messages)
        );
    }

    /**
     * Add a message to the thread
     */
    public function add(int $threadId, Request $request) {
        $this->validate($request, [
            'content' => 'Required|min:1',
            'userId' => 'Required',
        ]);

        $content = $request->content;
        $params = $request->params;
        $userId = $request->userId;
        $this->checkJson($params);
        
        $message = $this->service->add($threadId, $userId, $content, $params);

        return response()->json(new MessageResource($message));
    }
}
