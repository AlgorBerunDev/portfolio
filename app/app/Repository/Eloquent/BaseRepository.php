<?php

namespace App\Repository\Eloquent;

use App\Exceptions\Exceptions;
use App\Repository\Contracts\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BaseRepository implements EloquentRepositoryInterface
{

    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor
     *
     * @param  Model $model
     * @return void
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all models
     *
     * @param array $columns
     * @param array $relations
     * @return Collection
     */
    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->with($relations)->get($columns);
    }

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
    ): ?Model
    {
        return $this->model->find($modelId);
    }

    /**
     * Create a model
     *
     * @param array $payload
     * @return Model
     */
    public function create(array $payload): ?Model
    {
        $model = $this->model->create($payload);

        return $model->fresh();
    }

    /**
     * Update existing model.
     *
     * @param int $modelId
     *
     * @param int $modelId
     * @param array $payload
     * @return bool
     */
    public function updateById(int $modelId, array $payload): ?Model
    {
        if(!empty($payload)) DB::table($this->model->getTable())
                                ->where('id', $modelId)
                                ->update($payload);
        return $this->findById($modelId);
    }

    /**
     * Update existing model.
     *
     * @param int $modelId
     *
     * @param int $modelId
     * @param array $payload
     * @return bool
     */
    public function update(array $condition_attributes, array $payload): int
    {
        $result = DB::table($this->model->getTable())
            ->where($condition_attributes)
            ->update($payload);

        return $result;
    }

    /**
     * Delete model by id.
     *
     * @param int $modelId
     * @return bool
     */
    public function deleteById(int $modelId): bool
    {
        $model = $this->model->find($modelId);
        if(!$model) {
            throw new Exceptions(Exceptions::NOT_FOUND);
        }
        return $model->delete();
    }
}
