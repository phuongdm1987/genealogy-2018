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
     * @return null|string
     */
    public function birthPlace(): ?string
    {
        return $this->get('birth_place');
    }

    /**
     * @return null|string
     */
    public function company(): ?string
    {
        return $this->get('company');
    }

    /**
     * @return null|string
     */
    public function career(): ?string
    {
        return $this->get('career');
    }

    /**
     * @return null|string
     */
    public function school(): ?string
    {
        return $this->get('school');
    }

    /**
     * @return null|string
     */
    public function subject(): ?string
    {
        return $this->get('subject');
    }

    /**
     * @return null|string
     */
    public function degree(): ?string
    {
        return $this->get('degree');
    }

    /**
     * @return null|string
     */
    public function hobbies(): ?string
    {
        return $this->get('hobbies');
    }
}
