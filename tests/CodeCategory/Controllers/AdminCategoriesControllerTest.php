<?php

namespace CodePress\CodeCategory\Tests\Controllers;

use CodePress\CodeCategory\Controllers\AdminCategoriesController;
use CodePress\CodeCategory\Controllers\Controller;
use CodePress\CodeCategory\Models\Category;
use CodePress\CodeCategory\Tests\AbstractTestCase;
use Illuminate\Contracts\Routing\ResponseFactory;
use Mockery as m;

class AdminCategoriesControllerTest extends AbstractTestCase
{
    public function test_should_extend_from_controller()
    {
        $category   = m::mock(Category::class);
        $response   = m::mock(ResponseFactory::class);
        $controller = new AdminCategoriesController($response, $category);

        $this->assertInstanceOf(Controller::class, $controller);
    }

    public function test_controller_should_run_index_method_and_return_correct_arguments()
    {
        $category   = m::mock(Category::class);
        $response   = m::mock(ResponseFactory::class);
        $html       = m::mock();
        $controller = new AdminCategoriesController($response, $category);

        $categoryResult = array('cat1', 'cat2', 'cat3', 'cat4');
        $category->shouldReceive('all')->andReturn($categoryResult);

        $response->shouldReceive('view')
            ->with('codetag::index', array('categories' => $categoryResult))
            ->andReturn($html);

        $this->assertEquals($controller->index(), $html);
    }
}