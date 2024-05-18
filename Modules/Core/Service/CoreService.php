<?php

namespace Modules\Core\Service;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Modules\Core\Interfaces\RepositoryInterface;

abstract class CoreService
{
    /**
     * @var RepositoryInterface
     */
    protected RepositoryInterface $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Retrieve all records.
     *
     * @return Collection<int, Model>
     */
    public function getAll(): Collection
    {
        return $this->repository->findAll();
    }

    /**
     * Retrieve a single entity by its ID.
     *
     * @param int $id
     * @return Model|null
     */
    public function findById(int $id): ?Model
    {
        return $this->repository->findById($id);
    }

    public function findBy(string $column, mixed $value): ?Model
    {
        return $this->repository->findBy($column, $value);
    }
    /**
     * Create a new record.
     *
     * @param array<string, mixed> $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->repository->create($data);
    }

    /**
     * Update an existing record.
     *
     * @param int $id
     * @param array<string, mixed> $data
     * @return Model
     */
    public function update(int $id, array $data): Model
    {
        return $this->repository->update($id, $data);
    }

    /**
     * Delete a record by its ID.
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }

    public function restore(int $id): ?Model
    {
        return $this->repository->restore($id);
    }

    public function findByIdWithTrashed(int $id): ?Model
    {
        return $this->repository->findByIdWithTrashed($id);
    }
}
