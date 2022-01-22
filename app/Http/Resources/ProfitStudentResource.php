<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfitStudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'profile' => ProfileResource::make($this->whenLoaded('profile')),
            'classroom' => ClassroomResource::make($this->whenLoaded('classroom')),
            'profits' => $this->whenLoaded('profits')
        ];
    }
}
