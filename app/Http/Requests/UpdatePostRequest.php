<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            //
            'author_id' => 'nullable|exists:users,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('posts', 'slug')->ignore($this->post->id)],
            'photo_id' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
            'categories' => 'array|required',
            'categories.*' => 'exists:categories,id',
        ];
    }
    public function messages(): array
    {
        return [
            'author_id.required' => 'Een auteur is verplicht.',
            'author_id.exists' => 'De geselecteerde auteur bestaat niet.',
            'title.required' => 'De titel is verplicht.',
            'title.string' => 'De titel moet tekst bevatten.',
            'title.max' => 'De titel mag maximaal 255 tekens lang zijn.',
            'content.required' => 'De inhoud van de post is verplicht.',
            'content.string' => 'De inhoud moet een tekst zijn.',
            'slug.string' => 'De slug moet tekst bevatten.',
            'slug.max' => 'De slug mag maximaal 255 tekens lang zijn.',
            'slug.unique' => 'Deze slug wordt al gebruikt door een andere post.',
            'photo_id.image' => 'De geüploade foto moet een geldig afbeeldingsbestand zijn.',
            'photo_id.max' => 'De afbeelding mag maximaal 2MB groot zijn.',
            'is_published.boolean' => 'De publicatiestatus moet waar of onwaar zijn.',
            'categories.required' => 'Selecteer minstens één categorie.',
            'categories.array' => 'De categorieën moeten een array zijn.',
            'categories.*.exists' => 'Eén of meer geselecteerde categorieën bestaan niet in het systeem.',
        ];
    }
}
