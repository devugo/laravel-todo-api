<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * Validation rules
     */
    public static function rules()
    {
        return array(
            'name' => 'required|max:100',
            'description' => 'nullable'
        );
    }

    /**
     * How long ago was group created
     */
    public function createdAtAgo()
    {
        return Carbon::instance($this->created_at)->diffForHumans();;
    }

    /**
   * Get the todos user created
   */
    public function todos()
    {
        return $this->hasMany('App\Models\Todo');
    }
}
