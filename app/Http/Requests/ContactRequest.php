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
    public function email()
    {
        return $this->get('email');
    }

    /**
     * @return string|null
     */
    public function mobile()
    {
        return $this->get('mobile');
    }

    /**
     * @return string|null
     */
    public function skype()
    {
        return $this->get('skype');
    }

    /**
     * @return string|null
     */
    public function facebookUrl()
    {
        return $this->get('facebook_url');
    }

    /**
     * @return string|null
     */
    public function address()
    {
        return $this->get('address');
    }
}
