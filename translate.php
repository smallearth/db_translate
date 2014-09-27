<?php

$translate = new translate();
$translate->getTranslate();

/*********************** translate class ****************************************************************************/

class translate {
	private $apikey = 'aWUYalYMnNlrRAKt65XLEGmG';

	public function getTranslate() {
		$url = $this->getUrl($this->apikey);
		$ret = file_get_contents($url);
		echo $ret;
	}

/*********************** private functions **************************************************************************/

	private function getUrl($apikey) {
		$word = trim($_POST['word']);
		$from = trim($_POST['from']);
		$to = $this->getTo($from);

		if(empty($apikey)) {
			$apikey = 'aWUYalYMnNlrRAKt65XLEGmG';
		} 

		if(empty($word)) {
			$word = 'word';
		}

		if(empty($from)) {
			$from = 'auto';
		}

		if(empty($to)) {
			$to = 'auto';
		}

		$ret = 'http://openapi.baidu.com/public/2.0/bmt/translate?client_id='.$apikey.'&q='.$word.'&from='.$from.'&to='.$to;
		return $ret;
	}

	private function getTo($from) {
		switch ($from) {
			case 'auto':
				return "auto";
				break;
			case 'en':
				return 'zh';
				break;
			case 'zh':
				return 'en';
				break;
			default:
				return 'auto';
				break;
		}
	}

}	
?> 