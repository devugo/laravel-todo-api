<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Todo extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'group_id',
        'type',
        'is_completed',
    ];

    /**
     * Validation rules
     */
    public static function rules()
    {
        return array(
            'title' => 'required|max:255',
            'description' => 'nullable',
            'group' => 'nullable|exists:groups,id',
            'type' => 'nullable|max:150'
        );
    }

    /**
     * How long ago was todo created
     */
    public function createdAtAgo()
    {
        return Carbon::instance($this->created_at)->diffForHumans();;
    }

    /**
   * Get the group todo belomgs to
   */
  public function group()
  {
      return $this->belongsTo('App\Models\Group');
  }
}
