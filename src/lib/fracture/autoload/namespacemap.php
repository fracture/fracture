<?php

    namespace Fracture\Autoload;

    abstract class NamespaceMap implements Searchable
    {

        protected $tree = [[ 'nodes' => [],
                              'paths'  => [] ]];

        protected $fallbackPath = DIRECTORY_SEPARATOR;


        public function getLocations( $className )
        {
            $segments = explode( '\\', $className );
            $filename = array_pop( $segments );

            list( $segments, $current ) = $this->yieldNode( $segments );

            $path =  implode( DIRECTORY_SEPARATOR, $segments );
            $filepath = strtolower( $path ) . DIRECTORY_SEPARATOR . strtolower( $filename ) . '.php';

            $locations = $this->combinePaths( $this->tree[ $current ][ 'paths' ],
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
                $locations[ $id ] = $path . DIRECTORY_SEPARATOR . $filepath;
            }

            if ( empty( $locations ) )
            {
                $locations = [ $this->fallbackPath . DIRECTORY_SEPARATOR . $filepath ];
            }

            return $locations;
        }


        protected function growNode( $name, $current )
        {
            if ( !array_key_exists( $name,  $this->tree[ $current ][ 'nodes' ] ) )
            {
                $this->tree[] = [ 'nodes' => [],
                                  'paths' => [] ];
                $this->tree[ $current ][ 'nodes' ][ $name ] = count( $this->tree ) - 1;
            }

            return $this->tree[ $current ][ 'nodes' ][ $name ];           
        }

    }