<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRespoRequest extends FormRequest
{
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
           'order_id' => 'required|integer',
           'plan_id' => 'required|integer',
           'status' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'order_id.required' => 'Order is required!',
            'plan_id.required' => 'Plan is required!',
            'status' => 'required'
        ];
    }
}
