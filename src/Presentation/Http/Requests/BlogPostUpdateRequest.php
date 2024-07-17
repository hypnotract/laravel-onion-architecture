<?php

namespace Presentation\Http\Requests;

use Domain\Validations\BlogPostValidation;
use Illuminate\Foundation\Http\FormRequest;

class BlogPostUpdateRequest extends FormRequest
{
    /**
     * @return array<string, string>
     */
    public function rules(): array
    {
        return app(BlogPostValidation::class)->getUpdateRules();
    }
}
