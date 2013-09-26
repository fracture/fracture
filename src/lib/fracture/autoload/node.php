<?php

    namespace Fracture\Autoload;


    class Node
    {

        private $children = [];

        private $paths = [];

        private $namespace = '';



        public function addPath( $path )
        {
            $this->paths[] = $path;
        }


        public function addChild( $name, Node $node )
        {
            $this->children[ $name ] = $node;

            if ( $this->namespace !== '' )
            {
                $name = $this->namespace . '\\' . $name;
            }

            $node->setNamespace( $name );
        }


        public function hasChild( $name )
        {
            return array_key_exists( $name, $this->children );
        }


        public function getChild( $name )
        {
            return $this->children[ $name ];
        }

        public function setNamespace( $namespace )
        {
            $this->namespace = $namespace;
        }


        public function getNamespace()
        {
            return $this->namespace;
        }

        public function getPaths()
        {
            return $this->paths;
        }

    }