<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
    use HasFactory;

    protected $fillable = ['article_id', 'category_id'];
    protected $table = 'article_category';

    public function article()
    {
        return $this->belongsTo('App\Models\Article');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
}
