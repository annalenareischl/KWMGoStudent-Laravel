<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Timeslot;
use App\Models\User;

class Course extends Model
{
    use HasFactory;
    protected $fillable = ['cID', 'title', 'semester', 'description', 'comment', 'user_id'];


    public function user() : BelongsTo{
        return $this->belongsTo(User::class);
    }

     public function timeslot() : HasMany{
        return $this->hasMany(Timeslot::class);
     }
}
