<?php

namespace App\Repositories;
use App\Models\BlogCategory as Model;

class BlogCategoryRepository extends CoreRepository
{
    protected function getModelClass(): string
    {
        return Model::class;
    }

    public function getForEdit($id)
    {
        return $this->startConditions()->find($id);
    }

    public function getForComboBox()
    {
        $columns = implode(', ',[
            'id',
            'CONCAT (id, ". ", title) as title',
        ]);
        $result = $this
            ->startConditions()
            ->selectRaw($columns)
            ->toBase()
            ->get();
        return $result;
    }

    public function getAllWithPaginate($perPage = 5)
    {
        $columns = [
            'id',
            'title',
            'parent_id'
        ];
        $result = $this->startConditions()
            ->paginate($perPage, $columns);
        return $result;
    }
}
