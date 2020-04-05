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
            $hash = hash("md5", "$times[0] $times[1]");
            $casesData[$i][$a] = ["start" => $times[0], "end" => $times[1], "hash" => $hash];
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

function solve($case) {
    $originalOrder = $case;
    usort($case, "cmpByTime");
    $solvedResult = [];
    $endingJ = 0;
    $endingC = 0;
    for ($act = 0; $act < count($case); $act++) {
        $hash = hash("md5", $case[$act]["start"]. " " . $case[$act]["end"]);
        if ($case[$act]["start"] >= $endingC) {
            $endingC = $case[$act]["end"];
            $solvedResult[$hash] = ["who" => "C"];
        } elseif ($case[$act]["start"] >= $endingJ) {
            $endingJ = $case[$act]["end"];
            $solvedResult[$hash] = ["who" => "J"];
        } else {
            return "IMPOSSIBLE";
        }
    }
    $output = "";
    foreach ($originalOrder as $key => $value) {
        $output .= $solvedResult[$value["hash"]]["who"];
    }
    return $output;
}