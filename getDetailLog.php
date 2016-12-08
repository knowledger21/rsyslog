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
    $priorityList = $_REQUEST['filterPriority'];
    $date01 = new DateTime($dateLog01);
    $date02 = new DateTime($dateLog02);
    $dateFormat01 = $date01->format('Y-m');
    $dateFormat02 = $date02->format('Y-m');
    $log = retrieve();
    output($log);
}

function retrieve() {
    global $db;
    global $dateFormat01;
    global $dateFormat02;
    global $priorityList;

    $sql = "select priority, count(*) as count, facility, message from systemevents";
    //where句の生成
    $sqlWhere = [];
    
    $stmt = $db->prepare("select count(*),priority,facility,message from systemevents "
            . "where priority = '0' or priority = '1' or priority = '2' "
            . "group by message,priority,facility "
            . "having (count(*) > 0) ;");
    $stmt->bindValue(':since_id', $since_id);
//    $setArray = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
//    $priorityArray = [0, 0, 0, 0, 0, 0, 0, 0, 0];
//    $arrayPriority = array();
//    $arrayLog = array();
//    $i = 0;
    //指定期間が二ヶ月以上の場合
//    while ($dateFormat01 <= $dateFormat02) {
//        array_push($arrayPriority, $priorityArray); //期間分,priority分の二次元配列を用意
//        $stmt = $db->prepare("select id,devicereportedtime,facility,priority,message from SystemEvents where encodedate = :date");
//        $stmt->bindValue(':date', $dateFormat01);
//        $stmt->execute();
//        $logObject = $stmt->fetchAll();
//        $j = 0;
//        foreach ($logObject as $loop) {
//            $arrayPriority[$i][$loop['priority']] ++;
//            $arrayLog[$i][$j] = $loop;
//            $j++;
//        }
//        $i++;
//        $dateFormat01 = date('Y-m', strtotime(date($dateFormat01) . '+1 month'));
//    }
//    return array($arrayPriority,$arrayLog);
}

function output($val) {
    header('Content-type: application/json');
    echo json_encode($val);
    exit;
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

