<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;

trait HandlesValidationRequests
{
    /**
     *  Returns the validation rules for validation requests.
     * @return string[] Request rule pair.
     */
    protected function validationRequestRules(): array
    {
        return [
            'validation_requests.*' => 'nullable|exists:validation_requests,id',
        ];
    }

    /**
     * Deletes the specified validation requests from the given model.
     * @param Request $request web request.
     * @param $model
     * @return void
     */
    protected function deleteValidationRequests(Request $request, $model): void
    {
        if (!empty($request->input('validation_requests'))) {
            $model->deleteValidationRequestsByIds($request->input('validation_requests'));
        }
    }
}
