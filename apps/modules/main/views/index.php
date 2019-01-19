<div class="block-header">
    <h2>DASHBOARD MUTU SEMUA UNIT</h2>
</div>

<!-- Widgets -->
<div class="row clearfix">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-pink hover-expand-effect">
            <div class="icon">
                <i class="material-icons">local_offer</i>
            </div>
            <div class="content">
                <div class="text">JUMLAH UNIT PELAYANAN</div>
                <div class="number" ><?= $wiget_top['jml_unit']; ?></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-cyan hover-expand-effect">
            <div class="icon">
                <i class="material-icons">stars</i>
            </div>
            <div class="content">
                <div class="text">JUMLAH INDIKATOR MUTU</div>
                <div class="number"><?= $wiget_top['jml_indikator']; ?></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-light-green hover-expand-effect">
            <div class="icon">
                <i class="material-icons">forum</i>
            </div>
            <div class="content">
                <div class="text">RATA-RATA PENILAIAN MUTU SEMUA UNIT</div>
                <div class="number" ><?= $wiget_top['avg_all_unit']; ?></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-orange hover-expand-effect">
            <div class="icon">
                <i class="material-icons">person_add</i>
            </div>
            <div class="content">
                <div class="text">PERIODE AKTIF</div>
                <div class="number" ><?= $wiget_top['periode_nilai']; ?></div>
            </div>
        </div>
    </div>
</div>
<!-- #END# Widgets -->
<div class="row clearfix">
    <!-- Task Info -->
    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
        <div class="card">
            <div class="header">
                <h2>RATA-RATA PENILAIAN MUTU PER UNIT</h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-hover dashboard-task-infos dataTable">
                        <thead>
                            <tr>
                                <th style="width: 10px;">#</th>
                                <th >Unit</th>
                                <th style="width: 10px;">Nilai</th>
                                <th>Progress</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th style="width: 10px;">ID</th>
                                <th >Unit</th>
                                <th style="width: 10px;">Nilai</th>
                                <th>ID</th>
                            </tr>
                        </tfoot>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Task Info -->
    <!-- Donut Chart -->
    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
        <div class="card">
            <div class="body">
                <div class="dashboard-donut-chart">
                    <canvas id="donut-desc-avg-unit"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
        <div class="card">
            <div class="body">
                <div class="dashboard-donut-chart">
                    <canvas id="donut-asc-avg-unit"></canvas></div>
            </div>
        </div>
    </div>
    <!-- #END# Donut Chart -->
</div>

