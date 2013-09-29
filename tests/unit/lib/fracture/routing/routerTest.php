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
         *
         * @covers Fracture\Routing\Router::createRoutes
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

            $json = file_get_contents( FIXTURE_PATH . '/configs/routes-single.json' );
            $config = json_decode( $json, true );

            $router = new Router( $builder );
            $router->import( $config );

        }


        /**
         * @covers Fracture\Routing\Router::__construct
         * @covers Fracture\Routing\Router::import
         *
         * @covers Fracture\Routing\Router::createRoutes
         */
        public function test_Calling_Create_in_Import_for_Several_Routes()
        {
            $builder = $this->getMock( 'RouteBuilder', ['create'] );
            $builder->expects($this->exactly(4))
                     ->method('create');

            $json = file_get_contents( FIXTURE_PATH . '/configs/routes-multiple.json' );
            $config = json_decode( $json, true );

            $router = new Router( $builder );
            $router->import( $config );

        }


        /**
         * @covers Fracture\Routing\Router::__construct
         * @covers Fracture\Routing\Router::import
         * @covers Fracture\Routing\Router::route
         *
         * @covers Fracture\Routing\Router::createRoutes
         * @covers Fracture\Routing\Router::gatherRouteValues
         */
        public function test_Routing_With_No_Routes()
        {
            $request = new \Mock\UserRequest( '/not/important' );

            $builder = new RouteBuilder;
            $router = new Router( $builder );

            $router->import( [] );
            $router->route( $request );

            $this->assertEquals( [], $request->getParameters() );
        }


        /**
         * @covers Fracture\Routing\Router::__construct
         * @covers Fracture\Routing\Router::import
         * @covers Fracture\Routing\Router::route
         *
         * @covers Fracture\Routing\Router::createRoutes
         * @covers Fracture\Routing\Router::gatherRouteValues
         *
         * @dataProvider simple_Route_Provider
         */
        public function test_Routing_With_Single_Route( $filepath, $uri, $expected )
        {
            $request = new \Mock\UserRequest( $uri );

            $builder = new RouteBuilder;
            $router = new Router( $builder );

            $json = file_get_contents( FIXTURE_PATH . $filepath );
            $config = json_decode( $json, true );

            $router->import( $config );
            $router->route( $request );

            $this->assertEquals( $expected, $request->getParameters() );
        }


        public function simple_Route_Provider()
        {
            return include FIXTURE_PATH . '/routing/single-route-list.php';
        }

    }
