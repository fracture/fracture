<?php

    namespace Fracture\Autoload;

    class NodeMap implements Searchable
    {


        private $root = null;

        private $path;


        public function import( $config, $path )
        {
            if ( $this->root === null )
            {
                $this->root = new Node;
            }

            $this->path = $path;
            $this->growElements( $config, $this->root );
        }


        private function growElements( $parameters, Node $parent )
        {
            foreach ( $parameters as $name => $details )
            {
                $node = $this->expandBranch( $name, $parent );
                if ( is_array( $details ) === false )
                {
                    $details = [ $details ];
                }
                $this->setupElement( $details, $node );
            }
        }


        private function expandBranch( $name, Node $parent )
        {
            $list = explode( '\\', $name );

            foreach ( $list as $item )
            {
                $node = new Node;
                $parent->addChild( strtolower( $item ), $node );
                $parent = $node;
            }

            return $node;
        }


        private function setupElement( $parameters, Node $node )
        {
            foreach ( $parameters as $name => $value )
            {
                if ( is_array( $value ) === true )
                {
                    $this->growElements( $value, $node );
                }

                if ( is_string($value) === true )
                {
                    $value = $this->cleanedPath( $value );
                    $node->addPath( $value );
                }
            }
        }

        private function cleanedPath( $value )
        {
            $value = trim( $value, '\\/');
            $value = str_replace( ['\\', '/'], DIRECTORY_SEPARATOR, $value );

            return trim( $this->path, '\\/') . DIRECTORY_SEPARATOR . $value;
        }




        public function getLocations( $className )
        {
            $className = strtolower( $className );
            $segments = explode('\\', $className, -1);

            $node = $this->findNode( $segments );
            $paths = $this->extractPaths( $node, $className );

            return $paths;
        }


        protected function findNode( $list )
        {
            $node = $marker = $this->root;

            foreach ( $list as $key )
            {
                if ( $node->hasChild( $key ) === false )
                {
                    return $marker;
                }

                $node = $node->getChild( $key );

                if ( count($node->getPaths()) > 0 )
                {
                    $marker = $node;
                }
            }

            return $marker;
        }


        private function extractPaths( $node, $className )
        {
            $leftover = str_replace( '###' . $node->getNamespace(), '', '###' . $className );
            $leftover = trim( $leftover, '\\/' );

            $paths = $node->getPaths();

            $paths = array_map( function( $element ) use ( $leftover ) {
                return $element . DIRECTORY_SEPARATOR . $leftover . '.php';
            }, $paths );

            return $paths;
        }



    }