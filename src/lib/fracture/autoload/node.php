<?php

    namespace Fracture\Autoload;


    class Node
    {

        private $children = [];

        private $paths = [];

        private $hasNewPaths = false;

        private $namespace = '';



        public function addPath( $path )
        {
            $path = str_replace( '\\', '/' , $path );
            $path = trim( $path, '/' );
            $this->paths[] = $path;
            $this->hasNewPaths = true;
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
            if ( $this->hasNewPaths === true )
            {
                $this->paths = $this->findUniquePaths( $this->paths );
                $this->hasNewPaths = false;
            }

            return $this->paths;
        }


        private function findUniquePaths( $list )
        {
            $temp = [];
            foreach ( $list as $item )
            {
                $temp[ $item ] = 1;
            }

            return array_keys( $temp );
        }


    }