<!-- Chart Js -->
<script src="<?= base_url('assets/adminbsb/plugins/chartjs/Chart.bundle.min.js'); ?>"></script>
<script type="text/javascript">
    $(document).ready(function () {
        glob_where_datatable = "";
        $(".btn-refersh").click(function () {
            table.ajax.reload();
        });

        var column_list = [
            {"data": "id",
                render: $.fn.dataTable.render.text()
            },
            {"data": "nama",
                render: function (data, type, row) {
                    var btn = '<a title="Lapoan Penilaian Mutu Pada Unit '+data+'"' +
                            ' href="<?=site_url('main/mutu_unit');?>/'+row.id+'">' +
                            data +
                            '</a>';
                    return btn;
                }
            },
            {"data": "hasil_all",
                render: $.fn.dataTable.render.text()
            },
            {"data": "hasil_all",
                render: function (data, type, row) {
                    var bg = 'bg-blue';
                    if (data >= 0 && data < 25) {
                        bg = 'bg-red';
                    } else if (data >= 25 && data < 50) {
                        bg = 'bg-yellow';
                    } else if (data >= 50 && data < 75) {
                        bg = 'bg-green';
                    } else if (data >= 75 && data < 100) {
                        bg = 'bg-blue';
                    }
                    var btn = '<div class="progress">' +
                            '<div class="progress-bar ' + bg + '" role="progressbar" aria-valuenow="' + data + '" aria-valuemin="0" aria-valuemax="100" style="width: ' + data + '%"></div>' +
                            '</div>';
                    return btn;
                }
            }
        ];

        var column_def = [
            {
                "orderable": true,
                "targets": 0,
                "width": "10px"
            }
        ];
        var orders = [[0, "asc"]];
        set_datatable('dataTable', "<?= site_url('main/json_dgview_avg_unit'); ?>", column_list, column_def, null, orders, null, null, null, null, null, null);
        get_data_table();
        get_unit_mutu_avg_desc();
        get_unit_mutu_avg_asc();
        function get_data_table() {
            glob_where_datatable = [
                {"name": "unit_id", "value": $("#unit_id").val()}
            ];
            table.ajax.reload();
        }
    });

    function get_unit_mutu_avg_desc() {
        $.ajax({
            type: "GET",
            url: "<?= site_url('main/get_unit_mutu_avg'); ?>",
            data: {"order": 'desc'},
            beforeSend: function () {
                
            },
            success: function (resp) {
                if (resp) {
                    var obj = jQuery.parseJSON(resp);
                    var PDataNilai = [];
                    var PLabel = [];
                    $.each(obj, function (key, data) {
                        PDataNilai.push(data.hasil_all);
                        PLabel.push(data.nama);
                    });
                    var chartOpt = {
                        //Boolean - Whether we should show a stroke on each segment
                        segmentShowStroke: true,
                        //String - The colour of each segment stroke
                        segmentStrokeColor: '#fff',
                        //Number - The width of each segment stroke
                        segmentStrokeWidth: 1,
                        //Number - The percentage of the chart that we cut out of the middle
                        percentageInnerCutout: 0, // This is 0 for Pie charts
                        //Number - Amount of animation steps
                        animationSteps: 100,
                        //String - Animation easing effect
                        animationEasing: 'easeOutBounce',
                        //Boolean - Whether we animate the rotation of the Doughnut
                        animateRotate: true,
                        //Boolean - Whether we animate scaling the Doughnut from the centre
                        animateScale: false,
                        //Boolean - whether to make the chart responsive to window resizing
                        responsive: true,
                        // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                        maintainAspectRatio: false,
                        //String - A legend template
                        legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
                        legend: {
                            display: true,
                            position: 'right',
                            fontSize: 24,
                            boxWidth: 100
                        },
                        title: {
                            display: true,
                            text: '10 TERTINGGI RATA-RATA PENILAIAN MUTU PER UNIT'
                        },
                        chartArea: {
                            backgroundColor: 'rgba(255, 255, 255, 1)'
                        }
                    };

                    var config = {
                        type: 'pie',
                        data: {
                            datasets: [{
                                    data: PDataNilai,
                                    backgroundColor: window.chartArrayColors,
                                }],
                            labels: PLabel
                        },
                        options: chartOpt
                    };
                    var my_chart = $('#donut-desc-avg-unit').get(0).getContext('2d');
                    if (typeof chart_donut_unit_desc != 'undefined') {
                        chart_donut_unit_desc.destroy();
                    }
                    chart_donut_unit_desc = new Chart(my_chart, config);
                }
            },
            error: function (event, textStatus, errorThrown) {
                console.log("Error !", 'Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown, "error");
            }
        });
    }

    function get_unit_mutu_avg_asc() {
        $.ajax({
            type: "GET",
            url: "<?= site_url('main/get_unit_mutu_avg'); ?>",
            data: {"order": 'asc'},
            beforeSend: function () {
                
            },
            success: function (resp) {
                if (resp) {
                    var obj = jQuery.parseJSON(resp);
                    var PDataNilai = [];
                    var PLabel = [];
                    $.each(obj, function (key, data) {
                        PDataNilai.push(data.hasil_all);
                        PLabel.push(data.nama);
                    });
                    var chartOpt = {
                        //Boolean - Whether we should show a stroke on each segment
                        segmentShowStroke: true,
                        //String - The colour of each segment stroke
                        segmentStrokeColor: '#fff',
                        //Number - The width of each segment stroke
                        segmentStrokeWidth: 1,
                        //Number - The percentage of the chart that we cut out of the middle
                        percentageInnerCutout: 0, // This is 0 for Pie charts
                        //Number - Amount of animation steps
                        animationSteps: 100,
                        //String - Animation easing effect
                        animationEasing: 'easeOutBounce',
                        //Boolean - Whether we animate the rotation of the Doughnut
                        animateRotate: true,
                        //Boolean - Whether we animate scaling the Doughnut from the centre
                        animateScale: false,
                        //Boolean - whether to make the chart responsive to window resizing
                        responsive: true,
                        // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                        maintainAspectRatio: false,
                        //String - A legend template
                        legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
                        legend: {
                            display: true,
                            position: 'right',
                            fontSize: 9,
                            boxWidth: 15
                        },
                        title: {
                            display: true,
                            text: '10 TERENDAH RATA-RATA PENILAIAN MUTU PER UNIT'
                        },
                        chartArea: {
                            backgroundColor: 'rgba(255, 255, 255, 1)'
                        }
                    };

                    var config = {
                        type: 'pie',
                        data: {
                            datasets: [{
                                    data: PDataNilai,
                                    backgroundColor: window.chartArrayColors,
                                }],
                            labels: PLabel
                        },
                        options: chartOpt
                    };
                    var my_chart = $('#donut-asc-avg-unit').get(0).getContext('2d');
                    if (typeof chart_donut_unit != 'undefined') {
                        chart_donut_unit.destroy();
                    }
                    chart_donut_unit = new Chart(my_chart, config);
                }
            },
            error: function (event, textStatus, errorThrown) {
                console.log("Error !", 'Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown, "error");
            }
        });
    }
</script>