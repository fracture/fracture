<?php


    namespace Fracture\Routing;

    use Exception;
    use ReflectionClass;
    use PHPUnit_Framework_TestCase;


    class PatternTest extends PHPUnit_Framework_TestCase
    {


        /**
         * @dataProvider simplePatternProvider
         */
        public function testSimplePatterns( $notation, $result )
        {
            $pattern = new Pattern( $notation );
            $pattern->prepare();

            $this->assertEquals( $result, $pattern->getExpression() );

        }

        public function simplePatternProvider()
        {   
            return include __DIR__ . '/../../../fixtures/routing-notations-simple.php';
        }


        /**
         * @dataProvider conditionalPatternProvider
         */
        public function testConditionalPatterns( $notation, $conditions, $result )
        {
            $pattern = new Pattern( $notation, $conditions );
            $pattern->prepare();

            $this->assertEquals( $result, $pattern->getExpression() );

        }

        public function conditionalPatternProvider()
        {   
            return include __DIR__ . '/../../../fixtures/routing-notations-conditional.php';
        }


    }


?>