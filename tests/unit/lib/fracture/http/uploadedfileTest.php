<?php


    namespace Fracture\Http;

    use Exception;
    use ReflectionClass;
    use PHPUnit_Framework_TestCase;


    class UploadedFileTest extends PHPUnit_Framework_TestCase
    {

        /**
         * @dataProvider simple_Type_Provider
         */
        public function test_Upload_Types( $params, $result )
        {
            $instance = new UploadedFile( $params );
            $instance->prepare();
            $this->assertEquals( $result, $instance->getMimeType() );
        }

        public function simple_Type_Provider()
        {
            return include FIXTURE_PATH . '/http/uploads-type.php';
        }

        /**
         * @dataProvider simple_Validity_provider
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