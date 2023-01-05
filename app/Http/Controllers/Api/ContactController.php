<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Resources\FaqResource;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends BaseController
{
    //
    public function getFaq(Request $request)
    {
        // if(Auth::guard('api')->check()){
            $faqs = Faq::all();
            return $this->sendResponse(FaqResource::collection($faqs),  __("links.faq"));
        // }else{
        //     return $this->authCheck( __("links.checkLog"));

        // }



    }
}
