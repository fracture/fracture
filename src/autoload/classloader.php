<?php

    namespace Fracture\Autoload;


    class ClassLoader
    {

        protected $map;

        
        public function __construct( Searchable $map )
        {
            $this->map = $map;
        }

        
        public function register()
        {
            spl_autoload_register( array( $this, 'load' ) );
        }



        protected function load( $className )
        {

            $filepaths = $this->map->getLocations( $className );

            foreach ( $filepaths as $filepath )
            {
                if ( file_exists( $filepath ) )
                {
                    require $filepath;
                    return;
                }
            }

            throw new ClassNotFoundException( "Class '$className' not found in following location: '$filepath'!" );
        }


    }

?>