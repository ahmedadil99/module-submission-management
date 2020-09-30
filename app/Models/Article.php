<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Article extends Model
{
    use HasFactory;

    public function categories(){
        return $this->belongsToMany('App\Models\Category');
    }

    protected static function boot(){
        parent::boot();
        if (Auth::user()->role->name == 'Writer'){
            static::addGlobalScope('author', function (Builder $builder) {
                $builder->where('user_id', '=', Auth::user()->id);
            });
        }

        
    }
}
