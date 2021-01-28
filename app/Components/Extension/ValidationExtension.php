<?php

namespace App\Components\Extension;

use App\Components\Response\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadeValidator;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

trait ValidationExtension
{
    use ResponseFactory;

    /**
     * Validate the given request with given rules and messages.
     *
     * @param Request $request
     * @param array $rules
     * @param array $messages
     * @return void
     *
     * @throws ValidationException
     */
    protected function runValidator(Request $request, array $rules, array $messages = [])
    {
        $validator = FacadeValidator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            throw $this->buildException($validator, $this->getResponse($validator));
        }
    }

    /**
     * Build exception response.
     *
     * @param Validator $validator
     * @param JsonResponse $response
     * @return ValidationException
     */
    private function buildException(Validator $validator, JsonResponse $response): ValidationException
    {
        return new ValidationException($validator, $response);
    }

    /**
     * Get appropriate validation response.
     *
     * @param Validator $validator
     * @return JsonResponse
     */
    private function getResponse(Validator $validator)
    {
        return $this->unprocessableEntity(
            [
                'message' => 'Incorrect input data.',
                'validation_messages' => $validator->errors()->getMessages(),
                'status' => 422
            ]
        );
    }
}
