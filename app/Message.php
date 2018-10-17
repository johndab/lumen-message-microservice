<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
  protected $fillable = ['client_id', 'thread_id', 'content', 'params'];

}
