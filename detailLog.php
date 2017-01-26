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
                            <option value="01">1</option>
                            <option value="02">2</option>
                            <option value="03">3</option>
                            <option value="04">4</option>
                            <option value="05">5</option>
                            <option value="06">6</option>
                            <option value="07">7</option>
                            <option value="08">8</option>
                            <option value="09">9</option>
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
                            <option value="01">1</option>
                            <option value="02">2</option>
                            <option value="03">3</option>
                            <option value="04">4</option>
                            <option value="05">5</option>
                            <option value="06">6</option>
                            <option value="07">7</option>
                            <option value="08">8</option>
                            <option value="09">9</option>
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
                    <p id="showBtn" style="display: inline-block; margin-bottom: -4px; pointer-events: auto;"><a style="margin-top: -4px;" class="btn btn-raised btn-default">表示する</a></p>
                    <!--                クリックイベントを拒否するcss pointer-events: none;-->
                </form>
                <div class="clusterize" id="reportTable">
                    <table>
                        <thead>
                            <tr>
                                <th scope="col" class="logPriorty">priority</th>
                                <th scope="col" class="logFacility">count</th>
                                <th scope="col" class="logDate" >facility</th>
                                <th scope="col" class="logMessage">Message</th>
                            </tr>
                        </thead>
                    </table>
                    <div id="scrollArea" class="clusterize-scroll">
                        <table>
                            <tbody id="contentArea" class="clusterize-content">
                                <tr class="clusterize-no-data">
                                    <td>Loading data…</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!--                    <button id="reportBtn">レポートを出力</button>-->
                    <form id="reportFrom" action="./downloadReport.php" method="post">
                        <button class="btn btn-default" type="submit">レポート出力</button>
                    </form>
                </div>
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
            //monthを1ではなく01にする
            $("#reportTable").hide();
            var dateLog01 = '';
            var dateLog02 = '';
            var reportList = [];
            var data = [];//取得してきたlogデータ
            var filterPriority = [];
            var facilityData = ["kern", "user", "mail", "daemon", "auth", "syslog", "lpr", "news", "uucp", "cron", "authpriv", "ftp",
                "local0", "local1", "local2", "local3", "local4", "local5", "local6", "local7"];
            var clusterize = new Clusterize({
                rows: getData(data),
                scrollId: 'scrollArea',
                contentId: 'contentArea'
            });
            //指定期間のログを取得
            var getLog = function (dateLog01, dateLog02, filterPriority) {
                var jqXHR = $.ajax({
                    url: 'getDetailLog.php',
                    data: {
                        'dateLog01': dateLog01,
                        'dateLog02': dateLog02,
                        'filterPriority': filterPriority
                    }
                });
                return jqXHR.promise();
            };

            //件数が多いとメモリ不足になる
            $(function () {
                $('#showBtn').click(function () {
                    //表示ボタンを押せなくする
                    $('#showBtn').css('pointer-events', 'none');
                    //selectbox取得
                    dateLog01 = document.selectForm.selectYear01.value + "-" + document.selectForm.selectMonth01.value;
                    dateLog02 = document.selectForm.selectYear02.value + "-" + document.selectForm.selectMonth02.value;
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
                    console.log(dateLog01 + ',' + dateLog02 + ',' + JSON.stringify(filterPriority));
                    getLog(dateLog01, dateLog02, JSON.stringify(filterPriority))
                            .then(function (result) {
                                data = [];
                                clusterize.clear();
                                $("#reportTable").show();
                                //console.table(result);
                                var result_length = result.length;
                                for (var i = 0; i < result_length; i++) {
                                    data.unshift({
                                        values: [result[i].priority, result[i].count, result[i].facility, result[i].message],
                                        markup: '<tr><td class="center logPriorty">' + result[i].priority + '</td><td class="center logFacility">' + result[i].count + '</td><td class="center logDate">' + facilityData[result[i].facility] + '</td><td class="logMessage">' + result[i].message + '</td></tr>',
                                        active: true
                                    });
                                }
                                clusterize.update(getData(data));

                                //test formによるレポートダウンロード
                                reportList.length = 0;
//                                for (var i = 0; i < data.length; i++) {
//                                    reportList.push(data[i].values);
//                                }
                                //formに値をセット
                                $('#reportFrom').prepend('<input type="hidden" name="dateLog01" value="' + dateLog01 + '">');
                                $('#reportFrom').prepend('<input type="hidden" name="dateLog02" value="' + dateLog02 + '">');
                                //console.log(data[0].values.length);
                                for (var i = 0; i < data.length; i++) {
                                    for (var j = 0; j < data[i].values.length; j++) {
//                                        console.log(data[i][j]);
                                        $('#reportFrom').prepend('<input type="hidden" name="reportList[' + i + '][' + j + ']" value="' + data[i].values[j] + '">');
                                    }
                                }

                                //終了
                                removeLoading();
                                //表示ボタンを押せなくする
                                $('#showBtn').css('pointer-events', 'auto');
                            }
                            , function () {
                                alert('ログの取得に失敗しました');
                                removeLoading();
                                //表示ボタンを押せなくする
                                $('#showBtn').css('pointer-events', 'auto');
                            });
                });
            });

            function getData(data) {
                var getDataList = [];
                for (var i = 0; i < data.length; i++) {
                    getDataList.push(data[i].markup)
                }
                return getDataList;
            }
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
