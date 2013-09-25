<?php

    namespace Fracture\Autoload;


    class ClassLoader
    {

        protected $maps = [];


        public function addMap( Searchable $map )
        {
            $this->maps[] = $map;
        }


        protected function hasLoadedClass( $locations )
        {
            foreach ( $locations as $filepath )
            {
                if ( file_exists( $filepath ) )
                {
                    require $filepath;
                    return true;
                }
            }

            return false;
        }


        protected function load( $className )
        {
            foreach ( $this->maps as $map )
            {
                // gets a list of possible filepaths for the class definition
                $locations = $map->getLocations( $className );

                if ( $this->hasLoadedClass( $locations ) )
                {
                    return true;
                }
            }

            return false;
        }


        public function register()
        {
            spl_autoload_register( [ $this, 'load' ] );
        }


    }