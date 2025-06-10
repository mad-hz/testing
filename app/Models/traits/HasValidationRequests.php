<?php

namespace App\Models\traits;
use App\Models\ValidationRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasValidationRequests
{
    public function validationRequests(): MorphMany
    {
        return $this->morphMany(ValidationRequest::class, 'validatable');
    }

    /**
     * Check if the content has any validation requests.
     * @return bool true if there is no validation request.
     */
    public function isValid(): bool
    {
        return $this->validationRequests()->count() <= 0;
    }

    /**
     * Delete all the validation requests based on ids.
     * @param array|Collection $ids ids of validation requests.
     * @return void
     */
    public function deleteValidationRequestsByIds(array|Collection $ids): void
    {
        $this->validationRequests()
            ->whereIn('id', $ids)
            ->delete();
    }
}
