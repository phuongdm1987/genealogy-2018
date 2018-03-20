<?php
declare(strict_types=1);

namespace Genealogy\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ContactRequest
 * @package Genealogy\Http\Requests
 */
class ContactRequest extends FormRequest
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
            'email' => 'nullable|email|max:255',
            'mobile' => 'nullable|string|max:50',
            'skype' => 'nullable|string|max:50',
            'facebook_url' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:1000',
        ];
    }

    /**
     * @return string
     */
    public function email(): string
    {
        return $this->get('email');
    }

    /**
     * @return null|string
     */
    public function mobile(): ?string
    {
        return $this->get('mobile');
    }

    /**
     * @return null|string
     */
    public function skype(): ?string
    {
        return $this->get('skype');
    }

    /**
     * @return null|string
     */
    public function facebookUrl(): ?string
    {
        return $this->get('facebook_url');
    }

    /**
     * @return null|string
     */
    public function address(): ?string
    {
        return $this->get('address');
    }
}
