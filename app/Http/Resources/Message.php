<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Message extends JsonResource
{
    public function toArray($request)
    {		
			$created = $this->created_at;
			if($created != null)
				 $created = $created->timestamp;
			 
			return [
					'id' => $this->id,
					'content' => $this->content,
					'params' => $this->params,
          'clientId' => $this->client_id,
          'threadId' => $this->thread_id,
					'created' => $created,
			];
    }
}