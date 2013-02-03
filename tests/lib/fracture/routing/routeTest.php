<?php


    namespace Fracture\Routing;

    use Exception;
    use ReflectionClass;
    use PHPUnit_Framework_TestCase;


    class RouteTest  extends PHPUnit_Framework_TestCase
    {

        /**
         * @covers Fracture\Routing\Route::__construct
         * @covers Fracture\Routing\Route::getMatch
         *
         * @covers Fracture\Routing\Route::cleanMatches
         */
        public function test_Pattern_Expression_Retrieved()
        {
            $pattern = $this->getMock( 'Pattern', ['getExpression'] );
            $pattern->expects($this->once())
                    ->method('getExpression')
                    ->will($this->returnValue('##'));


            $unit = new Route( $pattern, 'foo' );
            $unit->getMatch('/uri');
        }

        /**
         * @dataProvider simple_Match_Provider
         * @covers Fracture\Routing\Route::__construct
         * @covers Fracture\Routing\Route::getMatch
         *
         * @covers Fracture\Routing\Route::cleanMatches
         *
         * @depends test_Pattern_Expression_Retrieved
         */
        public function test_Simple_Matches( $expression, $url, $expected )
        {
            $pattern = new \Mock\Pattern( $expression );
            $route = new Route( $pattern, 'not-important' );
            $this->assertEquals( $expected, $route->getMatch( $url ) );
        }

        public function  simple_Match_Provider()
        {
            return include TEST_PATH . '/fixtures/routing/routes-simple.php';
        }


        /**
         * @dataProvider with_Defaults_Match_Provider
         * @covers Fracture\Routing\Route::__construct
         * @covers Fracture\Routing\Route::getMatch
         *
         * @covers Fracture\Routing\Route::cleanMatches
         *
         * @depends test_Pattern_Expression_Retrieved
         */
        public function test_With_Default_Matches( $expression, $url, $defaults, $expected )
        {
            $pattern = new \Mock\Pattern( $expression );
            $route = new Route( $pattern, 'not-important', $defaults );
            $this->assertEquals( $expected, $route->getMatch( $url ) );
        }

        public function  with_Defaults_Match_Provider()
        {
            return include TEST_PATH . '/fixtures/routing/routes-with-defaults.php';
        }


        /**
         * @dataProvider failing_Match_Provider
         * @covers Fracture\Routing\Route::__construct
         * @covers Fracture\Routing\Route::getMatch
         *
         * @covers Fracture\Routing\Route::cleanMatches
         *
         * @depends test_Pattern_Expression_Retrieved
         */
        public function test_Failing_Matches( $expression, $url )
        {
            $pattern = new \Mock\Pattern( $expression );
            $route = new Route( $pattern, 'not-important' );
            $this->assertFalse( $route->getMatch( $url ) );
        }

        public function  failing_Match_Provider()
        {
            return include TEST_PATH . '/fixtures/routing/routes-unmatched.php';
        }


    }


?>