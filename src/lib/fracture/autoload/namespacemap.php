<?php

    namespace Fracture\Autoload;

    abstract class NamespaceMap implements Searchable
    {

        protected $tree = [[ 'nodes' => [],
                              'path'  => [] ]];

        protected $fallbackPath = '/';


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