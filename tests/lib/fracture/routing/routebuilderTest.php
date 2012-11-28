<?php


    namespace Fracture\Routing;

    use Exception;
    use ReflectionClass;
    use PHPUnit_Framework_TestCase;


    class RouteBuilderTest extends PHPUnit_Framework_TestCase
    {


        public function test_Created_Interface()
        {
            $builder = new RouteBuilder;
            $instance = $builder->create( 'test', [ 'notation' => '' ] );
            
            $this->assertInstanceOf( 'Fracture\Routing\Matchable', $instance );
        }

    }


?>