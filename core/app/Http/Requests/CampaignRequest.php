<?php

namespace App\Http\Requests;

use App\Models\CampaignImageCategory;
use Illuminate\Foundation\Http\FormRequest;

class CampaignRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];

        foreach (CampaignImageCategory::all() as $campaignImageCategory) {
            
            $parameterName = str_replace(' ', '_', $campaignImageCategory->name);

            $rules["$parameterName.*"] = 'image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }

        return $rules;
    }

    public function messages()
    {
        $messages = [];

        foreach (CampaignImageCategory::all() as $campaignImageCategory) {
            
            $parameterName = str_replace(' ', '_', $campaignImageCategory->name);
            $messages["$parameterName.*"] = "Uploaded file has to be image";
        }

        return $messages;
    }
}
