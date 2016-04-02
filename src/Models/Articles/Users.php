<?php

namespace NwWebsite\Models\Articles;

use NwWebsite\Models\Model;

class Users extends Model
{
    const STATUS_NEW = 0;
    const STATUS_READ = 1;
    const STATUS_DELETED = 2;
    const STATUS_TO_READ = 3;

    protected function getSerializableProperties()
    {
        $properties = parent::getSerializableProperties();
        // We remove nested objects as we can't update it
        unset($properties['article']);
        unset($properties['user']);

        return $properties;
    }
}
