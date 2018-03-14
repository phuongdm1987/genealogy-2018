<?php
declare(strict_types=1);

namespace Genealogy\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class RegisterRequest
 * @package Genealogy\Http\Requests
 */
class RegisterRequest extends FormRequest
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
            'username' => 'required|string|max:40|unique:users',
            'email' => 'email|max:255',
            'password' => 'required|string|min:6|confirmed',
        ];
    }

    /**
     * @return string
     */
    public function username(): string
    {
        return $this->get('username');
    }

    /**
     * @return string
     */
    public function emailAddress(): string
    {
        return $this->get('email');
    }

    /**
     * @return string
     */
    public function password(): string
    {
        return $this->get('password');
    }
}
