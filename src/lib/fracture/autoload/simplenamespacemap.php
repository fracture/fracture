<?php

    namespace Fracture\Autoload;

    class SimpleNamespaceMap extends NamespaceMap
    {

        protected $tree = [[ 'nodes' => [],
                              'path'  => [] ]];

        protected $fallbackPath = '/';


        public function addNamespacePath( $namespace, $path )
        {
            $segments = explode( '\\', $namespace );
            $id = $this->growBranch( $segments );
            $this->tree[ $id ][ 'path' ][] = $path;
        }


        protected function growBranch( array $segments )
        {
            $total = count( $segments );
            $current = 0;

            for ( $i = 0; $i < $total; $i++ )
            {
                $name = $segments[ $i ];
                $current = $this->growNode( $current, $name );
            }

            return $current;
        }


        protected function growNode( $current, $name )
        {
            if ( !array_key_exists( $name,  $this->tree[ $current ][ 'nodes' ] ) )
            {
                $this->tree[] = [ 'nodes' => [],
                                 'path' => [] ];
                $this->tree[ $current ][ 'nodes' ][ $name ] = count( $this->tree ) - 1;
            }

            return $this->tree[ $current ][ 'nodes' ][ $name ];           
        }

    }


?>