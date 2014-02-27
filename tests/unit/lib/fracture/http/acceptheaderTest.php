<?php


    namespace Fracture\Http;

    use Exception;
    use ReflectionClass;
    use PHPUnit_Framework_TestCase;


    class AcceptHeaderTest extends PHPUnit_Framework_TestCase
    {

        /**
         * @covers Fracture\Http\AcceptHeader::__construct
         * @covers Fracture\Http\AcceptHeader::getPrioritizedList
         *
         * @covers Fracture\Http\AcceptHeader::obtainGroupedElements
         * @covers Fracture\Http\AcceptHeader::obtainSortedQualityList
         * @covers Fracture\Http\AcceptHeader::obtainAssessedItem
         * @covers Fracture\Http\AcceptHeader::obtainSortedElements
         */
        public function test_Empty_Instance()
        {
            $instance = new AcceptHeader;
            $instance->prepare();

            $this->assertEquals( [], $instance->getPrioritizedList() );
        }


        /**
         * @dataProvider provide_Simple_Accept_Headers
         * @covers Fracture\Http\AcceptHeader::__construct
         * @covers Fracture\Http\AcceptHeader::prepare
         * @covers Fracture\Http\AcceptHeader::getPrioritizedList
         *
         * @covers Fracture\Http\AcceptHeader::obtainGroupedElements
         * @covers Fracture\Http\AcceptHeader::obtainSortedQualityList
         * @covers Fracture\Http\AcceptHeader::obtainAssessedItem
         * @covers Fracture\Http\AcceptHeader::obtainSortedElements
         */
        public function test_Simple_Accept_Headers( $input, $expected )
        {
            $instance = new AcceptHeader( $input );
            $instance->prepare();

            $this->assertEquals( $expected, $instance->getPrioritizedList() );
        }


        public function provide_Simple_Accept_Headers()
        {
            return [
                [
                    'input' => 'text/html',
                    'expected' => [['value' => 'text/html']],
                ],
                [
                    'input' => 'text/html;version=2',
                    'expected' => [['value' => 'text/html', 'version' => '2']],
                ],
                [
                    'input' => 'text/html;foo=bar; q=0.6',
                    'expected' => [['value' => 'text/html', 'foo' => 'bar']],
                ],
                [
                    'input' => 'application/json;version=1, application/json, */*;q=0.5',
                    'expected' => [['value' => 'application/json', 'version' => '1'], ['value' => 'application/json'], ['value' => '*/*']],
                ],
                [
                    'input' => 'application/json;version=1, test/test;q=0.8, application/json, */*;q=0.5',
                    'expected' => [['value' => 'application/json', 'version' => '1'], ['value' => 'application/json'], ['value' => 'test/test'], ['value' => '*/*']],
                ],
            ];

        }


        /**
         * @covers Fracture\Http\AcceptHeader::__construct
         * @covers Fracture\Http\AcceptHeader::prepare
         * @covers Fracture\Http\AcceptHeader::setAlternativeValue
         * @covers Fracture\Http\AcceptHeader::getPrioritizedList
         *
         * @covers Fracture\Http\AcceptHeader::obtainGroupedElements
         * @covers Fracture\Http\AcceptHeader::obtainSortedQualityList
         * @covers Fracture\Http\AcceptHeader::obtainAssessedItem
         * @covers Fracture\Http\AcceptHeader::obtainSortedElements
         */
        public function test_Use_of_Alternative_Value()
        {
            $instance = new AcceptHeader( 'text/plain' );
            $instance->prepare();

            $this->assertEquals( [['value' => 'text/plain']], $instance->getPrioritizedList() );

            $instance->setAlternativeValue( 'text/html' );
            $instance->prepare();

            $this->assertEquals( [['value' => 'text/html']], $instance->getPrioritizedList() );
        }

        /**
         * @covers Fracture\Http\AcceptHeader::__construct
         * @covers Fracture\Http\AcceptHeader::prepare
         * @covers Fracture\Http\AcceptHeader::contains
         *
         * @covers Fracture\Http\AcceptHeader::obtainAssessedItem
         */
        public function test_Whether_Contain_Finds_Existing_Type()
        {
            $instance = new AcceptHeader( 'application/json;version=1;param=value, application/json' );
            $instance->prepare();

            $this->assertTrue( $instance->contains('application/json;param=value;version=1') );
            $this->assertFalse( $instance->contains('application/json;version=value;param=1') );
        }



        /**
         * @dataProvider provide_Types_for_Computation
         * @covers Fracture\Http\AcceptHeader::getPreferred
         * @covers Fracture\Http\AcceptHeader::getParsedList
         * @covers Fracture\Http\AcceptHeader::obtainEntryFromList
         * @covers Fracture\Http\AcceptHeader::isMatch
         * @covers Fracture\Http\AcceptHeader::replaceStars
         *
         */
        public function test_Preferred_Type_Compution( $header, $available, $expected )
        {
            $instance = new AcceptHeader( $header );
            $instance->prepare();

            $this->assertEquals( $expected, $instance->getPreferred( $available ) );
        }

        public function provide_Types_for_Computation()
        {
            return [
                [
                    'header'    => 'application/json',
                    'available' => 'application/json',
                    'expected'  => 'application/json',
                ],
                [
                    'header'    => '*/*',
                    'available' => 'application/json',
                    'expected'  => 'application/json',
                ],
                [
                    'header'    => 'application/json;version=2',
                    'available' => 'application/json;version=1',
                    'expected'  => null,
                ],
                [
                    'header'    => 'application/json',
                    'available' => 'text/html, application/json',
                    'expected'  => 'application/json',
                ],
                [
                    'header'    => 'text/html;q=0.1, application/json',
                    'available' => 'application/json',
                    'expected'  => 'application/json',
                ],
                [
                    'header'    => 'text/html, application/json',
                    'available' => 'application/json',
                    'expected'  => 'application/json',
                ],
                [
                    'header'    => 'text/html;q=0.1, application/json;q=0.4',
                    'available' => 'application/json',
                    'expected'  => 'application/json',
                ],
                [
                    'header'    => 'text/html, application/json, text/*',
                    'available' => 'text/plain',
                    'expected'  => 'text/plain',
                ],
                [
                    'header'    => 'text/html, application/json',
                    'available' => 'application/json, text/html',
                    'expected'  => 'text/html',
                ],
                [
                    'header'    => 'application/json',
                    'available' => 'application/json;version=2',
                    'expected'  => null,
                ],
                [
                    'header'    => 'application/json;version=3, application/json',
                    'available' => 'application/json;version=2, application/json',
                    'expected'  => 'application/json',
                ],
                [
                    'header'    => 'application/json;version=3, application/json',
                    'available' => 'application/json;version=2, application/json;version=3',
                    'expected'  => 'application/json;version=3',
                ],
            ];
        }


        /**
         * @dataProvider provide_Entries_for_Formating
         * @covers Fracture\Http\AcceptHeader::__construct
         * @covers Fracture\Http\AcceptHeader::getFormatedEntry
         */
        public function test_Formating_of_Entries( $entry, $result )
        {
            $instance = new AcceptHeader;
            $this->assertEquals( $result, $instance->getFormatedEntry( $entry ) );
        }


        public function provide_Entries_for_Formating()
        {
            return [
                [
                    'entry' => ['value' => 'text/html'],
                    'result' => 'text/html',
                ],
                [
                    'entry' => ['value' => 'text/html', 'version' => '2'],
                    'result' => 'text/html;version=2',
                ],
            ];
        }

    }