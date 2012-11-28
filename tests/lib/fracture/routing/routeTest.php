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
            var_dump( empty($foo)  );
            return include __DIR__ . '/../../../fixtures/routing-matches-successful.php';
        }


    }


?>