<?php
/**
 * Created by VeHo.
 * Year: 2022-04-21
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Timesheet extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'timesheets';

    protected $fillable = [
      'user_id',
      'user_code',
      'user_name',
      'role_id',
      'department_id',
      'position_id',
      'contract_type',
      'timesheet',
      'schedule',
    ];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'data' => 'array'
    ];

}
