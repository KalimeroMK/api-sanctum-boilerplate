<?php

namespace Modules\Core\Interfaces;

interface RepositoryInterface
{
   
    public function findAll();

    /**
     * @param  int  $id
     */
    public function findById(int $id);

    /**
     * @param  string  $column
     * @param $value
     */
    public function findBy(string $column, $value);

    /**
     * @param  array  $data
     */
    public function create(array $data);

    /**
     * @param  int  $id
     * @param  array  $data
     */
    public function update(int $id, array $data);

    /**
     * @param  int  $id
     */
    public function delete(int $id);

    /**
     * @param  int  $id
     */
    public function restore(int $id);

    /**
     * @param  int  $id
     */
    public function findByIdWithTrashed(int $id);
}
