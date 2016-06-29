<?php

namespace CodePress\CodeCategory\Controllers;

use CodePress\CodeCategory\Models\Category;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;

class AdminCategoriesController extends Controller
{
    /**
     * @var Category
     */
    private $category;

    /**
     * @var ResponseFactory
     */
    private $response;

    public function __construct(ResponseFactory $response, Category $category)
    {
        $this->category = $category;
        $this->response = $response;
    }

    public function index()
    {
        $categories = $this->category->paginate(5);
        return $this->response->view('codecategory::index', compact('categories'));
    }

    public function create()
    {
        $categories = $this->category->pluck('name', 'id');
        $category   = new Category();
        $title      = 'Create Category';
        return $this->response->view('codecategory::form', compact('categories', 'category', 'title'));
    }

    public function store(Request $request)
    {
        if (is_numeric($request->get('id'))){
            $category  = Category::findOrFail($request->get('id'));
            $category->update($request->all());
        } else {
            $this->category->create($request->all());
        }

        return redirect()->route('admin.categories.index');
    }

    public function edit($id) {
        $category   = Category::findOrFail($id);
        $categories = $this->category->pluck('name', 'id');
        $title      = 'Edit Category';
        return view('codecategory::form', compact('categories', 'category', 'title'));
    }

    public function destroy($id) {
        Category::find($id)->delete();
        \Session::flash('flash_message', 'Category has been deleted.');
        return redirect()->route('admin.categories.index');
    }
}