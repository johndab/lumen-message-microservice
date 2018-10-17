<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
  protected $fillable = ['client_id', 'title', 'params'];

  public function messages() {
    return $this->hasMany(Message::class);
  }

  public function clientThreads() {
    return $this->hasMany(ClientThread::class);
  }
}
