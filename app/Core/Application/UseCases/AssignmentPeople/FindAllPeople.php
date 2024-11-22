<?php

namespace App\Core\Application\UseCases\AssignmentPeople;

use App\Core\Domain\Repositories\AssignmentPeopleRepositoryInterface;
use App\Core\Infrastructure\Transformers\AssignmentPeopleTransformer;

class FindAllPeople
{
    protected AssignmentPeopleRepositoryInterface $assignmentPeopleRepositoryInterface;
    public function __construct(
        AssignmentPeopleRepositoryInterface $assignmentPeopleRepositoryInterface
    ) {
        $this->assignmentPeopleRepositoryInterface = $assignmentPeopleRepositoryInterface;
    }

    public function execute($querys = [])
    {
        return AssignmentPeopleTransformer::toDTOs($this->assignmentPeopleRepositoryInterface->index($querys));
    }
}
