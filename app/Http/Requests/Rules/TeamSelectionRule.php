<?php


namespace App\Http\Requests\Rules;

use Illuminate\Contracts\Validation\Rule;

class TeamSelectionRule implements Rule
{

    protected $attribute;
    protected $value;
    protected $positions;
    protected $skills;
    protected $message;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        if(!array_key_exists('mainSkill', $value)|| !array_key_exists('position', $value)) {
            return true;
        }
        $this->attribute = $attribute;
        $this->value = $value;

        $position = $value['position'];
        $skill = $value['mainSkill'];

        if (isset($this->positions[$position]) && isset($this->skills[$position][$skill])) {
            $this->message = "The position '$position' cannot have the same main skill '$skill' multiple times.";
            return false;
        }

        $this->positions[$position] = true;
        $this->skills[$position][$skill] = true;

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
