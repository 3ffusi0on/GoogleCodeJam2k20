<?php
/*
 * Utils
 */
function getCasesDataFromInput()
{
    $casesData = [];
    $nbCases = intval(readline());
    for ($i = 0; $i < $nbCases; $i++) {
        $nbLines = intval(readline());
        $casesData[$i] = [];
        for ($l = 0; $l < $nbLines; $l++) {
            $casesData[$i][$l] = explode(" ", readline());
        }
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
    $trace = 0;
    $multipleOccurenceInRow = 0;
    $matchedRow = [];
    $multipleOccurenceInCol = 0;
    $matchedCol = [];

    for ($row = 0; $row < count($case); $row++) {
        for ($col = 0; $col < count($case); $col++) {
            if (!in_array($row, $matchedRow)) {
                if (in_array($case[$row][$col], array_slice($case[$row], $col + 1))) {
                    $multipleOccurenceInRow++;
                    $matchedRow[] = $row;
                }
            }

            if (!in_array($col, $matchedCol)) {
                $column = getColumn($case, $col);
                if (in_array($case[$row][$col], array_slice($column, $row + 1))) {
                    $multipleOccurenceInCol++;
                    $matchedCol[] = $col;
                }
            }

            if ($row === $col) {
                $trace += $case[$row][$col];
            }

        }
    }

    return "$trace $multipleOccurenceInRow $multipleOccurenceInCol";
}

function getColumn($case, $index) {
    $column = [];
    for ($i= 0; $i < count($case); $i++) {
        $column[] = $case[$i][$index];
    }
    return $column;
}