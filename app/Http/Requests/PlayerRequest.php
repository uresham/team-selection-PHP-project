<?php

namespace App\Http\Requests;

use App\Enums\PlayerPosition;
use App\Enums\PlayerSkill;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PlayerRequest extends FormRequest
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
        return [
            'name' => 'required|string',
            'position' => 'required|in:' . implode(',', PlayerPosition::getValues()),
            'playerSkills' => 'required|array',
            'playerSkills.*.skill' => 'required|in:' . implode(',', PlayerSkill::getValues()),
            'playerSkills.*.value' => 'integer|min:0',
        ];
    }


    /**
     * Get the failed validation response for the request.
     *
     *
     * @param Validator $validator
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {

        $errors = $validator->errors()->getMessages();

        $formattedErrors = [];
        foreach ($errors as $field => $messages) {
            if(!$this->input($field)) {
                array_push($formattedErrors, "$field is required");
            } else {
                array_push($formattedErrors, "Invalid value for $field: {$this->input($field)}");
            }
        }

        throw new HttpResponseException(response()->json(array(
            'message' => $formattedErrors[0]
        ), 422));
    }
}
