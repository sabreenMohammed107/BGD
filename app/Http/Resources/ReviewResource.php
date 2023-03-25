<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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

            "rate_no" =>(integer)$this->stars,
            'comment' => $this->comment ?? '',
            "patient" => $this->patient->name ?? '',
            "image" => $this->patient->name ? asset('uploads/users/' . $this->image) : asset('img/default.png') ,


        ];
    }
}
