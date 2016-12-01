<!DOCTYPE html>
<!-- test -->
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
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
                            <li class="current-item" style="border-bottom: #FB8C00 2px solid;"><a href="./index.php">リアルタイム監視</a></li>
                            <li><a href="./detailLog.php">レポート出力</a></li>
                        </ul>
                    </nav>
                </div>
            </header>
            <div id="content">
                <div id="filter">
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
                            <input type="checkbox" checked="checked" class="priorityArea" value="4"> 4
                        </label>
                        <label>
                            <input type="checkbox" checked="checked" class="priorityArea" value="5"> 5
                        </label>
                        <label>
                            <input type="checkbox" checked="checked" class="priorityArea" value="6"> 6
                        </label>
                        <label>
                            <input type="checkbox" checked="checked" class="priorityArea" value="7"> 7
                        </label>
                    </div>

                    <div class="checkbox">
                        <p>facility</p>
                        <label>
                            <input type="checkbox" checked="checked" class="facilityArea" value="0"> kern
                        </label>
                        <label>
                            <input type="checkbox" checked="checked" class="facilityArea" value="1"> user
                        </label>
                        <label>
                            <input type="checkbox" checked="checked" class="facilityArea" value="2"> mail
                        </label>
                        <label>
                            <input type="checkbox" checked="checked" class="facilityArea" value="3"> daemon
                        </label>
                        <label>
                            <input type="checkbox" checked="checked" class="facilityArea" value="4"> auth
                        </label>
                        <label>
                            <input type="checkbox" checked="checked" class="facilityArea" value="5"> syslog
                        </label>
                        <label>
                            <input type="checkbox" checked="checked" class="facilityArea" value="6"> lpr
                        </label>
                        <label>
                            <input type="checkbox" checked="checked" class="facilityArea" value="7"> news
                        </label>
                        <label>
                            <input type="checkbox" checked="checked" class="facilityArea" value="8"> uucp
                        </label>
                        <label>
                            <input type="checkbox" checked="checked" class="facilityArea" value="9"> cron
                        </label>
                        <label>
                            <input type="checkbox" checked="checked" class="facilityArea" value="10"> authpriv
                        </label>
                        <label>
                            <input type="checkbox" checked="checked" class="facilityArea" value="11"> ftp
                        </label>
                        <br>
                        <label>
                            <input type="checkbox" checked="checked" class="facilityArea" value="12"> local0
                        </label>
                        <label>
                            <input type="checkbox" checked="checked" class="facilityArea" value="13"> local1
                        </label>
                        <label>
                            <input type="checkbox" checked="checked" class="facilityArea" value="14"> local2
                        </label>
                        <label>
                            <input type="checkbox" checked="checked" class="facilityArea" value="15"> local3
                        </label>
                        <label>
                            <input type="checkbox" checked="checked" class="facilityArea" value="16"> local4
                        </label>
                        <label>
                            <input type="checkbox" checked="checked" class="facilityArea" value="17"> local5
                        </label>
                        <label>
                            <input type="checkbox" checked="checked" class="facilityArea" value="18"> local6
                        </label>
                        <label>
                            <input type="checkbox" checked="checked" class="facilityArea" value="19"> local7
                        </label>
                    </div>

                    <div class="form-group label-floating">
                        <label class="control-label" for="focusedInput1">Message検索</label>
                        <input class="form-control" id="focusedInput1" type="text">
                    </div>
                    <p id="filterBtn"><a class="btn btn-raised btn-default">フィルターをかける</a></p>
                </div>
                <div class="clusterize">
                    <table>
                        <thead>
                            <tr>
                                <th scope="col" class="logDate">Date</th>
                                <th scope="col" class="logFacility">Facility</th>
                                <th scope="col" class="logPriorty">Priorty</th>
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
                </div>
                <canvas id="priorityChart" width="1200" height="400"></canvas>
            </div>
        </div>
        <script>
            //facility
            var facilityData = ["kern", "user", "mail", "daemon", "auth", "syslog", "lpr", "news", "uucp", "cron", "authpriv", "ftp",
                "local0", "local1", "local2", "local3", "local4", "local5", "local6", "local7"];
            //ログ格納 && Filter
            var data = [];//取得してきたlogデータ
            var filterPriority = [];//チェックされたpriorityを格納
            var filterFacility = [];//チェックされたfacilityを格納
            var search = document.getElementById('focusedInput1');
            var searchWord = '';
            var filterFlg = false;//デフォルト(priority0-9のチェックのみ)ならfalse
            //ログ表示用関数
            var filterRows = function (rows, filterPriority) {
                var filterData = [];//filterをかけたあとのdata
                if (!filterFlg) {
                    for (var i = 0, ii = rows.length; i < ii; i++) {
                        if (rows[i].active)
                            filterData.push(rows[i].markup);
                    }
                } else {
                    //priority,messageでのfilter
//                    for (var i = 0, ii = rows.length; i < ii; i++) {
//                        for (var j = 0; j < filterPriority.length; j++) {
//                            for (var k = 0; k < filterFacility.length; k++) {
//                                if (null == search.value || '' == search.value) {//searchが空白かnullだったらpriority,facilityのみでのfilter
//                                    if (rows[i].active && rows[i].values[1] == filterFacility[k] && rows[i].values[2] == filterPriority[j]) {//rows[i].values[1] == 1
//                                        filterData.push(rows[i].markup);
//                                    }
//                                } else {//searchが入力されたら検索ワード、priorityでのfilter
//                                    if (rows[i].active && rows[i].values[1] == filterFacility[k] && rows[i].values[2] == filterPriority[j] && rows[i].values[3].match(search.value)) {//rows[i].values[1] == 1
//                                        filterData.push(rows[i].markup);
//                                    }
//                                }
//                            }
//                        }
//
//                    }

                    var filterDataBk1 = [];
                    //まずsearchWordでの絞込
                    for (var i = 0; i < rows.length; i++) {
                        if (rows[i].values[3].indexOf(search.value) != -1) {
                            filterDataBk1.push(rows[i]);
                        }
                    }
                    console.table(filterDataBk1);

                    for (var i = 0, ii = filterDataBk1.length; i < ii; i++) {
                        for (var j = 0; j < filterPriority.length; j++) {
                            for (var k = 0; k < filterFacility.length; k++) {
                                if (filterDataBk1[i].active && filterDataBk1[i].values[1] == filterFacility[k] && filterDataBk1[i].values[2] == filterPriority[j]){
                                    filterData.push(filterDataBk1[i].markup);
                                }
                            }
                        }
                    }
                    console.table(filterData);

//                    //facilityでの絞込
//                    for (var i = 0; i < filterDataBk1.length; i++) {
//                        for (var j = 0; j < filterFacility.length; j++) {
//                            if (filterDataBk1[i].values[1] == filterFacility[j]) {
//                                filterDataBk2.push(rows[filterDataBk1]);
//                            }
//                        }
//                    }
//                    //priorityでの絞込
//                    for (var i = 0; i < filterDataBk2.length; i++) {
//                        for (var j = 0; j < filterPriority.length; j++) {
//                            if (filterDataBk2[i].values[2] == filterPriority[j]) {
//                                filterData.push(rows[filterDataBk1]);
//                            }
//                        }
//                    }
                }
                return filterData;
            }

            var clusterize = new Clusterize({
                rows: filterRows(data),
                scrollId: 'scrollArea',
                contentId: 'contentArea'
            });
            //filterのボタンが押されたときの関数
            $(function () {
                $('#filterBtn').click(function () {
                    //チェックされたpriorityを取得
                    filterPriority.length = 0;
                    filterPriority = $('.priorityArea:checked').map(function () {
                        return $(this).val();
                    }).get();

                    //チェックボックスされたfacilityを取得
                    filterFacility.length = 0;
                    filterFacility = $('.facilityArea:checked').map(function () {
                        return $(this).val();
                    }).get();

                    if (filterPriority.length == 8 && (null == search.value || '' == search.value) && filterFacility.length == 20) {
                        filterFlg = false;
                        clusterize.clear();
                        clusterize.update(filterRows(data, filterPriority, filterFacility));
                    } else {
                        filterFlg = true;
                        searchWord = search.value;
                        clusterize.clear();
                        clusterize.update(filterRows(data, filterPriority, filterFacility));
                    }
                });
            });



            //データ受取
            var priorityChart01 = [
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
            ];//縦はpriority,横は時間
            var ctx = document.getElementById("priorityChart");
            var priorityLineChart = new Chart(ctx, {
                //グラフの種類
                type: 'line',
                //データの設定
                data: {
                    //データ項目のラベル
                    labels: ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23"],
                    //データセット
                    datasets: [{
                            //凡例
                            label: "priority:0",
                            //面の表示
                            fill: false,
                            //線のカーブ
                            lineTension: 0,
                            //背景色
                            backgroundColor: "rgba(183,28,28,0.4)",
                            //枠線の色
                            borderColor: "rgba(183,28,28,1)",
                            //結合点の背景色
                            pointBackgroundColor: "#fff",
                            //グラフのデータ
                            data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                        }, {
                            //凡例
                            label: "priority:1",
                            //面の表示
                            fill: false,
                            //線のカーブ
                            lineTension: 0,
                            //背景色
                            backgroundColor: "rgba(74,20,140,0.4)",
                            //枠線の色
                            borderColor: "rgba(74,20,140,1)",
                            //結合点の背景色
                            pointBackgroundColor: "#fff",
                            //グラフのデータ
                            data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                        }, {
                            //凡例
                            label: "priority:2",
                            //面の表示
                            fill: false,
                            //線のカーブ
                            lineTension: 0,
                            //背景色
                            backgroundColor: "rgba(13,71,161,0.4)",
                            //枠線の色
                            borderColor: "rgba(13,71,161,1)",
                            //結合点の背景色
                            pointBackgroundColor: "#fff",
                            //グラフのデータ
                            data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                        }, {
                            //凡例
                            label: "priority:3",
                            //面の表示
                            fill: false,
                            //初期で非表示
                            hidden: true,
                            //線のカーブ
                            lineTension: 0,
                            //背景色
                            backgroundColor: "rgba(0,96,100,0.4)",
                            //枠線の色
                            borderColor: "rgba(0,96,100,1)",
                            //結合点の背景色
                            pointBackgroundColor: "#fff",
                            //グラフのデータ
                            data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                        }, {
                            //凡例
                            label: "priority:4",
                            //面の表示
                            fill: false,
                            //初期で非表示
                            hidden: true,
                            //線のカーブ
                            lineTension: 0,
                            //背景色
                            backgroundColor: "rgba(27,94,32,0.4)",
                            //枠線の色
                            borderColor: "rgba(27,94,32,1)",
                            //結合点の背景色
                            pointBackgroundColor: "#fff",
                            //グラフのデータ
                            data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                        }, {
                            //凡例
                            label: "priority:5",
                            //面の表示
                            fill: false,
                            //初期で非表示
                            hidden: true,
                            //線のカーブ
                            lineTension: 0,
                            //背景色
                            backgroundColor: "rgba(130,119,23,0.4)",
                            //枠線の色
                            borderColor: "rgba(130,119,23,1)",
                            //結合点の背景色
                            pointBackgroundColor: "#fff",
                            //グラフのデータ
                            data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                        }, {
                            //凡例
                            label: "priority:6",
                            //面の表示
                            fill: false,
                            //初期で非表示
                            hidden: true,
                            //線のカーブ
                            lineTension: 0,
                            //背景色
                            backgroundColor: "rgba(255,111,0,0.4)",
                            //枠線の色
                            borderColor: "rgba(255,111,0,1)",
                            //結合点の背景色
                            pointBackgroundColor: "#fff",
                            //グラフのデータ
                            data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                        }, {
                            //凡例
                            label: "priority:7",
                            //面の表示
                            fill: false,
                            //初期で非表示
                            hidden: true,
                            //線のカーブ
                            lineTension: 0,
                            //背景色
                            backgroundColor: "rgba(191,54,12,0.4)",
                            //枠線の色
                            borderColor: "rgba(191,54,12,1)",
                            //結合点の背景色
                            pointBackgroundColor: "#fff",
                            //グラフのデータ
                            data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                        }
                    ]
                },
                //オプションの設定
                options: {
                    scales: {
                        //縦軸の設定
                        yAxes: [{
                                ticks: {
                                    //最小値を0にする
                                    beginAtZero: true
                                }
                            }]
                    }
                }
            });
            //件数が大量にある場合重くなるためAll logは停止
            //log受取
            $(function () {
                var retrieve_and_display = (function () {
                    var current_id = 0;
                    return function () {
                        $.post('getSyslog.php', {since_id: current_id})
                                .done(function (result) {
                                    if (result.length > 0) {
                                        current_id = result[0].id;
                                        console.log(current_id);
                                        result.reverse();
                                        var result_length = result.length;
                                        console.time('timer1');
                                        //$.each(result, function () {
                                        for (var i = 0; i < result_length; i++) {
                                            data.unshift({
                                                values: [result[i].devicereportedtime, result[i].facility, result[i].priority, result[i].message],
                                                markup: '<tr><td class="center logDate">' + result[i].devicereportedtime + '</td><td class="center logFacility">' + facilityData[result[i].facility] + '</td><td class="center logPriorty">' + result[i].priority + '</td><td class="logMessage">' + result[i].message + '</td></tr>',
                                                active: true
                                            });

//                                            //時間別にpriority0-3の数を数える
                                            var logDate = new Date(result[i].devicereportedtime);//時間を取得
                                            //時間別優先度別に値を取得
                                            switch (result[i].priority) {//優先度によって分ける
                                                case 0:
                                                    priorityChart01[0][logDate.getHours()]++;
                                                    break;
                                                case 1:
                                                    priorityChart01[1][logDate.getHours()]++;
                                                    break;
                                                case 2:
                                                    priorityChart01[2][logDate.getHours()]++;
                                                    break;
                                                case 3:
                                                    priorityChart01[3][logDate.getHours()]++;
                                                    break;
                                                case 4:
                                                    priorityChart01[4][logDate.getHours()]++;
                                                    break;
                                                case 5:
                                                    priorityChart01[5][logDate.getHours()]++;
                                                    break;
                                                case 6:
                                                    priorityChart01[6][logDate.getHours()]++;
                                                    break;
                                                case 7:
                                                    priorityChart01[7][logDate.getHours()]++;
                                                    break;
                                            }
                                        }
                                        console.log(data);
                                        //グラフ生成
                                        for (var i = 0; i < 8; i++) {
                                            for (var j = 0; j < 24; j++) {
                                                priorityLineChart.data.datasets[i].data[j] = priorityChart01[i][j];
                                            }
                                        }
                                        //test();
                                        priorityLineChart.update();
                                        clusterize.update(filterRows(data, filterPriority));
                                        //console.table(data);
                                    }
                                    console.timeEnd('timer1');

                                    retrieve_and_display();
                                });
                    };
                })();

                retrieve_and_display();
            });

        </script>
        <script>
            $.material.init();
        </script>
    </body>
</html>
