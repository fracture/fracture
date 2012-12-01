<?php


    namespace Fracture\Routing;

    use Exception;
    use ReflectionClass;
    use PHPUnit_Framework_TestCase;


    class PatternTest extends PHPUnit_Framework_TestCase
    {


        /**
         * @dataProvider simple_Pattern_Provider
         */
        public function test_Simple_Patterns( $notation, $result )
        {
            $pattern = new Pattern( $notation );
            $pattern->prepare();

            $this->assertEquals( $result, $pattern->getExpression() );

        }

        public function simple_Pattern_Provider()
        {   
            return include __DIR__ . '/../../../fixtures/routing/patterns-simple.php';
        }


        /**
         * @dataProvider conditional_Pattern_Provider
         */
        public function test_Conditional_Patterns( $notation, $conditions, $result )
        {
            $pattern = new Pattern( $notation, $conditions );
            $pattern->prepare();

            $this->assertEquals( $result, $pattern->getExpression() );

        }

        public function conditional_Pattern_Provider()
        {   
            return include __DIR__ . '/../../../fixtures/routing/patterns-conditional.php';
        }



    }


?>