<?php


    namespace Fracture\Transcription;

    use Exception;
    use ReflectionClass;
    use PHPUnit_Framework_TestCase;


    class JsonReaderTest extends PHPUnit_Framework_TestCase
    {


        /**
         * @covers Fracture\Transcription\JsonReader::getAsArray
         */
        public function test_getAsArray_without_File()
        {

            $this->setExpectedException('Exception');
            $reader = new JsonReader;
            $reader->getAsArray( null );

        }

        /**
         * @covers Fracture\Transcription\JsonReader::getAsArray
         */
        public function test_getAsArray_with_Invalid_JSON()
        {

            $this->setExpectedException('Exception');
            $reader = new JsonReader;
            $reader->getAsArray( TEST_PATH . '/fixtures/configs/routes-invalid.json' );

        }


        /**
         * @covers Fracture\Transcription\JsonReader::getAsArray
         */
        public function test_getAsArray_with_Valid_JSON()
        {

            $reader = new JsonReader;
            $data = $reader->getAsArray( TEST_PATH . '/fixtures/configs/routes-single.json' );

            $expected = [
                'test' => [
                    'notation'  => '[/:alpha][/:beta]',
                    'defaults'  => [
                        'alpha' => 'qux',
                        'beta'  => 'qux',
                    ],
                ],
            ];

            $this->assertEquals( $expected, $data );

        }



    }
