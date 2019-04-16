<div class="block-header">
    <h2>DASHBOARD MUTU PER UNIT</h2>
</div>
<!-- #END# Widgets -->
<div class="row clearfix">
    <!-- Task Info -->
    <div class="col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    <a class="btn btn-success btn-circle waves-effect waves-circle waves-float" href="<?= site_url('main'); ?>">
                        <i class="material-icons">arrow_back</i></a> 
                    PENILAIAN MUTU UNIT : <?= (isset($unit['nama'])) ? strtoupper($unit['nama']) : ""; ?>
                </h2>
            </div>
            <div class="body">
                <div class="row clearfix">
                    <div class="col-xs-3">
                        <?= form_label($form['periode']['placeholder'], '', array('class' => '',)); ?>
                        <div class="input-group">
                            <div class="form-line">
                                <?= form_input($form['periode']); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="height: 500px; display: none;">
                    <canvas id="bar-mutu-indikator"></canvas>
                </div>
                <hr>
                <div class="table-responsive table-mutu-per-unit">
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Task Info -->
</div>

<!-- Chart Js -->
<script src="<?= base_url('assets/adminbsb/plugins/chartjs/Chart.bundle.min.js'); ?>"></script>
<script type="text/javascript">
    $(document).ready(function () {
        get_mutu_per_unit();
        get_mutu_indikator();
        $('#periode').on("changeDate", function (e) {
            var unit_id = "<?=$this->uri->segment(3);?>";
            var periode = $(this).val();
            location.replace(base_url('main/mutu_unit/'+unit_id+'/'+periode));
        });
    });

    function get_mutu_per_unit() {
        var unit_id = "<?= $this->uri->segment(3); ?>";
        var periode = "<?= $this->uri->segment(4); ?>";
        $.ajax({
            type: "GET",
            url: "<?= site_url('main/get_mutu_per_unit'); ?>",
            data: {
                "unit_id": unit_id
                , "periode": periode
            },
            beforeSend: function () {
                $(".table-mutu-per-unit").html('');
            },
            success: function (resp) {
                if (resp) {
                    $(".table-mutu-per-unit").html(resp);
                    $(".table-nilai-indikator").DataTable({
                        "columnDefs": [{
                                "targets": 1,
                                "visible": false
                            }, {
                                "targets": 2,
                                "render": function (data, type, row, meta) {
                                    var btn = '<a class=""' +
                                            ' data-toggle="modal"' +
                                            ' data-title="Pengisian Numerator - Denumerator"' +
                                            ' data-post-id="' + row[1] + '"' +
                                            ' data-width="90%"' +
                                            ' data-action-url="indikator/form_trn_indikator"' +
                                            ' data-target="#form-modal"' +
                                            ' href="javascript:void(0);">' +
                                            data +
                                            '</a>';
                                    return btn;
                                }
                            }],
                        "paging": false,
                        buttons: [
                            {
                                extend: 'copy',
                                exportOptions: {orthogonal: 'export'},
                                className: 'btn btn-default btn-sm '
                            },
                            {
                                extend: 'excel',
                                exportOptions: {orthogonal: 'export'},
                                className: 'btn btn-success btn-sm bg-success'
                            }
                        ],
                        "sDom": "<'row'<'col-sm-6'B><'col-sm-6 text-right' f> r> t <'row'<'col-sm-6'><'col-sm-6 text-right'>> "
                    });
                }
            },
            error: function (event, textStatus, errorThrown) {
                console.log("Error !", 'Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown, "error");
            }
        });
    }

    function get_mutu_indikator() {
        var unit_id = "<?= $this->uri->segment(3); ?>";
        var periode = "<?= $this->uri->segment(4); ?>";
        $.ajax({
            type: "GET",
            url: "<?= site_url('main/get_mutu_indikator'); ?>",
            data: {
                "unit_id": unit_id
                , "periode": periode
            },
            beforeSend: function () {

            },
            success: function (resp) {
                var obj = jQuery.parseJSON(resp);
                update_csrf(obj);
                if (obj.jml_hari) {
                    var PLabel = [];
                    var JsonData = [];
                    var color_num = 0;
                    for (i = 1; i <= Number(obj.jml_hari); i++) {
                        PLabel.push(i);
                    }
                    $.each(obj.data_indkator, function (k_lokasi, v_lokasi) {
                        var PDataJual = [];
                        $.each(obj.data, function (key, data) {
                            $.each(data, function (sub_key, sub_data) {
                                if (k_lokasi === sub_key) {
                                    PDataJual.push(sub_data);
                                }
                            });
                        });
                        var xchart = {
                            type: 'line',
                            data: PDataJual,
                            borderColor: window.chartArrayColors[color_num],
                            backgroundColor: window.chartArrayColors[color_num],
                            fill: false,
                            lineTension: 0.5,
                            label: v_lokasi
                        };
                        JsonData.push(xchart);
                        color_num++;
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
                            boxWidth: 20
                        },
                        scales: {
                            xAxes: [{
                                    stacked: false
                                }],
                            yAxes: [{
                                    stacked: false,
                                    ticks: {
                                        callback: function (value, index, values) {
                                            return numeral(value).format('0,0');
                                        }
                                    }
                                }]
                        },
                        tooltips: {
                            callbacks: {
                                title: function (tooltipItem, data) {
                                    return "Tanggal : " + tooltipItem[0].xLabel;
                                },
                                label: function (tooltipItem, data) {
                                    return numeral(tooltipItem.yLabel).format('0,0') + "%";
                                },
                                footer: function (tooltipItem, data) {
                                    return data.datasets[tooltipItem[0].datasetIndex].label;
                                },
                            },
                            titleFontSize: 16,
                            titleFontColor: '#fff',
                            bodyFontColor: '#fff',
                            bodyFontSize: 14,
                            displayColors: true
                        },
                        title: {
                            display: true,
                            text: 'Grafik Penilaian Per Indikator'
                        },
                        chartArea: {
                            backgroundColor: 'rgba(255, 255, 255, 1)'
                        }
                    };

                    var config = {
                        type: 'bar',
                        data: {
                            datasets: JsonData,
                            labels: PLabel
                        },
                        options: chartOpt
                    };
                    var my_chart = $('#bar-mutu-indikator').get(0).getContext('2d');
                    if (typeof bar_mutu_indikator != 'undefined') {
                        bar_mutu_indikator.destroy();
                    }
                    bar_mutu_indikator = new Chart(my_chart, config);
                }
            },
            error: function (event, textStatus, errorThrown) {
                swal("Error !", 'Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown, "error");
            }
        });
    }
</script>