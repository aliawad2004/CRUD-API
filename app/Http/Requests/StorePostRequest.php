<?php

namespace App\Http\Requests;

use App\Rules\PublishdateRule;
use App\Rules\SlugRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
    protected function prepareForValidation()
    {
        if (!$this->has('slug')) {
            $this->merge([
                'slug' => Str::slug($this->title)
            ]);
        }
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:posts,slug',
                new SlugRule,
            ],
            'body' => 'required|string',
            'is_published' => 'boolean',
            'publish_date' => [
                'nullable',
                'date',
                new PublishdateRule,
            ],
            'meta_description' => 'nullable|string|max:160',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',

        ];
    }

    public function messages()
    {
        return [
            
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'slug.string' => 'The slug must be a string.',
            'slug.max' => 'The slug may not be greater than 255 characters.',
            'slug.unique' => 'This slug is already in use.',
            'body.required' => 'The content field is required.',
            'body.string' => 'The content must be a string.',
            'meta_description.string' => 'The meta description must be a string.',
            'meta_description.max' => 'The meta description may not be greater than 160 characters.',
            'tags.array' => 'The tags must be provided as an array.',
            'tags.*.string' => 'Each tag must be a string value.',
            'tags.*.max' => 'Each tag may not be greater than 50 characters.',


        ];
    }

    public function attributes()
    {
        return [
            'title' => 'title',
            'slug' => 'slug',
            'body' => 'body',
            'is_published' => 'is_published',
            'publish_date' => 'publish_date',
            'meta_description' => 'meta_description',
            'tags' => 'tags',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'errors' => $validator->errors()
        ], 422));
    }
}
