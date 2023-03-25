<?php

namespace App\Http\Resources\Character;

use Illuminate\Http\Resources\Json\JsonResource;

class CharacterResource extends JsonResource
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
            'name' => $this->name,
            'age' => $this->age,
            'biography' => $this->biography,
            'obituary' => $this->obituary,
            'status' => $this->status,
            'fraction_id' => $this->fraction_id,
            'user_id' => $this->user_id,
            'image' => $this->image,
        ];
    }
}
