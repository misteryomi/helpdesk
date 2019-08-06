<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\RequestValidationTrait;

class TicketRequest extends FormRequest
{

    use RequestValidationTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            // 'department_id' => 'required|exists:department,id',
            // 'unit_id' => 'required|exists:unit,id',
            'category_id' => 'required|exists:categories,id',
            'message' => 'required',
        ];
    }
}
