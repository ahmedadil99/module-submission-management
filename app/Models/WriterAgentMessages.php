<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WriterAgentMessages extends Model
{
    use HasFactory;

    protected $fillable = ['agent_id', 'writer_id', 'message', 'article_id'];
}
