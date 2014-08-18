<?php

class phpCrawler {

	private $visitedURL;
	private $count;
	private $depth;
	private $url;
	private $urlParsed;
	private $host;
	const max_nodes = 100;

	public function getNodes($url) {

		$htmlPage = '';
		if($url != '') { // if the url isn't empty
			$htmlPage = file_get_contents($url);
		}
		$list = [];
		$index = 0;

		if ( $htmlPage != FALSE ) {
			//if the html page was retrieved

			//http://stackoverflow.com/questions/6090667/php-domdocument-errors-warnings-on-html5-tags
			//libxml_use_internal_errors(true) and libxml_clear_errors() to hide html5 warnings
			$dom = new DOMDocument;
			libxml_use_internal_errors(true);
			$dom->loadHTML($htmlPage);
			libxml_clear_errors();

			foreach( $dom->getElementsByTagName('a') as $node) {
				if ( !$this->isSubDomain($node->getAttribute('href')) && !array_key_exists($node->getAttribute('href'),$this->visitedURL) && $this->count < 100) {
					$list[$index] = $node->getAttribute('href');
					$index++;
				}
			}

			$this->visitedURL[$url] = TRUE;
		}

		return $list;
	}

	public function run($URL, $DEPTH) {

		$result = [];

		if(filter_var($URL, FILTER_VALIDATE_URL) == TRUE && is_numeric($DEPTH) ) {
			//check if $URL it's a valid url and $DEPTH it's numeric

			$this->visitedURL = []; //map with the already visited urls, to avoid cycles
			$this->count = 0;
			$this->depth = $DEPTH;
			
			$this->host = $this->getDomain($URL);

			$this->visitedURL[$URL] = TRUE;//set as the root node as already visited.

			$result[$URL] = $this->depthFirstSearch($URL, 1);//call the depth first search recursive function
		}

		return $result;
	}

	private function depthFirstSearch($url, $currentDepth) {
		
		if($this->count >= self::max_nodes || $currentDepth ==  $this->depth) {
			//if already have
			return [];
		} else {
			$return = [];

			$queue = $this->getNodes($url);

			foreach($queue as $nodes) {
				if ($this->count >=self::max_nodes) {
					break;
				}
				$this->count++; // increase the nodes counter
				$return[$nodes] = $this->depthFirstSearch($url, $currentDepth + 1);				
			}

			return $return;
		}

	}

	private function isSubDomain($URL) {

		if ( filter_var($URL, FILTER_VALIDATE_URL) == TRUE) {

			if($this->getDomain($URL) == $this->host ) {
				return true;
			} else {
				return false;
			}
		} 
		return false;
	}

	private function getDomain($url) {
		$pieces = parse_url($url);
		$domain = isset($pieces['host']) ? $pieces['host'] : '';
		if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
			return $regs['domain'];
		}
		return false;
	}
}

?>