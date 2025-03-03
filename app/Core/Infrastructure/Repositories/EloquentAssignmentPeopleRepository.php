<?php

namespace App\Core\Infrastructure\Repositories;

use App\Core\Domain\Entities\AssignmentPeopleEntity;
use App\Core\Domain\Repositories\AssignmentPeopleRepositoryInterface;
use App\Core\Infrastructure\Helpers\AssignmentPeopleMapping;
use App\Core\Infrastructure\Helpers\PaginationMapping;
use App\Core\Infrastructure\Transformers\AssignmentPeopleTransformer;
use App\Models\AssignmentPeople;

class EloquentAssignmentPeopleRepository implements AssignmentPeopleRepositoryInterface
{
    public function index($filters = [])
    {
        $assignmentPeople = AssignmentPeople::query()->get();
        return collect($assignmentPeople)->map(function ($eloquentPeople) {
            return AssignmentPeopleMapping::mapToEntity($eloquentPeople);
        })->toArray();
    }

    public function allPaginate($filters = []): array
    {
        $page = $filters['page'] ?? 1; // Página actual
        $perPage =  $filters['per_page'] ?? 50;

        $peopleName = $filters['peopleName'] ?? null;

        $query = AssignmentPeople::query();

        if ($peopleName) {
            $query->where("name", "LIKE", "%$peopleName%");
        }

        $eloquentPeoples = $query->with("products")->paginate($perPage, ["*"], "page", $page);
        $mappedPeoples = $eloquentPeoples->items();

        $mappedPeoples = collect($mappedPeoples)->map(function ($eloquentPeople) {
            return AssignmentPeopleMapping::mapToEntity($eloquentPeople);
        })->toArray();

        return PaginationMapping::mapToEntity(AssignmentPeopleTransformer::toDTOs($mappedPeoples), $eloquentPeoples)->toArray();
    }
    public function getById($id): ?AssignmentPeopleEntity
    {
        $eloquentUser =  AssignmentPeople::find($id);
        return $eloquentUser ? AssignmentPeopleMapping::mapToEntity($eloquentUser) : null;
    }
    public function getByIds($ids): array
    {
        $eloquentProduct =  AssignmentPeople::whereIn("id", $ids)->get();
        if ($eloquentProduct->isEmpty()) {
            throw new \Exception("Uno o más productos no encontrados", 404);
        }
        return $eloquentProduct->map(fn($people) => AssignmentPeopleMapping::mapToEntity($people))->toArray();
    }

    public function getByEspecificColumn($search): AssignmentPeopleEntity|null
    {
        $eloquentPeople = AssignmentPeople::where($search)->first();
        return $eloquentPeople ? AssignmentPeopleMapping::mapToEntity($eloquentPeople) : null;
    }

    public function store(AssignmentPeopleEntity $product): AssignmentPeopleEntity
    {
        $eloquentPeople = new AssignmentPeople();
        $eloquentPeople->name = $product->getName();
        $eloquentPeople->email = $product->getEmail();
        $eloquentPeople->phone = $product->getPhone();
        $eloquentPeople->save();
        $product->setId($eloquentPeople->id);

        return $product;
    }

    public function update(AssignmentPeopleEntity $user, int $id): AssignmentPeopleEntity
    {
        $model = AssignmentPeople::find($id);
        if ($model) {
            $model->fill([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'phone' => $user->getPhone(),
            ]);
            $model->save();
        }
        return $user;
    }

    public function updateEspecificColumn(int $id, array $data_to_change): ?AssignmentPeopleEntity
    {
        $model = AssignmentPeople::find($id);
        if ($model) {
            $model->fill($data_to_change);
            $model->save();
            return AssignmentPeopleMapping::mapToEntity($model);
        }
        return null;
    }

    public function delete($id): bool
    {
        return AssignmentPeople::destroy($id);
    }
}
