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
            $instance->setNamespace( 'foobar' );

            $this->assertEquals( 'foobar', $instance->getNamespace() );
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
         * @dataProvider provide_Adding_of_Paths
         *
         * @covers Fracture\Autoload\Node::addPath
         * @covers Fracture\Autoload\Node::getPaths
         * @covers Fracture\Autoload\Node::findUniquePaths
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

            $instance->addPath( '/duplicate' );
            $instance->addPath( '/unique' );
            $temp  = $instance->getPaths();
            $instance->addPath( '/duplicate' );

            $this->assertEquals([
                '/duplicate',
                '/unique',
            ], $instance->getPaths());
        }


        /**
         * @covers Fracture\Autoload\Node::addChild
         * @covers Fracture\Autoload\Node::getNamespace
         */
        public function test_Simple_Child_Addition()
        {
            $parent = new Node;
            $child = new Node;

            $parent->addChild( 'test', $child );

            $this->assertEquals( 'test', $child->getNamespace() );
        }


        /**
         * @dataProvider provide_Child_Addition_with_Parent_Namespace
         *
         * @covers Fracture\Autoload\Node::addChild
         * @covers Fracture\Autoload\Node::setNamespace
         * @covers Fracture\Autoload\Node::getNamespace
         */
        public function test_Child_Addition_with_Parent_Namespace( $namespace, $name, $result )
        {
            $parent = new Node;
            $child = new Node;

            $parent->setNamespace( $namespace );
            $parent->addChild( $name, $child );

            $this->assertEquals( $result, $child->getNamespace() );
        }


        public function provide_Child_Addition_with_Parent_Namespace()
        {
            return include FIXTURE_PATH . '/autoload/node-namespaces.php';
        }


        /**
         * @dataProvider provide_Check_if_Child_Exists
         *
         * @covers Fracture\Autoload\Node::addChild
         * @covers Fracture\Autoload\Node::hasChild
         */
        public function test_Check_if_Child_Exists( $names, $key, $result )
        {
            $instance = new Node;

            foreach ( $names as $name )
            {
                $instance->addChild( $name, new Node );
            }

            $this->assertEquals( $result, $instance->hasChild( $key ) );
        }

        public function provide_Check_if_Child_Exists()
        {
            return include FIXTURE_PATH . '/autoload/node-children.php';
        }


        /**
         * @covers Fracture\Autoload\Node::addChild
         * @covers Fracture\Autoload\Node::getChild
         */
        public function test_Getter_for_Child_Nodes()
        {
            $instance = new Node;
            $instance->addChild( 'foo', new Node );

            $this->assertInstanceOf(
                'Fracture\Autoload\Node',
                $instance->getChild( 'foo' )
            );
            $this->assertNull( $instance->getChild( 'bar' ) );
        }
    }