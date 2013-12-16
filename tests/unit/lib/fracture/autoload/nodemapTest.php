<?php


    namespace Fracture\Autoload;

    use Exception;
    use ReflectionClass;
    use PHPUnit_Framework_TestCase;


    class NodeMapTest extends PHPUnit_Framework_TestCase
    {

        /**
         * @covers Fracture\Autoload\NodeMap::import
         * @covers Fracture\Autoload\NodeMap::getLocations
         *
         * @covers Fracture\Autoload\NodeMap::growElements
         * @covers Fracture\Autoload\NodeMap::setupElement
         * @covers Fracture\Autoload\NodeMap::handleParams
         * @covers Fracture\Autoload\NodeMap::expandBranch
         * @covers Fracture\Autoload\NodeMap::cleanedPath
         * @covers Fracture\Autoload\NodeMap::findNode
         * @covers Fracture\Autoload\NodeMap::extractPaths
         * @covers Fracture\Autoload\NodeMap::cleanUnmappedPart
         *
         * @dataProvider simple_Import_Provider
         */
        public function test_Simple_Import( $config, $path, $class, $result )
        {
            $instance = new NodeMap;
            $instance->import( $config, $path );

            $this->assertEquals( $result, $instance->getLocations( $class ) );
        }

        public function simple_Import_Provider()
        {
            return include FIXTURE_PATH . '/autoload/imports-simple.php';
        }

    }