<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Thread extends JsonResource
{
    public function toArray($request)
    {
			$clients = $this->clientThreads;
			$disconnected = collect();
      if($clients != null) {
				$disconnected = $clients
					->filter(function($c) { return $c->disonnected; })
					->map(function($ut) { return $ut->client_id; });

				$clients = $clients->map(function($ut) { return $ut->client_id; });
			}
			
			$created = $this->created_at;
			if($created != null)
				 $created = $created->timestamp;
			 
			return [
					'id' => $this->id,
					'title' => $this->title,
					'params' => $this->params,
					'clients' => $clients,
					'disconnected' => $disconnected,
					'created' => $created,
			];
    }
}