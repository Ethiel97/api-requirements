<?php

namespace App\Infrastructure\Http\Requests;

use App\Domain\Product\Models\Category;
use App\Domain\Product\Models\FilterParams;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Enum;
use Symfony\Component\HttpFoundation\Response;

class ProductRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'category' => new Enum(Category::class),
            'price' => 'integer'
        ];
    }

    public function filter(): FilterParams
    {
        $filterParamsDTO = new FilterParams();
        $validated_fields = (array)$this->validated();

        foreach ($validated_fields as $field => $value) {
            if (property_exists($filterParamsDTO, $field)) {
                $filterParamsDTO->$field = $value;
            }
        }

        return $filterParamsDTO;
    }

    /**
     * Customize the response when validation fails
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'errors' => $validator->errors()->toArray()
            ], Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}

//docker run --rm --pull=always -v "":/opt -w /opt laravelsail/php81-composer:latest bash -c "laravel new hqrs && cd hqrs && php ./artisan sail:install --with=mysql,redis,meilisearch,mailhog,selenium "
