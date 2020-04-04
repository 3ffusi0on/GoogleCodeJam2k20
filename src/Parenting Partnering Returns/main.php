<?php
/*
 * Utils
 */
function getCasesDataFromInput()
{
    $casesData = [];
    $nbCases = intval(readline());
    for ($i = 0; $i < $nbCases; $i++) {
        $casesData[$i] = [];
        $nbActivities = intval(readline());
        for ($a = 0; $a < $nbActivities; $a++) {
            $times = explode(" ", readline());
            $casesData[$i][$a] = ["start" => $times[0], "end" => $times[1], "origin" => $a];
        }
    }
    return $casesData;
}

/*
 * Let"s roll
 */
$casesData = getCasesDataFromInput();
$caseNumber = 1;
foreach ($casesData as $case) {
    $result = solve($case);
    print_r("Case #$caseNumber: $result\n");
    $caseNumber++;
}

function cmpByTime($a, $b) {
    if ($a["start"] < $b["start"]) {
        return -1;
    } elseif ($a["start"] > $b["start"]) {
        return 1;
    } elseif ($a["end"] < $b["end"]) {
        return -1;
    } elseif ($a["end"] > $b["end"]) {
        return 1;
    }
    return 0;
}

function cmpOrigin($a, $b) {
    return $a["origin"] - $b["origin"];
}

function solve($case) {
    usort($case, "cmpByTime");
    $endingJ = 0;
    $endingC = 0;
    for ($act = 0; $act < count($case); $act++) {
        if ($case[$act]["start"] >= $endingC) {
            $endingC = $case[$act]["end"];
            $case[$act]["who"] = "C";
        } elseif ($case[$act]["start"] >= $endingJ) {
            $endingJ = $case[$act]["end"];
            $case[$act]["who"] = "J";
        }
    }

    $output = "";
    usort($case, "cmpOrigin");
    for ($act = 0; $act < count($case); $act++) {
        if (!array_key_exists("who", $case[$act])) {
            $output = "IMPOSSIBLE";
            break;
        }
        $output .= $case[$act]["who"];
    }
    return $output;
}