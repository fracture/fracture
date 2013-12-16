<?php


    namespace Fracture\Http;

    use Exception;
    use ReflectionClass;
    use PHPUnit_Framework_TestCase;

    use \Mock\UploadedFile as UploadedFile;


    class UploadedFileTest extends PHPUnit_Framework_TestCase
    {

        /**
         * @dataProvider simple_Type_Provider
         *
         * @covers Fracture\Http\UploadedFile::__construct
         * @covers Fracture\Http\UploadedFile::getMimeType
         * @covers Fracture\Http\UploadedFile::prepare
         * @covers Fracture\Http\UploadedFile::hasProperExtension
         * @covers Fracture\Http\UploadedFile::isDubious
         * @covers Fracture\Http\UploadedFile::getPath
         */
        public function test_Upload_Types( $params, $type, $validity )
        {
            $instance = new UploadedFile( $params );

            $instance->prepare();
            $this->assertEquals( $type, $instance->getMimeType() );
            $this->assertEquals( $validity, $instance->hasProperExtension() );
        }

        public function simple_Type_Provider()
        {
            return include FIXTURE_PATH . '/http/uploads-type.php';
        }

        /**
         * @dataProvider simple_Validity_provider
         *
         * @covers Fracture\Http\UploadedFile::__construct
         * @covers Fracture\Http\UploadedFile::isValid
         * @covers Fracture\Http\UploadedFile::prepare
         * @covers Fracture\Http\UploadedFile::isDubious
         * @covers Fracture\Http\UploadedFile::getPath
         */
        public function test_Upload_Validity( $params, $result )
        {
            $instance = new UploadedFile( $params );

            $instance->prepare();
            $this->assertEquals( $result, $instance->isValid() );
        }


        public function simple_Validity_provider()
        {
            return include FIXTURE_PATH . '/http/uploads-validity.php';
        }


    }