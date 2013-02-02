<?php


    namespace Fracture\Routing;

    use Exception;
    use ReflectionClass;
    use PHPUnit_Framework_TestCase;


    class RouterTest extends PHPUnit_Framework_TestCase
    {

        /**
         * @covers Fracture\Routing\Router::__construct
         * @covers Fracture\Routing\Router::import
         */
        public function test_Calling_Create_in_Import_for_Single_Route()
        {
            $builder = $this->getMock( 'RouteBuilder', ['create'] );
            $builder->expects($this->once())
                    ->method('create')
                    ->with($this->equalTo('test'),
                           $this->equalTo( [ 'notation' => '[/:alpha][/:beta]',
                                             'defaults' => [
                                                "alpha" => 'qux',
                                                "beta"  => 'qux' ]]));

            $router = new Router( $builder );
            $router->import( TEST_PATH . '/fixtures/configs/routes-single.json' );

        }


        /**
         * @covers Fracture\Routing\Router::__construct
         * @covers Fracture\Routing\Router::import
         */
        public function test_Calling_Create_in_Import_for_Several_Routes()
        {
            $builder = $this->getMock( 'RouteBuilder', ['create'] );
            $builder->expects($this->exactly(4))
                     ->method('create');

            $router = new Router( $builder );
            $router->import( TEST_PATH . '/fixtures/configs/routes-multiple.json' );

        }


        /**
         * @covers Fracture\Routing\Router::__construct
         * @covers Fracture\Routing\Router::import
         */
        public function test_Invalid_JSON_Import_Exception()
        {

            $this->setExpectedException('Exception');
            $builder = $this->getMock( 'RouteBuilder', ['create'] );

            $router = new Router( $builder );
            $router->import( TEST_PATH . '/fixtures/configs/routes-invalid.json' );

        }


        /**
         * @covers Fracture\Routing\Router::__construct
         * @covers Fracture\Routing\Router::import
         */
        public function test_Missing_JSON_Exception()
        {

            $this->setExpectedException('Exception');
            $builder = $this->getMock( 'RouteBuilder', ['create'] );

            $router = new Router( $builder );
            $router->import( TEST_PATH . '/fixtures/configs/routes-fake.json' );

        }


        /**
         * @dataProvider simple_Route_Provider
         * @covers Fracture\Routing\Router::__construct
         * @covers Fracture\Routing\Router::import
         * @covers Fracture\Routing\Router::route
         */
        public function test_Routing_With_Single_Route( $filepath, $uri, $expected )
        {
            $request = new \Mock\UserRequest( $uri );

            $builder = new RouteBuilder;
            $router = new Router( $builder );

            $router->import( TEST_PATH . $filepath );
            $router->route( $request );

            $this->assertEquals( $expected, $request->getParameters() );
        }


        public function simple_Route_Provider()
        {
            return include TEST_PATH . '/fixtures/routing/single-route-list.php';
        }

    }



