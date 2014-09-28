<?php
require 'api.php';

$word = trim($_POST['word']);
$from = trim($_POST['from']);
$to = getTo($from);

$translate = new Translate();
$ret = $translate->getTranslate($word, $from, $to);

echo $ret;

die();
function getTo($from) {
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
?> 