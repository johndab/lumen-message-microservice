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
     * Get user's threads
     */
    public function get(int $userId) {
        $threads = $this->service->get($userId);
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
        $users = $request->users;
        if($users) {
            $userIds = collect($users);
            $this->service->addUsers($thread->id, $userIds);
        }

        return response()->json($thread);
    }

    /**
     * Update thread
     */
    public function update(int $threadId, Request $request) {
        $this->validate($request, [
            'title' => 'Required|min:3|max:255',
        ]);

        $title = $request->title;
        $params = $request->params;
        $this->checkJson($params);

        $thread = $this->service->update($threadId, $title, $params);
        return response()->json($thread);
    }

    /**
     * Delete thread
     */
    public function delete(int $threadId) {
        $this->service->delete($threadId);
        return $this->success();
    }

    /**
     * Add users to thread
     */
    public function addUsers(int $threadId, Request $request) {
        $users = $request->users;
        if($users) {
            $userIds = collect($users);
            $this->service->addUsers($threadId, $userIds);
        }
        return $this->success();
    }

    /**
     * Remove users from thread
     */
    public function removeUsers(int $threadId, Request $request) {
        $users = $request->users;
        if($users) {
            $userIds = collect($users);
            $this->service->removeUsers($threadId, $userIds);
        }
        return $this->success();
    }

    /**
     * Check if json correct or throw exception
     */
    private function checkJson($string) {
        if($string == null) return;
        try {
            json_decode($string);
        } catch (\Exception $e) {
            throw new InvalidJsonException();
        }

        if(json_last_error() != JSON_ERROR_NONE) {
            throw new InvalidJsonException();
        }
    }

}
