<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Repositories\BlogCategoryRepository;
use App\Repositories\BlogPostRepository;

class PostController extends BaseController
{
    /**
     * @var BlogPostRepository|\Illuminate\Foundation\Application|mixed
     */
    private $blogPostRepository;
    /**
     * @var BlogCategoryRepository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $blogCategoryRepository;

    public function __construct()
    {
        parent::__construct();
        $this->blogPostRepository = app(BlogPostRepository::class);
        $this->blogCategoryRepository = app(BlogCategoryRepository::class);
    }
    public function index()
    {
        $paginator = $this->blogPostRepository->getAllWithPaginate(15);

        return view('blog.admin.posts.index', compact('paginator'));
    }

    public function edit($id)
    {
        $item = $this->blogPostRepository->getForEdit($id);
        if (empty($item)) {
            abort(404);
        }
        $categoryList = $this->blogCategoryRepository->getForComboBox();
        return view('blog.admin.posts.edit', compact('categoryList','item'));
    }
}
