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
            $builder = $this->getMock( 'Fracture\Routing\RouteBuilder', ['create'] );
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
            $builder = $this->getMock( 'Fracture\Routing\RouteBuilder', ['create'] );
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

            $request = $this->getMock( 'Fracture\Http\Request', [ 'getUri', 'setParameters' ] );
            $request->expects( $this->once() )
                    ->method( 'getUri' )
                    ->will( $this->returnValue( '/not/important' ) );

            $request->expects( $this->once() )
                    ->method( 'setParameters' )
                    ->with( $this->equalTo( [] ) );



            $builder = $this->getMock( 'Fracture\Routing\RouteBuilder', [ 'create' ] );
            $builder->expects( $this->never() )
                    ->method( 'create' );

            $router = new Router( $builder );

            $router->import( [] );
            $router->route( $request );
        }


        /**
         * @covers Fracture\Routing\Router::__construct
         * @covers Fracture\Routing\Router::import
         * @covers Fracture\Routing\Router::route
         *
         * @covers Fracture\Routing\Router::createRoutes
         * @covers Fracture\Routing\Router::gatherRouteValues
         */
        public function test_Routing_With_Single_Route()
        {
            $url = '/foo';
            $parameters = [ [ 'foo' => 'bar' ] ];
            $config = [ "test" => [] ];

            $route = $this->getMock( 'Fracture\Routing\Route', [ 'getMatch' ], [ '', '' ] );
            $route->expects( $this->once() )
                  ->method( 'getMatch' )
                  ->will( $this->returnValue( $parameters ) );

            $request = $this->getMock( 'Fracture\Http\Request', [ 'getUri', 'setParameters' ] );
            $request->expects( $this->once() )
                    ->method( 'getUri' )
                    ->will( $this->returnValue( $url ) );
            $request->expects( $this->once() )
                    ->method( 'setParameters' )
                    ->with( $this->equalTo( $parameters ) );


            $builder = $this->getMock( 'Fracture\Routing\RouteBuilder', [ 'create' ] );
            $builder->expects( $this->once() )
                    ->method( 'create' )
                    ->will( $this->returnValue( $route ) );


            $instance = new Router( $builder );
            $instance->import( $config );
            $instance->route( $request );
        }


    }
