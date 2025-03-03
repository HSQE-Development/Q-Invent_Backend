<?php

namespace App\Core\Application\UseCases\AssignmentPeople;

use App\Core\Domain\Repositories\AssignmentPeopleRepositoryInterface;

class FindAllPeopleWithPagination
{
    protected AssignmentPeopleRepositoryInterface $assignmentPeopleRepositoryInterface;
    public function __construct(
        AssignmentPeopleRepositoryInterface $assignmentPeopleRepositoryInterface
    ) {
        $this->assignmentPeopleRepositoryInterface = $assignmentPeopleRepositoryInterface;
    }

    public function execute($querys = [])
    {
        return $this->assignmentPeopleRepositoryInterface->allPaginate($querys);
    }
}
