<?php

    namespace Fracture\Autoload;

    abstract class NamespaceMap implements Searchable
    {

        protected $tree = [[ 'nodes' => [],
                              'paths'  => [] ]];

        protected $fallbackPath = '/';


        public function getLocations( $className )
        {
            $segments = explode( '\\', $className );
            $filename = array_pop( $segments );

            list( $segments, $current ) = $this->yieldNode( $segments );

            $path =  implode( '/', $segments );
            $filepath = strtolower( $path ) . '/' . $filename . '.php';

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
                $locations[ $id ] = $path . '/' . $filepath;
            }

            if ( empty( $locations ) )
            {
                $locations = [ $this->fallbackPath . '/' . $filepath ];
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

?>