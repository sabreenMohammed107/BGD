<?php
namespace App\Http\Resources;

use App\Models\Medical_field;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class DoctorDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $medicines = $this->whenLoaded('medicines');

            return [

                'name' => $this->name ?? '',

                'medical field' => MedicalDoctorResource::collection($this->whenLoaded('medicines')),



            ];


    }
}
