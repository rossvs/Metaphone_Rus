<?php
require_once 'metaphone_rus.php';

header('Content-type: text/html; charset=utf-8');
echo 'Облигация &rarr; ' . MetaPhoneRus('Облигация') . '<br>';
echo 'Аблигация &rarr; ' . MetaPhoneRus('Аблигация') . '<br>';