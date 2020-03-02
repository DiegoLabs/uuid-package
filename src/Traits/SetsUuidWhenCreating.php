<?php

namespace Ddg\Lexted\Traits;

use App\Exceptions\InvalidUuidSuppliedException;
use Webpatser\Uuid\Uuid;

trait SetsUuidWhenCreating
{
    /**
     * Set the primary ID to a UUID.
     * Column must be configured to accept a UUID format
     *
     * @return void
     */
    public static function bootSetsUuidWhenCreating()
    {
        static::creating(function ($model) {
            $potentiallySuppliedIdentifier = $model->{$model->getKeyName()};

            // if the ID has been supplied, validate it's a version 4 uuid
            if ($potentiallySuppliedIdentifier && Uuid::import($potentiallySuppliedIdentifier)->version !== 4) {
                throw new InvalidUuidSuppliedException('Supplied identifier is invalid');
            }

            $model->{$model->getKeyName()} = $potentiallySuppliedIdentifier ?? Uuid::generate(4)->string;
        });
    }
}
