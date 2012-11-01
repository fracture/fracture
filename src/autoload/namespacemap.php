<?php

    namespace Fracture\Autoload;

    class NamespaceMap implements Searchable
    {

        protected $tree = [[ 'nodes' => [],
                              'path'  => [] ]];

        protected $fallbackPath = '/';


        public function __construct( $fallbackPath )
        {
            $this->fallbackPath = $fallbackPath;
        }


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


        public function getLocations( $className )
        {
            $segments = explode( '\\', $className );
            $filename = array_pop( $segments );

            list( $segments, $current ) = $this->yieldNode( $segments );

            $path =  implode( '/', $segments );
            $filepath = strtolower( $path ) . '/' . $filename . '.php';

            $locations = $this->combinePaths( $this->tree[ $current ][ 'path' ],
                                              $filepath );

            return $locations;
        }


        protected function yieldNode( array $segments )
        {
            $current = 0;

            while( !empty( $segments ) && array_key_exists( $segments[0],  $this->tree[ $current ][ 'nodes' ] ) )
            {
                $name = array_shift($segments);
                $current = $this->tree[ $current ][ 'nodes' ][ $name ];
            }

            return [ $segments, $current ];
        }


        protected function combinePaths( $locations, $filepath )
        {
            foreach ( $locations as $id => $path )
            {
                $locations[ $id ] = $path . '/' . $filepath;
            }

            if ( empty( $locations ) )
            {
                $locations = [ $this->fallbackPath . '/' . $filepath ];
            }

            return $locations;
        }



    }

?>