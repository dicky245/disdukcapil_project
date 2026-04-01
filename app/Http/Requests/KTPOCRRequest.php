<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Form Request untuk validasi Upload KTP OCR
 *
 * Security Features:
 * - ktp_image: required, file, mimes:png,jpg,jpeg, max:5MB
 * - MIME type check untuk mencegah file upload attack
 */
class KTPOCRRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'ktp_image' => 'required|file|mimes:png,jpg,jpeg|max:5120',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'ktp_image.required' => 'Gambar KTP harus diupload',
            'ktp_image.file' => 'KTP harus berupa file',
            'ktp_image.mimes' => 'Format gambar harus PNG, JPG, atau JPEG',
            'ktp_image.max' => 'Ukuran gambar maksimal 5MB',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422)
        );
    }

    /**
     * Additional validation after basic rules pass
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            /** @var \Illuminate\Http\UploadedFile|null $file */
            $file = $this->file('ktp_image');

            if ($file) {
                // Server-side MIME type check untuk mencegah spoofing
                $allowedMimes = ['image/png', 'image/jpeg', 'image/jpg'];
                $actualMime = $file->getMimeType();

                if (!in_array($actualMime, $allowedMimes)) {
                    $validator->errors()->add('ktp_image', 'Tipe file tidak diizinkan');
                }

                // Cek apakah file ini benar-benar gambar
                try {
                    @getimagesize($file->getPathname());
                } catch (\Exception $e) {
                    $validator->errors()->add('ktp_image', 'File bukan gambar yang valid');
                }
            }
        });
    }
}
