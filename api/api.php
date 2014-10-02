<?php
define('__ROOT__', dirname(__FILE__));
require __ROOT__.'/common/functions.php';

class Translate {

	public function getTranslate($word, $from, $to) {

		$word_len = count(explode(' ', $word));

		$b_api_key = C('B_API_KEY');
                
		if(empty($b_api_key)) {
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

		if($word_len <= 4){

			$y_api_key = C('Y_API_KEY');
			if($y_api_key) {
				$y_api_key =  '2015763799';
			}

			$y_key_from = C('Y_KEY_FROM');
			if($y_key_from) {
				$y_key_from = 'bgtranslate';
			}
			
	        $b_url = $this->getbaidu_translate_url($b_api_key, $word, $from, $to);  
			$b_translate = $this->getbaidu_translate($b_url);
	                
	        $y_url = $this->getyoudao_dict_url($y_key_from, $y_api_key, $word);
	        $y_translate = $this->getyoudao_translate($y_url);

	        if(!empty($b_translate) && !empty($y_translate)) {
				$ret = array_merge($b_translate, $y_translate);
	        } else {
	        	$ret = $b_translate;
	        }
	        

	        return $ret;
		} else {
			$b_url = $this->getbaidu_translate_url($b_api_key, $word, $from, $to);  
			$ret = $this->getbaidu_translate($b_url);

			return $ret;
		}

        
		
	}

/*********************** private functions **************************************************************************/

	private function getbaidu_dict_url($api_key, $word, $from, $to) {
        $param = array(
            'client_id' => $api_key,
            'q' => $word,
            'from' => $from,
            'to' => $to,
        );

        $base_url = C('B_BASE_DICT_URL');
                
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

        $base_url = C('B_BASE_TRANSLATE_URL');
                
		$ret = $base_url.'?'.http_build_query($param);
                
		return $ret;
	}
	
	private function getyoudao_dict_url($key_from, $api_key, $word) {
        $param = array(
        	'keyfrom' => $key_from,
        	'key' => $api_key,
            'q' => $word,
        );

        $base_url = C('Y_BASE_TRANSLATE_URL');
                
		$ret = $base_url.'&'.http_build_query($param);
                
		return $ret;
	}
	
	private function getbaidu_translate($url) {
		
		$translate = file_get_contents($url);
		$translate = json_decode($translate, true);
		
		if(empty($translate['trans_result'])) {
			$translate = file_get_contents($url);
			$translate = json_decode($translate, true);
		}

		$ret['translate'] = $translate['trans_result'][0]['dst'];

		if(empty($ret)) {
			return false;
		}
		return $ret;
		
	}
	
	private function getyoudao_translate($url) {
		$translate = file_get_contents($url);
		$translate = json_decode($translate, true);

		if($translate['errorCode'] !=0 ) {
			$translate = file_get_contents($url);
			$translate = json_decode($translate, true);
		}
		if(!empty($translate['basic'])) {
			$ret['basic'] = $translate['basic']['explains'];
		}
		if(!empty($translate['web'])) {
			$ret['web'] = $translate['web'];
		}

		if(empty($ret)) {
			return false;
		}

		return $ret;

	}
}


