<?php


    namespace Fracture\Autoload;

    use Exception;
    use ReflectionClass;
    use PHPUnit_Framework_TestCase;


    class NodeMapTest extends PHPUnit_Framework_TestCase
    {

        /**
         * @dataProvider simple_import_Provider
         */
        public function test_Simple_Import( $config, $path, $class, $result )
        {
            $instance = new NodeMap;
            $instance->import( $config, $path );

            $this->assertEquals( $result, $instance->getLocations( $class ) );
        }

        public function simple_import_Provider()
        {
            return include FIXTURE_PATH . '/autoload/imports-simple.php';
        }

    }