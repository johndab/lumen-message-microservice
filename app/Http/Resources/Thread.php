<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Thread extends JsonResource
{
    public function toArray($request)
    {
			$users = $this->userThreads;
      if($users != null)
      	$users = $users->map(function($ut) { return $ut->user_id; });
			
			$created = $this->created_at;
			if($created != null)
				 $created = $created->timestamp;
			 
			return [
					'id' => $this->id,
					'title' => $this->title,
					'params' => $this->params,
					'users' => $users,
					'created' => $created,
			];
    }
}