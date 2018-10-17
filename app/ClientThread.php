<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientThread extends Model
{
  protected $table = 'client_threads';
  protected $fillable = ['client_id', 'thread_id'];
}
