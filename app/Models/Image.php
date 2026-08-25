<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function Page()
    {
        return $this->belongsTo(Page::class, );
    }

    public function Post()
    {
        return $this->belongsTo(Post::class, );
    }


}
