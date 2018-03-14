<?php
declare(strict_types=1);

namespace Genealogy\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

/**
 * Class UploadAvatarRequest
 * @package Genealogy\Http\Requests
 */
class UploadAvatarRequest extends FormRequest
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
            'avatar' => 'required|image|max:255',
        ];
    }

    /**
     * @return UploadedFile
     */
    public function avatar(): UploadedFile
    {
        return $this->file('avatar');
    }
}
