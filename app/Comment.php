<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function reply() {
      return $this->hasMany(Reply::class);
    }

    public function page() {
      return $this->belongsTo(Page::class);
    }
}
