<?php

namespace CodePress\CodeCategory\Tests\Controllers;

use CodePress\CodeCategory\Controllers\AdminCategoriesController;
use CodePress\CodeCategory\Controllers\Controller;
use CodePress\CodeCategory\Models\Category;
use CodePress\CodeCategory\Repository\CategoryRepository;
use CodePress\CodeCategory\Tests\AbstractTestCase;
use Illuminate\Contracts\Routing\ResponseFactory;
use Mockery as m;

class AdminCategoriesControllerTest extends AbstractTestCase
{
    public function test_should_extend_from_controller()
    {
        $repository   = m::mock(CategoryRepository::class);
        $response   = m::mock(ResponseFactory::class);
        $controller = new AdminCategoriesController($response, $repository);

        $this->assertInstanceOf(Controller::class, $controller);
    }

    public function test_controller_should_run_index_method_and_return_correct_arguments()
    {
        $repository = m::mock(CategoryRepository::class);
        $response   = m::mock(ResponseFactory::class);
        $html       = m::mock();
        $controller = new AdminCategoriesController($response, $repository);

        $categoryResult = array('cat1', 'cat2', 'cat3', 'cat4');
        $repository
            ->shouldReceive('all')
            ->andReturn($categoryResult);

        $response
            ->shouldReceive('view')
            ->with('codecategory::index', array('categories' => $categoryResult))
            ->andReturn($html);

        $this->assertEquals($controller->index(), $html);
    }
}