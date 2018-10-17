<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Thread extends JsonResource
{
    public function toArray($request)
    {
			$clients = $this->clientThreads;
      if($clients != null)
      	$clients = $clients->map(function($ut) { return $ut->client_id; });
			
			$created = $this->created_at;
			if($created != null)
				 $created = $created->timestamp;
			 
			return [
					'id' => $this->id,
					'title' => $this->title,
					'params' => $this->params,
					'clients' => $clients,
					'created' => $created,
			];
    }
}