<?php
declare(strict_types=1);

namespace Genealogy\Http\Requests;

use Genealogy\Entities\Person;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class PersonRequest
 * @package Genealogy\Http\Requests
 */
class PersonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name' => 'nullable|string|max:50',
            'middle_name' => 'nullable|string|max:50',
            'last_name' => 'nullable|string|max:50',
            'avatar' => 'nullable|image|max:255',
            'sex' => ['integer', Rule::in(array_keys(Person::SEX))],
            'birth_of_date' => 'nullable|date_format:Y-m-d',
            'birth_of_time' => 'nullable|date_format:H:i',
            'is_living' => 'boolean',
            'death_of_date' => 'nullable|date_format:Y-m-d|after:birth_of_date',
            'death_of_time' => 'nullable|date_format:H:i',
        ];
    }

    /**
     * @return string|null
     */
    public function firstName()
    {
        return $this->get('first_name');
    }

    /**
     * @return string|null
     */
    public function middleName()
    {
        return $this->get('middle_name');
    }

    /**
     * @return string|null
     */
    public function lastName()
    {
        return $this->get('last_name');
    }

    /**
     * @return int
     */
    public function sex(): int
    {
        return (int)$this->get('sex');
    }

    /**
     * @return string|null
     */
    public function birthOfDate()
    {
        $birthOfDate = $this->get('birth_of_date');
        if (!$birthOfDate) {
            return null;
        }

        $birthOfTime = $this->get('birth_of_time') ?? '00:00';
        $birthOfTime .= ':00';
        $birthOfDate .= $birthOfTime;

        return $birthOfDate;
    }

    /**
     * @return int
     */
    public function isLiving(): int
    {
        return (int)$this->get('is_living');
    }

    /**
     * @return string|null
     */
    public function deathOfDate()
    {
        if ($this->isLiving()) {
            return null;
        }

        $deathOfDate = $this->get('death_of_date');

        if (!$deathOfDate) {
            return null;
        }

        $deathOfTime = $this->get('death_of_time') ?? '00:00';
        $deathOfTime .= ':00';
        $deathOfDate .= $deathOfTime;

        return $deathOfDate;
    }
}
