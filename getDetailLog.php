<?php

$db = new PDO('pgsql:dbname=Syslog;host=localhost;port=5432', 'rsyslog', 'knowledger21', array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ));
if (empty($_REQUEST['dateLog01']) && empty($_REQUEST['dateLog02'])) {
    exit;
} else {
    $dateLog01 = $_REQUEST['dateLog01'];
    $dateLog02 = $_REQUEST['dateLog02'];
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

    $setArray = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    $priorityArray = [0, 0, 0, 0, 0, 0, 0, 0, 0];
    $array = array();
    $i = 0;
    while ($dateFormat01 <= $dateFormat02) {
        array_push($array, $priorityArray); //期間分,priority分の二次元配列を用意
        $stmt = $db->prepare("select priority from SystemEvents where encodedate = :date");
        //以前
        //select priority from SystemEvents where to_date(devicereportedtime::text,'yyyy-mm') = to_date(:date,'yyyy-mm');
        $stmt->bindValue(':date', $dateFormat01);
        $stmt->execute();
        $logObject = $stmt->fetchAll();
        foreach ($logObject as $loop) {
            $array[$i][$loop['priority']] ++;
        }
        $i++;
        $dateFormat01 = date('Y-m', strtotime(date($dateFormat01) . '+1 month'));
    }
    return $array;
}

function output($val = array()) {
    header('Content-type: application/json');
    echo json_encode($val);
    exit;
}

//function retrieve() {
//    global $db;
//    global $dateLog01;
//    global $dateLog02;
//    $stmt = $db->prepare("select priority,devicereportedtime,message from SystemEvents where to_date(devicereportedtime::text,'yyyy-mm') between to_date(:dateLog01,'yyyy-mm') and to_date(:dateLog02,'yyyy-mm')");
//    $stmt->bindValue(':dateLog01' , $dateLog01);
//    $stmt->bindValue(':dateLog02' , $dateLog02);
//    $stmt->execute();
//    return $stmt->fetchAll();
//}
//
//function output($val = array()) {
//    header('Content-type: application/json');
//    echo json_encode($val);
//    exit;
//}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

