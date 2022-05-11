<?php
/**
 * Created by VeHo.
 * Year: 2022-04-24
 */

namespace App\Http\Resources;

class ScheduleResource extends BaseResource
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
          'contract_type' => $this->contract_type,
          'created_at' => $this->created_at,
          'deleted_at' => $this->deleted_at,
          'department_id' => $this->department_id,
          'position_id' => $this->position_id,
          'role_id' => $this->role_id,
          'id' => $this->id,
          'schedules' => json_decode($this->schedules),
          'updated_at' =>  $this->updated_at,
          'user_code' =>  $this->user_code,
          'user_id' =>  $this->user_id,
          'user_name' =>  $this->user_name,
          ];
    }
}
