<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class DoctorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (App::getLocale() == "en") {
            return [

                'name' => $this->name ?? '',
                'email' => $this->email ?? '',
                'mobile' => $this->mobile ?? '',
                'img' =>asset('uploads/doctors/' . $this->img) ?? '',
                'en_overview' => $this->en_overview ?? '',
                'en_brief' => $this->en_brief ?? '',
                'licence_file' => $this->licence_file ?? '',
                'medical field' =>$this->fields,
                'doctor position' => $this->doctor_position_id ?? '',
                'doctor status' => $this->doctor_status_id ?? '',

            ];
        } else {
            return [
                'medical field' => $this->medical->field_dtname ?? '',
                'dt_overview' => $this->dt_overview ?? '',
                'dt_brief' => $this->dt_brief ?? '',

            ];
        }

    }
}
