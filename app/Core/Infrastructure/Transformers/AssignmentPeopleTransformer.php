<?php

namespace App\Core\Infrastructure\Transformers;

use App\Core\Domain\Entities\AssignmentPeopleEntity;
use App\DTO\AssignmentPeopleDTO;

class AssignmentPeopleTransformer
{
    /**
     * Create a new class instance.
     */
    public static function toDTO(AssignmentPeopleEntity $assignmenPeople): AssignmentPeopleDTO
    {

        return new AssignmentPeopleDTO($assignmenPeople);
    }

    public static function toDTOs(array $assignmenPeoples): array
    {
        return array_map(function (AssignmentPeopleEntity $assignmenPeoples) {
            return self::toDTO($assignmenPeoples);
        }, $assignmenPeoples);
    }
}
