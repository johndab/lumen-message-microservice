<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserThread extends Model
{
  protected $table = 'user_threads';
  protected $fillable = ['user_id', 'thread_id'];
}
