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

            $this->path = str_replace('\\', '/', $path);
            $this->growElements( $config, $this->root );
        }


        private function growElements( $parameters, Node $parent )
        {
            foreach ( $parameters as $name => $details )
            {
                $node = $this->expandBranch( $name, $parent );
                // to be able shorthand for assigning single string as path
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
                    // for building full path
                    $value = $this->cleanedPath( $value );
                    $node->addPath( $value );
                }
            }
        }

        private function cleanedPath( $value )
        {
            $value = str_replace( '\\', '/', $value );
            $value = rtrim( $value, '/');

            return rtrim( $this->path, '/') . '/' . $value;
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

                // if a namespace does not have any paths associated to it, use previous one
                if ( count($node->getPaths()) > 0 )
                {
                    $marker = $node;
                }
            }

            return $marker;
        }


        private function extractPaths( $node, $className )
        {
            // the marker is added to make sur that only first match in the classname is replaced
            $leftover = str_replace( '###' . $node->getNamespace(), '', '###' . $className );
            $leftover = trim( $leftover, '\\/' );
            $leftover = str_replace( '\\', '/', $leftover );

            $paths = $node->getPaths();

            $paths = array_map( function( $element ) use ( $leftover ) {
                return $element . '/' . $leftover . '.php';
            }, $paths );

            return $paths;
        }



    }