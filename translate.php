<?php
define('__ROOT__', dirname(__FILE__));
require_once __ROOT__.'/api/api.php';

$client = new client();
$client->translate();

/****************** client class *************************************************/

class client {

    public function translate() {
        $word = trim($_POST['word']);
        $from = trim($_POST['from']);

        if(empty($word)) {
            $ret = array(
                'errno' => 2,
                'errmsg' => 'Param(word) error!',
            );
            $this->ajax_return($ret);
        }

        if(empty($from)) {
            $ret = array(
                'errno' => 2,
                'errmsg' => 'Param(from) error!',
            );
            $this->ajax_return($ret);
        }

        $to = $this->getTo($from);

        $translate = new Translate();
        $ret = $translate->getTranslate($word, $from, $to);

        if(empty($ret)) {
            $ret = array(
                'errno' => 1,
                'errmsg' => 'System error!',
            );
        }

        $this->ajax_return($ret);
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

    private function ajax_return($param) {
        echo json_encode($param);
    }
}

?> 