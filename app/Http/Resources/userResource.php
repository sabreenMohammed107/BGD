<?php
namespace App\Http\Resources;

use App\Models\Medical_field;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class userResource extends JsonResource
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


                'id'=>$this->id,
                'name' => $this->name ?? '',
                'email' => $this->email ?? '',
                'mobile' => $this->mobile ?? '',
                'image' =>asset('uploads/users/' . $this->image) ?? asset('img/default.png'),
                'gender'=> $this->gender ?? '',

                'birth_date'=> $this->birth_date ?? '',
                'details_address'=> $this->details_address ?? '',
                'postal_code'=> $this->postal_code ?? '',
                'google_map'=> $this->google_map ?? '',
                'accessToken' => $this->accessToken,



            ];
        } else {
            return [



                'id'=>$this->id,
                'name' => $this->name ?? '',
                'email' => $this->email ?? '',
                'mobile' => $this->mobile ?? '',
                'image' =>asset('uploads/users/' . $this->image) ?? asset('img/default.png'),
                'gender'=> $this->gender ?? '',

                'birth_date'=> $this->birth_date ?? '',
                'details_address'=> $this->details_address ?? '',
                'postal_code'=> $this->postal_code ?? '',
                'google_map'=> $this->google_map ?? '',
                'accessToken' => $this->accessToken,



            ];
        }

    }
}
