<?php

//グラフを取得せず、messageの重複分だけ持ってくる
$db = new PDO('pgsql:dbname=Syslog;host=localhost;port=5432', 'rsyslog', 'knowledger21', array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ));
if (empty($_REQUEST['dateLog01']) && empty($_REQUEST['dateLog02'])) {
    exit;
} else {
    $dateLog01 = $_REQUEST['dateLog01'];
    $dateLog02 = $_REQUEST['dateLog02'];
    $priorityList = json_decode($_REQUEST['filterPriority']);
    //echo 'priorityList' . $priorityList;
//    $date01 = new DateTime($dateLog01);
//    $date02 = new DateTime($dateLog02);
//    $dateFormat01 = $date01->format('Y-m');
//    $dateFormat02 = $date02->format('Y-m');
    $log = retrieve();
    output($log);
}

function retrieve() {
    global $db;
    global $dateLog01;
    global $dateLog02;
    global $priorityList;

    $sql = "select priority, count(*) as count, facility, message from systemevents";
    //where句の生成
    $sqlWhere = [];
    $sqlParams = [];
//    foreach ($priorityList as $list) {
//        array_push($sqlWhere, "priority = ?");
//        array_push($sqlParams, $list);
//    }
    for ($i = 0; $i < count($priorityList); $i++) {
        array_push($sqlWhere, "priority = ?");
        array_push($sqlParams, $priorityList[$i]);
    }
    //priorityをすべて外すとエラー
    //sql組み立て
    //priorityのwhere句生成
    if (count($sqlWhere) > 0) {
        $sql .= ' where (' . implode(" or ", $sqlWhere) . " )";
    }
    //dateのwhere句組み立て
    //dateの日付が同じであればencodedate = 'yyyyx-mm'でよい
    if ($dateLog01 === $dateLog02) {
        $sql .= " and encodedate = ?";
        array_push($sqlParams, $dateLog01);
    } else {
        $sql .= " and (encodedate between ? and ?)";
        array_push($sqlParams, $dateLog01);
        array_push($sqlParams, $dateLog02);
    }
    //group by句とhaving句の生成
    $sql .= " group by message,priority,facility having (count(*) > 0)";

    $stmt = $db->prepare($sql);
    $stmt->execute($sqlParams);
//    $logObject = $stmt->fetchAll();
//    return array($logObject);
    return $stmt->fetchAll();
}

function output($val = array()) {
    header('Content-type: application/json');
    echo json_encode($val);
    exit;
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

