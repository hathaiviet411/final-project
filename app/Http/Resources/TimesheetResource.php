<?php
/**
 * Created by VeHo.
 * Year: 2022-04-21
 */

namespace App\Http\Resources;

class TimesheetResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      return [
        'id' => $this->id,
        'user_id' =>  $this->user_id,
        'user_code' =>  $this->user_code,
        'user_name' =>  $this->user_name,
        'role_id' => $this->role_id,
        'department_id' => $this->department_id,
        'position_id' => $this->position_id,
        'contract_type' => $this->contract_type,
        'timesheet' => json_decode($this->timesheet),
        'total_salary' => $this->total_salary,
        'deduction' => $this->deduction,
        'deduction_reason' => $this->deduction_reason,
        'payroll_status' => $this->payroll_status,
        'schedule' => json_decode($this->schedule),
        'created_at' => $this->created_at,
        'updated_at' =>  $this->updated_at,
        'deleted_at' => $this->deleted_at,
        ];
    }
}
