<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentArticle extends Model
{
    use HasFactory;

    protected $fillable = ['article_id', 'agent_id', 'publisher_id'];

    public function article()
    {
        return $this->belongsTo('App\Models\Article');
    }

}
