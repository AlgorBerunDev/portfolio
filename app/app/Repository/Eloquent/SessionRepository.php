<?php
namespace App\Repository\Eloquent;

use App\Models\Session;
use App\Repository\Contracts\SessionRepositoryInterface;

class SessionRepository extends BaseRepository implements SessionRepositoryInterface
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
    public function __construct(Session $model)
    {
        $this->model = $model;
    }
}
