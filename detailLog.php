<?php
$db = new PDO('pgsql:dbname=Syslog;host=localhost;port=5432', 'rsyslog', 'knowledger21', array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ));
//別テーブルかtxtに書いておいたほうがはやい
$stmt = $db->prepare("SELECT min(encodedate) as minDate FROM SystemEvents ;");
$stmt->execute();
$minDate = $stmt->fetchColumn(0);
$stmt = $db->prepare("SELECT max(encodedate) as maxDate FROM SystemEvents ;");
$stmt->execute();
$maxDate = $stmt->fetchColumn(0);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>レポート出力</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="./js/jquery-3.1.1.min.js"></script>
        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>-->
        <script src="./js/Chart.min_2.4.js"></script>
        <script src="./js/bootstrap.min.js"></script>
        <script src="./js/material.min.js"></script>
        <script src="./js/ripples.min.js"></script>
        <script src="./js/clusterize.min.js"></script>
        <link rel="stylesheet" type="text/css" href="./css/reset.css">
        <link rel="stylesheet" type="text/css" href="./css/clusterize.css">
        <link rel="stylesheet" type="text/css" href="./css/bootstrap-material-design.min.css">
        <link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="./css/ripples.min.css">
        <link rel="stylesheet" type="text/css" href="./css/common.css">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet"> 
    </head>
    <body>
        <div id="wrapper">
            <header>
                <h1 id="title">Keep your Server</h1>
                <div id="navi">
                    <nav id="navigation">
                        <ul>
                            <li><a href="./index.php">リアルタイム監視</a></li>
                            <li style="border-bottom: #FB8C00 2px solid;"><a href="./detailLog.php">レポート出力</a></li>
                        </ul>
                    </nav>
                </div>
            </header>

            <div id="content" class="loadingCSS">
                <form name="selectForm">
                    <div class="form-group selectInline">
                        <label for="select111" class="control-label">年</label>
                        <select id="select111" name="selectYear01" class="form-control selectYear">
                            <!-- year  -->
                        </select>
                    </div>
                    <div class="form-group selectInline">
                        <label for="select111" class="control-label">月</label>
                        <select id="select111" name="selectMonth01" class="form-control">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>

                    <p class="selectInline center">から</p>

                    <div class="form-group selectInline">
                        <label for="select111" class="control-label">年</label>
                        <select id="select111" name="selectYear02" class="form-control selectYear">
                            <!-- year  -->
                        </select>
                    </div>
                    <div class="form-group selectInline">
                        <label for="select111" class="control-label">月</label>
                        <select id="select111" name="selectMonth02" class="form-control">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>                    
                        </select>
                    </div>
                    <div class="checkbox">
                        <p>priority</p>
                        <label>
                            <input type="checkbox" checked="checked" class="priorityArea" value="0"> 0
                        </label>
                        <label>
                            <input type="checkbox" checked="checked" class="priorityArea" value="1"> 1
                        </label>
                        <label>
                            <input type="checkbox" checked="checked" class="priorityArea" value="2"> 2
                        </label>
                        <label>
                            <input type="checkbox" checked="checked" class="priorityArea" value="3"> 3
                        </label>
                        <label>
                            <input type="checkbox"  class="priorityArea" value="4"> 4
                        </label>
                        <label>
                            <input type="checkbox" class="priorityArea" value="5"> 5
                        </label>
                        <label>
                            <input type="checkbox" class="priorityArea" value="6"> 6
                        </label>
                        <label>
                            <input type="checkbox" class="priorityArea" value="7"> 7
                        </label>
                    </div>
                    <p id="showBtn" style="display: inline-block; margin-bottom: -4px;"><a style="margin-top: -4px;" class="btn btn-raised btn-default">表示する</a></p>
                </form>
                <canvas id="DetailChart" width="1200" height="500"></canvas>
            </div>
        </div>
        <script>
            //ログの一番古い日にちと新しい日にちを取得しselect にセット
            var maxDate = new Date(<?php echo json_encode($maxDate); ?>);
            var minDate = new Date(<?php echo json_encode($minDate); ?>);
            var i = maxDate.getFullYear();
            for (i; i > minDate.getFullYear() - 1; i--) {
                $('.selectYear').append($('<option>').html(i).val(i));
            }

        </script>
        <script>
            var filterPriority = [];
            //グラフ用
            //var label = [];
            //var data = [];
            var priorityNum = [0, 0, 0, 0];//0-3のpriority数
            //var test = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23"]; 
            //var priorityChart = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]; //時間別のログ数を格納(priorityLog
            var priorityChart01 = [
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
            ];//縦はpriority,横は時間


            //指定期間のログを取得
            var getLog = function (dateLog01, dateLog02) {
                var jqXHR = $.ajax({
                    url: 'getDetailLog.php',
                    data: {
                        'dateLog01': dateLog01,
                        'dateLog02': dateLog02
                    }
                });
                return jqXHR.promise();
            };

            //件数が多いとメモリ不足になる
            $(function () {
                $('#showBtn').click(function () {
                    //selectbox取得
                    var dateLog01 = document.selectForm.selectYear01.value + "-" + document.selectForm.selectMonth01.value;
                    var dateLog02 = document.selectForm.selectYear02.value + "-" + document.selectForm.selectMonth02.value;
                    var date01 = new Date(dateLog01);
                    var date02 = new Date(dateLog02);
                    if (date02 < date01) {
                        alert('期間の設定が間違っています。');
                        return;
                    }
                    if (oneYear(date01, date02) > 12) {
                        alert('選択できる期間は一年以内です');
                        return;
                    }
                    createLoading();
                    filterPriority.length = 0;
                    filterPriority = $('.priorityArea:checked').map(function () {
                        return $(this).val();
                    }).get();
                    getLog(dateLog01, dateLog02, filterPriority)
                            .then(function (result) {
//                                createChart(createLabel(date01, date02), createData(result[0]));
//                                console.table(result[1]);
                                removeLoading();
                            }, function () {
                                alert('ログの取得に失敗しました');
                            });
                });
            });

            //1年以内
            function oneYear(date01, date02) {
                var date01ms = date01.getTime();
                var date02ms = date02.getTime();
                var count = 0;
                while (date01ms <= date02ms) {
                    var newDate = new Date(date01ms);
                    newDate.setMonth(newDate.getMonth() + 1);
                    date01ms = newDate.getTime();
                    count++;
                }
                return count;
            }

            //labelの設定
