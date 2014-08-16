<?php


class phpCrawler {

	private $url;
	private $depth;

	private __construct($URL, $DEPTH) {
		
		//check if the url it's valid
		if ( filter_var($URL, FILTER_VALIDATE_URL) === TRUE ) {
			$url = $URL;
		}
	
		//check if depth it's an integer
		if (is_int($DEPTH) ) {
			$depth = $DEPTH;
		}
	}

}

?>
