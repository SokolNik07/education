<?php

namespace App\Http\Resources\Fraction;

use Illuminate\Http\Resources\Json\JsonResource;

class FractionResource extends JsonResource
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
            'title' => $this->title,
            'banner' => $this->banner,
            'description' => $this->description,
        ];
    }
}
