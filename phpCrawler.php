<?php


class phpCrawler {

	private $url;
	private $depth;

	private $htmlPage;

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

	public function getNodes($url) {

		$htmlPage = file_get_contents($url);

		$list = []
		$index = 0;


		if ( $htmlPage != FALSE ) {
			foreach( $dom->getElementsBytTagName('a') as $node) {
				$list[$index] = $node->getAttribute('href');
				$index++;
			}
		}

		return $list;
	}
}

?>
