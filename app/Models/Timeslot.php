<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Timeslot extends Model
{
    use HasFactory;
    protected $fillable = ['day', 'from', 'to', 'is_available', 'course_id'];

    public function course() : BelongsTo{
        return $this->belongsTo(Course::class);
    }

    public function users() : BelongsToMany{
            return $this->belongsToMany(User::class)->withTimestamps();
        }

}
