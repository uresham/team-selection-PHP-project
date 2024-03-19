<?php

namespace App\Http\Requests;

use App\Enums\PlayerPosition;
use App\Enums\PlayerSkill;
use App\Http\Requests\Rules\TeamSelectionRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TeamSelectionRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Adjust authorization logic if needed
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            // Validate the entire JSON array
            '*.position' => 'required|string|in:' . implode(',', PlayerPosition::getValues()),
            '*.mainSkill' => 'required|string|in:' . implode(',', PlayerSkill::getValues()),
            '*.numberOfPlayers' => 'required|integer|min:1', // At least 1 player
            '*' => ['required', new TeamSelectionRule]
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
            } elseif(str_contains($messages[0], 'cannot have the same main skill')) {
                array_push($formattedErrors, $messages[0]);
            } else {
                array_push($formattedErrors, "Invalid value for $field: {$this->input($field)}");

            }
        }

        throw new HttpResponseException(response()->json(array(
            'message' => $formattedErrors[0]
        ), 422));
    }
}