//            function createLabel(date01, date02) {
//                var date01ms = date01.getTime();
//                var date02ms = date02.getTime();
//                var label = [];
//                while (date01ms <= date02ms) {
//                    var newDate = new Date(date01ms);
//                    newDate.setMonth(newDate.getMonth() + 1);
//                    if (newDate.getMonth() === 0) {
//                        label.push(newDate.getFullYear() - 1 + '/12');
//                    } else {
//                        label.push(newDate.getFullYear() + '/' + newDate.getMonth());
//                    }
//                    date01ms = newDate.getTime();
//                }
//                return label;
//            }

            //dataの設定
//            function createData(result) {
//                var data = [];
//                for (var i = 0; i < result.length; i++) {
//                    data.push(result[i][0]);
//                }
//                return data;
//            }
//
//            //グラフ描画
//            function createChart(label, data) {
//                var ctx = document.getElementById("DetailChart");
//                var priorityLineChart = new Chart(ctx, {
//                    //グラフの種類
//                    type: 'line',
//                    //データの設定
//                    data: {
//                        //データ項目のラベル
//                        labels: label,
//                        //データセット
//                        datasets: [{
//                                //凡例
//                                label: "priority:0",
//                                //面の表示
//                                fill: false,
//                                //線のカーブ
//                                lineTension: 0,
//                                //背景色
//                                backgroundColor: "rgba(183,28,28,0.4)",
//                                //枠線の色
//                                borderColor: "rgba(183,28,28,1)",
//                                //結合点の背景色
//                                pointBackgroundColor: "#fff",
//                                //グラフのデータ
//                                data: data
//                                        ////[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
//                            }
//                        ]
//                    },
//                    //オプションの設定
//                    options: {
//                        scales: {
//                            //縦軸の設定
//                            yAxes: [{
//                                    ticks: {
//                                        //最小値を0にする
//                                        beginAtZero: true
//                                    }
//                                }]
//                        }
//                    }
//                });
//            }

            //ロード画面表示
            function createLoading() {
                $('#content').append("<div class='loader'></div>");

            }
            function removeLoading() {
                $('.loader').remove();
            }
        </script>
        <script>
            $.material.init();
        </script>
    </body>
</html>
