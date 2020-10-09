<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleToAgent extends Model
{
    use HasFactory;

    protected $table = 'article_to_agent';

    protected $fillable = ['agent_id', 'article_id'];

    public function article()
    {
        return $this->belongsTo('App\Models\Article');
    }

}
