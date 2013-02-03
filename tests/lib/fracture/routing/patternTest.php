<?php


    namespace Fracture\Routing;

    use Exception;
    use ReflectionClass;
    use PHPUnit_Framework_TestCase;


    class PatternTest extends PHPUnit_Framework_TestCase
    {


        /**
         * @dataProvider simple_Pattern_Provider
         * @covers Fracture\Routing\Pattern::__construct
         * @covers Fracture\Routing\Pattern::prepare
         * @covers Fracture\Routing\Pattern::getExpression
         *
         * @covers Fracture\Routing\Pattern::cleanNotation
         * @covers Fracture\Routing\Pattern::addSlash
         * @covers Fracture\Routing\Pattern::parseNotation
         * @covers Fracture\Routing\Pattern::applyConditions
         */
        public function test_Simple_Patterns( $notation, $result )
        {
            $pattern = new Pattern( $notation );
            $pattern->prepare();

            $this->assertEquals( $result, $pattern->getExpression() );

        }

        public function simple_Pattern_Provider()
        {
            return include TEST_PATH . '/fixtures/routing/patterns-simple.php';
        }


        /**
         * @dataProvider conditional_Pattern_Provider
         * @covers Fracture\Routing\Pattern::__construct
         * @covers Fracture\Routing\Pattern::prepare
         * @covers Fracture\Routing\Pattern::getExpression
         *
         * @covers Fracture\Routing\Pattern::cleanNotation
         * @covers Fracture\Routing\Pattern::addSlash
         * @covers Fracture\Routing\Pattern::parseNotation
         * @covers Fracture\Routing\Pattern::applyConditions
         */
        public function test_Conditional_Patterns( $notation, $conditions, $result )
        {
            $pattern = new Pattern( $notation, $conditions );
            $pattern->prepare();

            $this->assertEquals( $result, $pattern->getExpression() );

        }

        public function conditional_Pattern_Provider()
        {
            return include TEST_PATH . '/fixtures/routing/patterns-conditional.php';
        }



    }


?>