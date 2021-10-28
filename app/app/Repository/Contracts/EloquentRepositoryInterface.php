<?php
namespace App\Repository\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface EloquentRepositoryInterface {
    /**
     * Get all models
     *
     * @param array $columns
     * @param array $relations
     * @return Collection
     */
    public function all(array $columns = ['*'], array $relations = []): Collection;

    /**
     * Find model by id.
     *
     * @param int $modelId
     * @param array $columns
     * @param array $relations
     * @param array $appends
     * @return Model
     */
    public function findById(
        int $modelId,
        array $columns = ['*'],
        array $relations = [],
        array $appends = []
    ): ?Model;


    /**
     * Create a model
     *
     * @param array $payload
     * @return Model
     */
    public function create(array $payload): ?Model;

    /**
     * Update existing model.
     *
     * @param int $modelId
     *
     * @param int $modelId
     * @param array $payload
     * @return bool
     */
    public function updateById(int $modelId, array $payload): ?Model;

    /**
     * Update existing model.
     *
     * @param int $modelId
     *
     * @param int $modelId
     * @param array $payload
     * @return bool
     */
    public function update(array $condition_attributes, array $payload): int;

    /**
     * Delete model by id.
     *
     * @param int $modelId
     * @return bool
     */
    public function deleteById(int $modelId): bool;
}
