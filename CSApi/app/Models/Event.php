<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\EventCreated;
use Illuminate\Support\Facades\Notification;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'location',
        'date',
        'max_participants',
        'status',
        'organizer_id'
    ];

    protected $casts = [
        'date' => 'datetime',
        'max_participants' => 'integer',
    ];

    protected static function booted()
    {
        static::created(function ($event) {
            $users = User::where('role', 'admin')->get();
            
            Notification::send($users, new EventCreated($event));
        });
    }

    // Relationship with the organizer (User)
    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    // Relationship with participants (Users)
    public function participants()
    {
        return $this->belongsToMany(User::class, 'event_user')
            ->withTimestamps();
    }
}