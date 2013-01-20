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
                           $this->equalTo( [ 'notation' => '[/:alpha][:/beta]',
                                             'defaults' => [
                                                "alpha" => 'qux',
                                                "beta"  => 'qux' ]]));

            $router = new Router( $builder );
            $router->import( __DIR__ . '/../../../fixtures/configs/routes-single.json' );
            
        }


        /**
         * @covers Fracture\Routing\Router::__construct
         * @covers Fracture\Routing\Router::import
         */
        public function test_Calling_Create_in_Import_for_Several_Routes()
        {
            $builder = $this->getMock( 'RouteBuilder', ['create'] );
            $builder->expects($this->exactly(3))
                     ->method('create');

            $router = new Router( $builder );
            $router->import( __DIR__ . '/../../../fixtures/configs/routes-multiple.json' );
            
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
            $router->import( __DIR__ . '/../../../fixtures/configs/routes-invalid.json' );

        }


        /**
         * @covers Fracture\Routing\Router::import
         */
        public function test_Missing_JSON_Exception()
        {

            $this->setExpectedException('Exception');
            $builder = $this->getMock( 'RouteBuilder', ['create'] );

            $router = new Router( $builder );
            $router->import( __DIR__ . '/../../../fixtures/configs/routes-fake.json' );

        }


    }



