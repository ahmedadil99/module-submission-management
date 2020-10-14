<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleNegotiation extends Model
{
    use HasFactory;

    protected $fillable = ['agent_id', 'writer_id', 'article_to_agent_id', 'message', 'status', 'amount'];

    public function article()
    {
        return $this->belongsTo('App\Models\ArticleToAgent');
    }
}
