<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AvailableCarsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'start_datetime' => [
                'nullable',
                'date',
                'after:now',
                'required_with:end_datetime'
            ],
            'end_datetime' => [
                'nullable',
                'date',
                'after:start_datetime',
                'required_with:start_datetime'
            ],
            'model' => 'nullable|string|max:50',
            'brand' => 'nullable|string|max:50',
            'comfort_category_id' => 'nullable|integer|exists:comfort_categories,id',
            'comfort_level' => 'nullable|integer|min:1|max:4',
            'per_page' => 'nullable|integer|min:1|max:100',
            'sort_by' => 'nullable|string|in:brand,model,year,comfort_category_id',
            'sort_order' => 'nullable|string|in:asc,desc',
        ];
    }

    public function messages(): array
    {
        return [
            'start_datetime.after' => 'Время начала должно быть в будущем',
            'end_datetime.after' => 'Время окончания должно быть после времени начала',
            'start_datetime.required_with' => 'Время начала обязательно при указании времени окончания',
            'end_datetime.required_with' => 'Время окончания обязательно при указании времени начала',
            'comfort_category_id.exists' => 'Указанная категория комфорта не существует',
            'per_page.max' => 'Максимальное количество записей на страницу: 100',
            'sort_by.in' => 'Сортировка возможна только по: brand, model, year, comfort_category_id',
            'sort_order.in' => 'Порядок сортировки: asc или desc',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Ошибка валидации данных',
                'errors' => $validator->errors()
            ], 422)
        );
    }
}
