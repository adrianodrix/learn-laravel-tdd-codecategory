<?php

namespace CodePress\CodeCategory\Controllers;

use CodePress\CodeCategory\Models\Category;
use CodePress\CodeCategory\Repository\CategoryRepository;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;

class AdminCategoriesController extends Controller
{
    /**
     * @var CategoryRepository
     */
    private $repository;

    /**
     * @var ResponseFactory
     */
    private $response;

    public function __construct(ResponseFactory $response, CategoryRepository $repository)
    {
        $this->repository = $repository;
        $this->response = $response;
    }

    public function index()
    {
        $categories = $this->repository->paginate();
        return $this->response->view('codecategory::index', compact('categories'));
    }

    public function create()
    {
        $categories = $this->repository->all(['name', 'id']);
        $category   = new Category();
        $title      = 'Create Category';
        return $this->response->view('codecategory::form', compact('categories', 'category', 'title'));
    }

    public function store(Request $request)
    {
        if (is_numeric($request->get('id'))){
            $this->repository->update($request->all(), $request->get('id'));
        } else {
            $this->repository->create($request->all());
        }

        return redirect()->route('admin.categories.index');
    }

    public function edit($id) {
        $category   = $this->repository->find($id);
        $categories = $this->repository->all();
        $title      = 'Edit Category';
        return view('codecategory::form', compact('categories', 'category', 'title'));
    }

    public function destroy($id) {
        $this->repository->delete($id);
        \Session::flash('flash_message', 'Category has been deleted.');
        return redirect()->route('admin.categories.index');
    }
}