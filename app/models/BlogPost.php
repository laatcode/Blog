<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model {

  protected $table = 'blog_posts';
  protected $fillable = ['title', 'content', 'img_src', 'created_by', 'updated_by'];

  public function createdBy() {
    return $this->belongsTo('App\Models\User', 'created_by', 'id');
  }

  public function updatedBy() {
    return $this->belongsTo('App\Models\User', 'updated_by', 'id');
  }

  public function comments() {
    return $this->hasMany('App\Models\Comment', 'post_id', 'id')->orderBy('created_at', 'desc');
  }
}


 ?>
