<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'gender', 'linkedin',
    ];

    public $rules = [
        'first_name' => 'required|min:3|max:15',
        'last_name' => 'required|min:3|max:15',
        'gender' => 'required|in:male, female, other',
        'linkedin' => 'url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
