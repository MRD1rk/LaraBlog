<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class CoreRepository  {

    /**
     * @var Model
     */
    protected $model;

    /**
     * CoreRepository constructor.
     */
    public function __construct()
    {
        $this->model = app($this->getModelClass());
    }

    /**
     * @return mixed
     */
    abstract protected function getModelClass();

    /**
     * @return \App\Repositories\CoreRepository.getModelClass|Model|\Illuminate\Foundation\Application|mixed
     */
    public function startConditions()
    {
        return clone $this->model;
    }

}
