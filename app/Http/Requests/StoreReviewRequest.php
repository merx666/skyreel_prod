<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'job_id' => ['required', 'integer', Rule::exists('job_listings', 'id')],
            'reviewee_id' => ['required', 'integer', Rule::exists('users', 'id')],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'job_id.required' => 'Identyfikator zlecenia jest wymagany.',
            'job_id.integer' => 'Identyfikator zlecenia musi być liczbą.',
            'job_id.exists' => 'Wybrane zlecenie nie istnieje.',
            'reviewee_id.required' => 'Identyfikator ocenianego użytkownika jest wymagany.',
            'reviewee_id.integer' => 'Identyfikator ocenianego użytkownika musi być liczbą.',
            'reviewee_id.exists' => 'Oceniany użytkownik nie istnieje.',
            'rating.required' => 'Ocena jest wymagana.',
            'rating.integer' => 'Ocena musi być liczbą całkowitą.',
            'rating.min' => 'Ocena nie może być mniejsza niż 1.',
            'rating.max' => 'Ocena nie może być większa niż 5.',
            'comment.required' => 'Komentarz jest wymagany.',
            'comment.string' => 'Komentarz musi być tekstem.',
            'comment.max' => 'Komentarz nie może przekraczać 1000 znaków.',
        ];
    }
}