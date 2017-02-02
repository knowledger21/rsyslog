<?php
//本日の日付の取得
$test = date('Y-m-d');
if (empty($_REQUEST['since_id'])) {
    $since_id = 0;
} else {
    $since_id = (int) $_REQUEST['since_id'];
}

$db = new PDO('pgsql:dbname=Syslog;host=localhost;port=5432', 'rsyslog', 'knowledger21', array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ));

function retrieve($since_id = 0, $limit = 10) {
    global $db;
    global $test;
    //$stmt = $db->prepare(" SELECT id,devicereportedtime,facility,priority,message FROM SystemEvents where id > :since_id and to_char(devicereportedtime,'yyyy-mm-dd') = :dateTime ORDER BY id DESC");
    $stmt = $db->prepare(" SELECT id,devicereportedtime,facility,priority,message FROM SystemEvents WHERE id > :since_id ORDER BY id DESC");
    $stmt->bindValue(':since_id', $since_id);
    //$stmt->bindValue(':dateTime',$test);
    $stmt->execute();
    return $stmt->fetchAll();
}

function output($val = array()) {
    header('Content-type: application/json');
    echo json_encode($val);
    exit;
}

set_time_limit(45);
$timeline = retrieve($since_id);
if (empty($timeline)) {
    $db->exec('LISTEN rsyslog');
    $result = $db->pgsqlGetNotify(PDO::FETCH_ASSOC, 30000);
    if ($result === false) {
        output();
    }
    $timeline = retrieve($since_id);
}
output($timeline);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

