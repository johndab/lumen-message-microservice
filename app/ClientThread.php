<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCompositePrimaryKey;

class ClientThread extends Model
{
  use HasCompositePrimaryKey;

  protected $primaryKey = ['client_id', 'thread_id'];
  public $incrementing = false;

  protected $table = 'client_threads';
  protected $fillable = ['client_id', 'thread_id'];
}
