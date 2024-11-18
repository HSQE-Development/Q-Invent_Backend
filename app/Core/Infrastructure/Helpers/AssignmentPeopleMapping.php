<?php

namespace App\Core\Infrastructure\Helpers;

use App\Core\Domain\Entities\AssignmentPeopleEntity;
use App\Models\AssignmentPeople;

class AssignmentPeopleMapping
{
    /**
     * Map a User model to a UserEntity.
     *
     * @param AssignmentPeople $product
     * @return AssignmentPeopleEntity
     */
    public static function mapToEntity(AssignmentPeople $people): AssignmentPeopleEntity
    {
        return new AssignmentPeopleEntity(
            id: $people->id,
            name: $people->name,
            phone: $people->phone,
            email: $people->email,
        );
    }
}
