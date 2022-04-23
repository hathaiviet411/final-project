<?php
/**
 * Created by VeHo.
 * Year: 2022-04-21
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'rooms';

    protected $fillable = [
        'room_number',
        'building_id',
        'room_type',
        'room_capacity',
        'level',
        'room_information',
        'room_status',
    ];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'data' => 'array'
    ];
}
