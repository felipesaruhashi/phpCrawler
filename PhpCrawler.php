<?php


class phpCrawler {


	function __construct() { }
	//private __construct() { } 
		/*
		//check if the url it's valid
		if ( filter_var($URL, FILTER_VALIDATE_URL) === TRUE ) {
			$url = $URL;
		}
	
		//check if depth it's an integer
		if (is_int($DEPTH) ) {
			$depth = $DEPTH;
		}
	} */

	public function getNodes($url) {

		$htmlPage = file_get_contents($url);

		$list = [];
		$index = 0;


		if ( $htmlPage != FALSE ) {

			//http://stackoverflow.com/questions/6090667/php-domdocument-errors-warnings-on-html5-tags
			// libxml_use_internal_errors(true) and libxml_clear_errors() to hide html5 warnings
			$dom = new DOMDocument;
			libxml_use_internal_errors(true);
			$dom->loadHTML($htmlPage);
			libxml_clear_errors();

			foreach( $dom->getElementsByTagName('a') as $node) {
				$list[$index] = $node->getAttribute('href');
				$index++;
			}
		}

		return $list;
	}

	private $url;
	private $depth;

	private $htmlPage;

}

?>
