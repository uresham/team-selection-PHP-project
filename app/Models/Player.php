<?php

// /////////////////////////////////////////////////////////////////////////////
// PLEASE DO NOT RENAME OR REMOVE ANY OF THE CODE BELOW.
// YOU CAN ADD YOUR CODE TO THIS FILE TO EXTEND THE FEATURES TO USE THEM IN YOUR WORK.
// /////////////////////////////////////////////////////////////////////////////

namespace App\Models;

use App\Enums\PlayerPosition;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property integer $id
 * @property string $name
 * @property PlayerPosition $position
 * @property PlayerSkill $skill
 */
class Player extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'position'
    ];

    protected $casts = [
        'position' => PlayerPosition::class
    ];

    protected $hidden = ['updated_at', 'created_at'];

    protected $with = ['skills'];

    public function skills(): HasMany
    {
        return $this->hasMany(PlayerSkill::class);
    }

    // this is a recommended way to declare event handlers
    protected static function booted () {
        static::deleting(function(Player $player) { // before delete() method call this
             $player->skills()->delete();
             // do the rest of the cleanup...
        });
    }
}
