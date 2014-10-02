<?php
define('__ROOT__', dirname(__FILE__));
require_once __ROOT__.'/api/api.php';

//define token
define("TOKEN", "dabao_english");
$wechatObj = new wechatCallbackapiTest();
$wechatObj->valid();

class wechatCallbackapiTest
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()) {
        	//echo $echoStr;
        	$this->responseMsg();
            exit;
        }
    }

    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){
                
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
                $time = time();
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";             
				if(!empty( $keyword ))
                {
              		$msgType = "text";
                	$contentStr = $this->getTranslate($keyword);

                	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                	echo $resultStr;
                }else{
                	echo "Input something...";
                }

        }else {
        	echo "";
        	exit;
        }
    }
		
    private function getTranslate($word) 
    {
        $tr_url = 'http://openapi.baidu.com/public/2.0/bmt/translate?client_id=aWUYalYMnNlrRAKt65XLEGmG&q='.$word.'&from=auto&to=auto';
        $tr = json_decode(file_get_contents($tr_url), true);
        
        if(empty($tr['error_code'])) {
            $ret = $tr['trans_result'][0]['dst']."\n\r";
        }

        $dict_url = 'http://openapi.baidu.com/public/2.0/translate/dict/simple?client_id=aWUYalYMnNlrRAKt65XLEGmG&q='.$word.'&from=auto&to=auto';
        $dict_tr = file_get_contents($dict_url);
        $dict_tr = json_decode($dict_tr, true);
        if($dict_tr['errno'] === 0) {
            $dict_tr = $dict_tr['data']['symbols'][0]['parts'];
            $i = 0;
            foreach ($dict_tr as $part) {
                $ret.= (++$i).'、'.$part['part']." ";
                $means = $part['means'];

                foreach ($means as $value) {
                    $ret.= $value.";";       
                } 

                $ret.= "\n\r";
            }
        } else {
            return '系统错误，稍后再试。';
        }

        return $ret;
        
    }

	private function checkSignature()
	{
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];	
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}

?>