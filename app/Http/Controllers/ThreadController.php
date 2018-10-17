<?php

namespace App\Http\Controllers;

use App\Services\ThreadService;
use App\Exceptions\InvalidJsonException;
use App\Http\Resources\Thread as ThreadResource;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    private $service;

    public function __construct(ThreadService $service)
    {
        $this->service = $service;
    }

    /**
     * Get client's threads
     */
    public function get(string $clientId) {
        $threads = $this->service->get($clientId);
        return response()->json(
            ThreadResource::collection($threads)
        );
    }

    /**
     * Create new thread
     */
    public function add(Request $request) {
        $this->validate($request, [
            'title' => 'Required|min:3|max:255',
        ]);

        $title = $request->title;
        $params = $request->params;
        $this->checkJson($params);

        $thread = $this->service->add($title, $params); 
        $clients = $request->clients;
        if($clients) {
            $clientIds = collect($clients);
            $this->service->addClients($thread->id, $clientIds);
        }

        return response()->json($thread);
    }

    /**
     * Update thread
     */
    public function update(int $threadId, $clientId = null, Request $request) {
        $this->validate($request, [
            'title' => 'min:3|max:255',
        ]);

        $this->service->checkClient($threadId, $clientId);
        $title = $request->title;
        $params = $request->params;
        $this->checkJson($params);
        
        $thread = $this->service->update($threadId, $title, $params);
        return response()->json($thread);
    }

    /**
     * Delete thread
     */
    public function delete(int $threadId, $clientId = null) {
        $this->service->checkClient($threadId, $clientId);
        $this->service->delete($threadId);
        return $this->success();
    }

    /**
     * Add clients to thread
     */
    public function addClient(int $threadId, string $clientId = null, Request $request) {
        $clients = $request->clients;
        $this->service->checkClient($threadId, $clientId);
        if($clients) {
            $clientIds = collect($clients);
            $this->service->addClients($threadId, $clientIds);
        }
        return $this->success();
    }

    /**
     * Remove clients from thread
     */
    public function removeClients(int $threadId, string $clientId = null, Request $request) {
        $clients = $request->clients;
        $this->service->checkClient($threadId, $clientId);
        if($clients) {
            $clientIds = collect($clients);
            $this->service->removeClients($threadId, $clientIds);
        }
        return $this->success();
    }
}
