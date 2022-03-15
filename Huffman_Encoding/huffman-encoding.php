<?php


function unite_smallest($array)
{
    $lastTwoElems = array_splice($array, -2, 2);
    $probabilitySum = 0;
    foreach ($lastTwoElems as $elem) {
        $probabilitySum += $elem;
    }
    $keyName = array_keys($lastTwoElems)[0] . array_keys($lastTwoElems)[1];
    $array[$keyName] = $probabilitySum;
    arsort($array);
    return $array;
}


function assignment_codes($array, $charArray)
{
    $lastTwoElems = array_splice($array, -2, 2);
    $ff = [];
    foreach ($lastTwoElems as $elem) {
        array_push($ff, $elem);
    }
    arsort($ff);
    $repeatingKey = true;
    foreach ($lastTwoElems as $elem) {
        if ($ff[1] === $ff[0]) {
            if ($repeatingKey) {
                foreach (str_split((array_keys($lastTwoElems, $elem)[0]), 1) as $item) {
                    $charArray[$item] .= '0';
                    $repeatingKey = false;
                }
            }
            else {
                foreach (str_split((array_keys($lastTwoElems, $elem)[1]), 1) as $item) {
                    $charArray[$item] .= '1';
                    $repeatingKey = true;
                }
            }
        }
        else {
            if ($elem === $ff[0]) {
                foreach (str_split((array_search($elem, $lastTwoElems)), 1) as $item) {
                    $charArray[$item] .= '0';
                }
            }
            else {
                foreach (str_split((array_search($elem, $lastTwoElems)), 1) as $item) {
                    $charArray[$item] .= '1';
                }
            }
        }
    }
    return $charArray;
}

echo 'enter your string:'.PHP_EOL;
$inputString = readline();
$charUniqueArray = array_unique(str_split($inputString, 1));
$alphabetArray = [];
$charCodesArray = [];
foreach ($charUniqueArray as $char) {
    $charCodesArray[$char] = '';
    $alphabetArray[$char] = (substr_count($inputString, $char) / mb_strlen($inputString));
}

arsort($alphabetArray);
$newAlphabetArray = $alphabetArray;
$allAlphabetsArray['level-0'] = $newAlphabetArray;

for ($i = 1; $i < count($alphabetArray) - 1; $i++) {
    $newAlphabetArray = unite_smallest($newAlphabetArray);
    $allAlphabetsArray['level-' . $i] = $newAlphabetArray;
}
$allAlphabetsArray = array_reverse($allAlphabetsArray);

for ($i = count($allAlphabetsArray) - 1; $i >= 0 ; $i--) {
    $charCodesArray = (assignment_codes($allAlphabetsArray['level-' . $i], $charCodesArray));
}

echo 'code table: '.PHP_EOL;
print_r($charCodesArray);
echo 'your encrypted string: ';
foreach (str_split($inputString, 1) as $char) {
    echo $charCodesArray[$char];
}