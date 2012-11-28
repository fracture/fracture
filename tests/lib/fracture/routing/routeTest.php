<?php


    namespace Fracture\Routing;

    use Exception;
    use ReflectionClass;
    use PHPUnit_Framework_TestCase;


    class RouteTest  extends PHPUnit_Framework_TestCase
    {

        protected $builder;


        public function setUp()
        {
            $this->builder = new RouteBuilder;
        }

        /**
         * @dataProvider successfulMatchProvider
         */
        public function test_Successful_Matches( $name, $parameters, $urls, $expected )
        {
            $route = $this->builder->create( $name, $parameters );

            foreach ( $urls as $key => $url )
            {
                $data = $route->getMatch( $url );
                $this->assertEquals( $expected[ $key ], $data );
            }
        }

        public function successfulMatchProvider()
        {
            $foo = '0';
            return include __DIR__ . '/../../../fixtures/routing-matches-successful.php';
        }



        /**
         * @dataProvider failingMatchProvider
         */
        public function test_Failing_Matches( $name, $parameters, $urls )
        {
            $route = $this->builder->create( $name, $parameters );

            foreach ( $urls as $key => $url )
            {
                $data = $route->getMatch( $url );
                $this->assertFalse( $data );
            }
        }

        public function failingMatchProvider()
        {
            $foo = '0';
            return include __DIR__ . '/../../../fixtures/routing-matches-failing.php';
        }



    }


?>