<?php

$url = 'https://translate.googleapis.com/translate_a/single?client=gtx&sl=ne&tl=en&dt=rm&q=' . urlencode('मेरो देश नेपाल');

echo "Requesting: $url\n";
$response = file_get_contents($url);

echo "Response:\n$response\n";
