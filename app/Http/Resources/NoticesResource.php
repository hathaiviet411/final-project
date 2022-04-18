<?php
/**
 * Created by VeHo.
 * Year: 2022-04-08
 */

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
class NoticesResource extends JsonResource
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
            "id" => $this->id,
            "subject" => $this->subject,
            "content" => $this->content,
            "created_by" => $this->created_by,
            "updated_by" => $this->updated_by,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "viewed_count" => $this->viewed_count,
            "viewer_left" => $this->view_left
        ];
    }
}
