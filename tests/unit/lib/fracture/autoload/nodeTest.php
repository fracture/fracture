<?php


    namespace Fracture\Autoload;

    use Exception;
    use ReflectionClass;
    use PHPUnit_Framework_TestCase;


    class NodeTest extends PHPUnit_Framework_TestCase
    {


        /**
         * @covers Fracture\Autoload\Node::setNamespace
         * @covers Fracture\Autoload\Node::getNamespace
         */
        public function test_Setting_of_Namespace()
        {
            $instance = new Node;
            $instance->setNamespace('foobar');

            $this->assertEquals('foobar', $instance->getNamespace() );
        }


        /**
         * @covers Fracture\Autoload\Node::getPaths
         */
        public function test_With_no_Paths()
        {
            $instance = new Node;
            $this->assertEquals( [], $instance->getPaths() );
        }

        /**
         * @covers Fracture\Autoload\Node::addPath
         * @covers Fracture\Autoload\Node::getPaths
         * @covers Fracture\Autoload\Node::findUniquePaths
         *
         * @dataProvider provide_Adding_of_Paths
         */
        public function test_Adding_of_Paths( $list, $result )
        {
            $instance = new Node;
            foreach ( $list as $path )
            {
                $instance->addPath( $path );
            }

            $this->assertEquals( $result, $instance->getPaths() );
        }


        public function provide_Adding_of_Paths()
        {
            return include FIXTURE_PATH . '/autoload/node-paths.php';
        }


        /**
         * @covers Fracture\Autoload\Node::addPath
         * @covers Fracture\Autoload\Node::getPaths
         * @covers Fracture\Autoload\Node::findUniquePaths
         */
        public function test_Repeated_Adding_of_Paths()
        {
            $instance = new Node;

            $instance->addPath('/duplicate');
            $instance->addPath('/unique');
            $temp  = $instance->getPaths();
            $instance->addPath('duplicate');

            $this->assertEquals([
                'duplicate',
                'unique',
            ], $instance->getPaths());
        }



    }