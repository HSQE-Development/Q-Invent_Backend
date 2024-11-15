<?php

namespace App\Core\Infrastructure\Transformers;

use App\Core\Domain\Entities\AssignmenPeopleEntity;
use App\DTO\AssignmentPeopleDTO;

class AssignmentPeopleTransformer
{
    /**
     * Create a new class instance.
     */
    public static function toDTO(AssignmenPeopleEntity $assignmenPeople): AssignmentPeopleDTO
    {

        return new AssignmentPeopleDTO($assignmenPeople);
    }

    public static function toDTOs(array $assignmenPeoples): array
    {
        return array_map(function (AssignmenPeopleEntity $assignmenPeoples) {
            return self::toDTO($assignmenPeoples);
        }, $assignmenPeoples);
    }
}
