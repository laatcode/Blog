<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model {
  protected $table = 'users';

  public function posts() {
    return $this->hasMany('App\Models\BlogPost', 'created_by', 'id')->orderBy('created_at', 'desc');
  }
}
 ?>
