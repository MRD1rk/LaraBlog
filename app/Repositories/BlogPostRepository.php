<?php

namespace App\Repositories;
use App\Models\BlogPost as Model;

class BlogPostRepository extends CoreRepository
{
    protected function getModelClass(): string
    {
        return Model::class;
    }

    public function getAllWithPaginate($perPage = 5)
    {
        $columns = [
            'id',
            'title',
            'slug',
            'is_published',
            'published_at',
            'user_id',
            'category_id'
        ];
        $result = $this->startConditions()
            ->orderBy('id', 'DESC')
            ->select($columns)
            ->paginate($perPage);
        return $result;
    }
}
