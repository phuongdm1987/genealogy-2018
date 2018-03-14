<?php
declare(strict_types=1);

namespace Genealogy\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class BiographicalRequest
 * @package Genealogy\Http\Requests
 */
class BiographicalRequest extends FormRequest
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
            'birth_place' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'career' => 'nullable|string|max:255',
            'school' => 'nullable|string|max:255',
            'subject' => 'nullable|string|max:255',
            'degree' => 'nullable|string|max:255',
            'hobbies' => 'nullable|string|max:1000',
        ];
    }

    /**
     * @return string|null
     */
    public function birthPlace()
    {
        return $this->get('birth_place');
    }

    /**
     * @return string|null
     */
    public function company()
    {
        return $this->get('company');
    }

    /**
     * @return string|null
     */
    public function career()
    {
        return $this->get('career');
    }

    /**
     * @return string|null
     */
    public function school()
    {
        return $this->get('school');
    }

    /**
     * @return string|null
     */
    public function subject()
    {
        return $this->get('subject');
    }

    /**
     * @return string|null
     */
    public function degree()
    {
        return $this->get('degree');
    }

    /**
     * @return string|null
     */
    public function hobbies()
    {
        return $this->get('hobbies');
    }
}
