<?php
require_once 'functions.php';

class Translate {

	public function getTranslate($word, $from, $to) {
            
                $api_key = C('API_KEY');
                
		if(empty($api_key)) {
			$api_key = 'aWUYalYMnNlrRAKt65XLEGmG';
		} 

		if(empty($word)) {
                        $ret = array(
                                'errno' => '2',
                                'errmsg' => 'Param(word) error!',
                        );
                        return json_encode($ret);
		}

		if(empty($from)) {
			$from = 'auto';
		}

		if(empty($to)) {
			$to = 'auto';
		}
		
                $url = $this->getUrl($api_key, $word, $from, $to);
                
		$ret = file_get_contents($url);
                
		return $ret;
	}

/*********************** private functions **************************************************************************/

	private function getbaidu_dict_url($api_key, $word, $from, $to) {
                $param = array(
                    'client_id' => $api_key,
                    'q' => $word,
                    'from' => $from,
                    'to' => $to,
                );

                $base_url = C('B_DICT_URL');
                
		$ret = $base_url.'?'.http_build_query($param);
                
		return $ret;
	}
	
	private function getbaidu_translate_url($api_key, $word, $from, $to) {
                $param = array(
                    'client_id' => $api_key,
                    'q' => $word,
                    'from' => $from,
                    'to' => $to,
                );

                $base_url = C('B_TRANSLATE_URL');
                
		$ret = $base_url.'?'.http_build_query($param);
                
		return $ret;
	}
	
	private function getyoudao_dict_url($key_from, $api_key, $word) {
                $param = array(
                    'client_id' => $api_key,
                    'q' => $word,
                    'from' => $from,
                    'to' => $to,
                );

                $base_url = C('B_TRANSLATE_URL');
                
		$ret = $base_url.'?'.http_build_query($param);
                
		return $ret;
	}

}


