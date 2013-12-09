<?php
	
	namespace Fracture\Http;

	class UploadedFile
	{

		private $rawParams = [];


		public function __construct( $params )
		{
			$this->rawParams = $params;
		}


		public function getName()
		{
			return $this->rawParams['name'];
		}


		public function getSize()
		{
			return $this->rawParams['size'];
		}


		public function getMimeType()
		{
			if ( class_exists('\FInfo') ) 
			{
				$info = new \FInfo( FILEINFO_MIME_TYPE );
				return $info->file( $this->getPath() );
			}

			return $this->rawParams['type'];
		}


		public function getPath()
		{
			return $this->rawParams['tmp_name'];
		}

	}