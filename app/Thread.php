<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
  protected $fillable = ['user_id', 'title', 'params'];

  public function messages() {
    return $this->hasMany(Message::class);
  }

  public function userThreads() {
    return $this->hasMany(UserThread::class);
  }
}
