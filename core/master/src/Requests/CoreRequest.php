<?php

namespace Core\Master\Requests;

use Core\Master\Exceptions\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

abstract class CoreRequest extends FormRequest
{
    use FormatMessageTrait;

    /**
     * @var type
     */
    protected $message;

    /**
     * Custom bad request
     * @param Validator $validator 
     * @author TrinhLe
     */
    public function failedValidation(Validator $validator)
    {
        if ($this->expectsJson()) {
            
            $json = [
                'status'    => RESPONSE_STATUS_VALIDATION_ERROR,
                'data'      => $this->customErrors($validator->errors()->getMessages()),
            ];

            if($this->message)
                $json['message'] = $this->message;

            $response = new JsonResponse($json, 400 );
            throw (new ValidationException($validator, $response))->status(400);
        }

        throw (new ValidationException($validator))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @author TrinhLe
     * @return void
     */
    public function withValidator($validator)
    {
        if($validator->passes()){
            $this->afterPasses();
        }
    }

    /**
     * Format data after passed
     * @author TrinhLe
     */
    protected function afterPasses(){}
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     * @author TrinhLe
     */
    public function authorize()
    {
        return true;
    }
}
