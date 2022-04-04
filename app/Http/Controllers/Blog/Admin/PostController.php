<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Repositories\BlogPostRepository;

class PostController extends BaseController
{
    /**
     * @var BlogPostRepository|\Illuminate\Foundation\Application|mixed
     */
    private $blogPostRepository;

    public function __construct()
    {
        parent::__construct();
        $this->blogPostRepository = app(BlogPostRepository::class);
    }
    public function index()
    {
        $paginator = $this->blogPostRepository->getAllWithPaginate(15);

        return view('blog.admin.posts.index', compact('paginator'));
    }
}
