<?php

namespace Ddlabs\Uuid\Traits;

use Webpatser\Uuid\Uuid;
use Ddlabs\Uuid\Exceptions\InvalidUuidSuppliedException;
use Ddlabs\Uuid\Exceptions\InvalidModelConfigurationException;

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

            if ($model->incrementing != false) {
                throw new InvalidModelConfigurationException('Set $incrementing = false in your Model');
            }
            if ($model->keyType != 'string') {
                throw new InvalidModelConfigurationException('Set $keytype = \'string\' in your Model');
            }

            $potentiallySuppliedIdentifier = $model->{$model->getKeyName()};

            // if the ID has been supplied, validate it's a version 4 uuid
            if ($potentiallySuppliedIdentifier && Uuid::import($potentiallySuppliedIdentifier)->version !== 4) {
                throw new InvalidUuidSuppliedException('Supplied identifier is invalid');
            }

            $model->{$model->getKeyName()} = $potentiallySuppliedIdentifier ?? Uuid::generate(4)->string;
        });
    }
}
