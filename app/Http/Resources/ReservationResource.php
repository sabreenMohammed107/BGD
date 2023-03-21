<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
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

            'patient' => $this->patient->name ?? '',
            // 'clinic' => $this->clinic->name ?? '',
            'reservation_status' => $this->status->en_status ?? '',
            'doctor' => DoctorResource::make( $this->clinic->doctor),
            'reservation_date' => $this->reservation_date ?? '',
            'time_from' => $this->time_to ?? '',
            'time_to' => $this->time_to ?? '',
            'me / other' => ($this->other_flag ==1) ? 'other' : 'me',
            'patient_name' => $this->patient_name ?? '',
            'patient_mobile' => $this->patient_mobile ?? '',
            'patient_address' => $this->patient_address ?? '',
        ];
    }
}
