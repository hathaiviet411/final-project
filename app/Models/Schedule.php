<?php
/**
 * Created by VeHo.
 * Year: 2022-04-24
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'schedules';

    protected $fillable = [];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'data' => 'array'
    ];

}
