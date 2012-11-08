<?php


    class RouteBuilderTest extends PHPUnit_Framework_TestCase
    {


        public function test_Created_Interface()
        {
            $builder = new Fracture\Routing\RouteBuilder;
            $instance = $builder->create( 'test', [ 'notation' => '' ] );
            
            $this->assertInstanceOf( 'Fracture\Routing\Matchable', $instance );
        }

    }


?>