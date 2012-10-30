<?php

    namespace Fracture\Autoload;

    class NamespaceMap implements Searchable
    {

        protected $tree = [];

        protected $root = '';


        public function __construct( $path )
        {
            $this->tree[0] = [ 'nodes' => [],
                              'path'  => [] ];

            $this->root = $path;
        }


        public function addNamespacePath( $namespace, $path )
        {
            $segments = explode( '\\', $namespace );
            $nodeId = $this->growBranch( $segments );
            $this->tree[ $nodeId ][ 'path' ][] = $path;
        }


        protected function growBranch( array $segments )
        {
            $total = count( $segments );
            $currentNodeId = 0;

            for ( $i = 0; $i < $total; $i++ )
            {
                $name = $segments[ $i ];
                $currentNodeId = $this->growNode( $currentNodeId, $name );
            }

            return $currentNodeId;
        }


        protected function growNode( $currentNodeId, $name )
        {
            if ( !array_key_exists( $name,  $this->tree[ $currentNodeId ][ 'nodes' ] ) )
            {
                $this->tree[] = [ 'nodes' => [],
                                 'path' => [] ];
                $this->tree[ $currentNodeId ][ 'nodes' ][ $name ] = count( $this->tree ) - 1;
            }

            return $this->tree[ $currentNodeId ][ 'nodes' ][ $name ];           
        }


        public function getLocations( $className )
        {

        }


    }

?>