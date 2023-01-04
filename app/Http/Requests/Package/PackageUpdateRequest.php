<?php

namespace App\Http\Requests\Package;

use Illuminate\Foundation\Http\FormRequest;

class PackageUpdateRequest extends FormRequest
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

            'title' => 'required|max:255',
            'price' => 'required',
            'term' => 'required',
            // 'course_categories_limit' => 'required',language_limit
            // 'featured_course_limit' => 'required',
            // 'course_limit' => 'required',
            // 'module_limit' => 'required',
            // 'lesson_limit' => 'required',

            'service_categories_limit' => 'required',
            'service_subcategories_limit' => 'required',
            'service_limit' => 'required',
            'service_orders_limit' => 'required',
            'invoice_limit' => 'required',
            'user_limit' => 'required',
            'post_limit' => 'required',
            'language_limit' => 'required',
            'vCard_limit' => in_array('vCard', $this->features) ? 'required' : '',
            'product_limit' => in_array('Shop Management', $this->features) ? 'required' : '',
            'product_orders_limit' => in_array('Shop Management', $this->features) ? 'required' : '',

            'trial_days' => $this->is_trial == "1" ? 'required' : '',
        ];
    }
    public function messages(): array
    {
        return [
            'trial_days.required' => 'Trial days is required when trial option is checked',
            'vCard_limit.required' => 'Number of vCard  is required when vCard option is checked',
            'product_limit.required' => 'Number of Product  is required when shop management option is checked',
            'product_orders_limit.required' => 'Number of Product Order  is required when shop management option is checked',
        ];
    }
}
