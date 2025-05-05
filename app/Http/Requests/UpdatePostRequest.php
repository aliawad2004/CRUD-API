<?php

// app/Http/Requests/UpdatePostRequest.php

namespace App\Http\Requests;

use App\Rules\PublishdateRule;
use App\Rules\SlugRule;
use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdatePostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'sometimes|string|max:255',
            'slug' => [
                'sometimes',
                'string',
                'max:255',
                new SlugRule,
            ],
            'body' => 'sometimes|string',
            'is_published' => 'sometimes|boolean',
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
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'slug.string' => 'The slug must be a string.',
            'slug.max' => 'The slug may not be greater than 255 characters.',
            'body.string' => 'The body must be a string.',
            'meta_description.string' => 'The meta description must be a string.',
            'meta_description.max' => 'The meta description may not be greater than 160 characters.',
            'tags.array' => 'The tags must be an array.',
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

    protected function prepareForValidation()
    {
        if (!$this->has('slug')) {
            $this->merge([
                'slug' => Str::slug($this->title),
            ]);
        }
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation errors',
            'errors' => $validator->errors(),
        ], 422));
    }
}
