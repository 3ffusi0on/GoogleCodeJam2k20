<?php
/*
 * Utils
 */
function getCasesDataFromInput()
{
    $casesData = [];
    $nbCases = intval(readline());
    for ($i = 0; $i < $nbCases; $i++) {
        $casesData[$i] = readline();
    }
    return $casesData;
}

/*
 * Let's roll
 */
$casesData = getCasesDataFromInput();
$caseNumber = 1;
foreach ($casesData as $case) {
    $result = solve($case);
    print_r("Case #$caseNumber: $result\n");
    $caseNumber++;
}

function solve($case) {
    $currentDetpth = 0;
    $output = "";

    foreach (str_split($case) as $digit) {
        while (intval($digit) < $currentDetpth) {
            $currentDetpth--;
            $output .= ")";
        }

        while (intval($digit) > $currentDetpth) {
            $currentDetpth++;
            $output .= "(";
        }
        $output .= $digit;

    }
    while ($currentDetpth > 0) {
        $currentDetpth--;
        $output .= ")";
    }
    return $output;
}