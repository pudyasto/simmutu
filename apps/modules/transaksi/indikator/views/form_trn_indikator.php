<?php
/*
 * ***************************************************************
 * Script : 
 * Version : 
 * Date :
 * Author : Pudyasto Adi W.
 * Email : mr.pudyasto@gmail.com
 * Description : 
 * ***************************************************************
 */
?>
<div class="row clearfix">
    <?php
    $attributes = array(
        'role' => 'form'
        , 'id' => 'form_add'
        , 'class' => 'form-horizontal'
        , 'name' => 'form_add');
    echo form_open(site_url('indikator/submit_trn_indikator'), $attributes);
    echo form_input($form['indikator_id']);
    ?> 
    <div class="col-md-5">
        <div class="row clearfix">
            <div class="col-sm-12">
                <h4>Unit : <?= $detail->nm_unit; ?></h4>
                <table class="table table-hover">
                    <tr>
                        <td style="width: 135px;"> Jenis Indikator</td>
                        <td>: <?= $detail->nm_jenis; ?></td>
                        <td style="width: 150px;">Penanggung Jawab</td>
                        <td style="width: 220px;">: <?= $detail->nama_pj; ?></td>
                    </tr>
                    <tr>
                        <td>Indikator</td>
                        <td colspan="3">: <?= $detail->nama; ?></td>
                    </tr>
                    <tr>
                        <td>Standar</td>
                        <td colspan="3">: <?= $detail->standar; ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-12">
                <?= form_label($form['tgl_tran']['placeholder'], '', array('class' => '',)); ?>
                <div class="input-group">
                    <div class="form-line">
                        <?= form_input($form['tgl_tran']); ?>
                    </div>
                </div>
                <?= form_error('tgl_tran', '<div class="note">', '</div>'); ?>
            </div>
            <div class="col-sm-12">
                <?= form_label($form['keterangan']['placeholder'], '', array('class' => '',)); ?>
                <div class="input-group">
                    <div class="form-line">
                        <?= form_textarea($form['keterangan']); ?>
                    </div>
                </div>
                <?= form_error('keterangan', '<div class="note">', '</div>'); ?>
            </div>
            <div class="col-sm-6">
                <?= form_label($form['num']['placeholder'], '', array('class' => '',)); ?>
                <small><?= $detail->num; ?></small>
                <div class="input-group">
                    <div class="form-line">
                        <?= form_input($form['num']); ?>
                    </div>
                </div>
                <?= form_error('num', '<div class="note">', '</div>'); ?>
            </div>
            <div class="col-sm-6">
                <?= form_label($form['denum']['placeholder'], '', array('class' => '',)); ?>
                <small><?= $detail->denum; ?></small>
                <div class="input-group">
                    <div class="form-line">
                        <?= form_input($form['denum']); ?>
                    </div>
                </div>
                <?= form_error('denum', '<div class="note">', '</div>'); ?>
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" aria-label="Close">
                    Batal
                </button>
                <button type="submit" class="btn btn-primary btn-sm">
                    Simpan
                </button>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
    <div class="col-md-7">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <?= form_label($form['periode']['placeholder'], '', array('class' => '',)); ?>
                    <div class="input-group">
                        <div class="form-line">
                            <?= form_input($form['periode']); ?>
                        </div>
                    </div>
                    <?= form_error('periode', '<div class="note">', '</div>'); ?>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-bordered tableTrnIndikator" style="width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 100px;text-align: center;">Tgl Penilaian</th>
                        <th style="text-align: center;">Keterangan</th>
                        <th style="width: 80px;text-align: center;">Numerator</th>
                        <th style="width: 80px;text-align: center;">Denumerator</th>
                        <th style="width: 80px;text-align: center;">Hasil</th>
                        <th style="width: 80px;text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <div class="col-md-12">
        <div style="height: 350px">
            <canvas id="bar-penilaian-unit"></canvas>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" aria-label="Close">
        Batal
    </button>
</div>

<!-- Chart Js -->
<script src="<?= base_url('assets/adminbsb/plugins/chartjs/Chart.bundle.min.js'); ?>"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var column_list_trn_indikator = [
            {
                "data": "tgl_tran",
                render: function (data, type, row) {
                    return type === 'export' ? data : tgl_id_short(data);
                }
            },
            {
                "data": "keterangan",
                render: $.fn.dataTable.render.text()
            },
            {
                "data": "num"
            },
            {
                "data": "denum"
            },
            {
                "data": "hasil",
                render: function (data, type, row) {
                    return type === 'export' ? Number(data) * 100 : numeral(Number(data) * 100).format('0,0.00');
                }
            },
            {"data": "tgl_tran",
                render: function (data, type, row) {
                    var btn = '<center>' +
                            '<a class="btn bg-cyan btn-xs waves-effect"' +
                            ' onclick="edit_nilai(\'' + row.tgl_id + '\',\'' + row.keterangan + '\',\'' + row.num + '\',\'' + row.denum + '\');"' +
                            ' href="javascript:void(0);">' +
                            '<i class="material-icons">mode_edit</i>' +
                            '</a>' +
                            '<a class="btn bg-red btn-xs waves-effect"' +
                            ' onclick="delete_nilai(\'' + row.tgl_id + '\');"' +
                            ' href="javascript:void(0);">' +
                            '<i class="material-icons">delete</i>' +
                            '</a>' +
                            '</center>';
                    return btn;
                }
            }
        ];
        var column_def_trn_indikator  = [
            {
                "orderable": true,
                "targets": 0
            }
        ];
        
        table_trn_indikator = $('.tableTrnIndikator').DataTable({
            "bProcessing": true,
            "bServerSide": true,
            "lengthMenu": [[5, 10, 20, 50, 100 ,-1], [5, 10, 20, 50, 100, "All"]],
            "columnDefs": column_def_trn_indikator ,
            "columns": column_list_trn_indikator ,
            "order": [[0, "desc"]],
            "fnServerParams": function (aoData) {
                aoData.push({"name": $('meta[name=csrf]').attr("id")
                    , "value": $('meta[name=csrf]').attr("content")});
                aoData.push({"name": 'indikator_id'
                    , "value": $('#indikator_id').val()});
                aoData.push({"name": 'periode'
                    , "value": $('#periode').val()});
            },
            "fnServerData": function (sSource, aoData, fnCallback) {
                $.ajax({
                    "dataType": 'json',
                    "type": "POST",
                    "url": sSource,
                    "data": aoData,
                    "beforeSend": function () {
                        $(".btn").addClass('disabled');
                    },
                    "success": function (resp) {
                        $(".btn").removeClass('disabled');
                        update_csrf(resp);
                        fnCallback(resp);
                    },
                    "error": function (event, textStatus, errorThrown) {
                        $(".btn").removeClass('disabled');
                        swal({
                            title: "Kesalahan!",
                            html: 'Pesan: Tidak dapat menerima token, halaman akan di reload',
                            type: "info"
                        }).then((result) => {
                            if (result.value) {
                                location.reload();
                            }
                        });
                    }
                });
            },
            "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                if (aData.debet !== aData.kredit)
                {
                    $('td', nRow).css('background-color', '#f4516c');
                    $('td', nRow).css('font-weight', 'bold');
                }
            },
            "buttons": [
                {
                    text: 'Refresh', 
                    className: 'btn btn-sm btn-default',
                    action: function ( e, dt, node, config ) {
                        table_trn_indikator.ajax.reload();
                    }
                }
            ],
            "sAjaxSource": "<?= site_url('indikator/json_dgview_trn_indikator'); ?>",
            "sDom": "<'row'<'col-sm-6' B><'col-sm-4 text-right' f><'col-sm-2 text-right' l> r> t <'row'<'col-sm-6' i><'col-sm-6 text-right' p>> ",
            "oLanguage": {
                "sLengthMenu": "_MENU_",
                "sZeroRecords": "Data Tidak Ada",
                "sProcessing": "<i class=\"m-loader m-loader--brand\"></i> <span style=\"padding-left: 15px;\">Silahkan Tunggu</span>",
                "sInfo": "_START_ - _END_ / _TOTAL_",
                "sInfoEmpty": "0 - 0 / 0",
                "infoFiltered": "(_MAX_)",
                "oPaginate": {
                    "sFirst": "<i class='material-icons'>first_page</i>",
                    "sPrevious": "<i class='material-icons'>chevron_left</i>",
                    "sNext": "<i class='material-icons'>chevron_right</i>",
                    "sLast": "<i class='material-icons'>last_page</i>"
                }
            }
        });
        
        $(".btn-refresh").click(function(){
            table_trn_indikator.ajax.reload();
        });

        $('#periode').on("changeDate", function (e) {
            table_trn_indikator.ajax.reload();
            get_chart_nilai_unit();
        });
        
        $("#form_add").on("submit", function (event) {
            event.preventDefault();
            var input = $(this).serialize();
            var submit = $(this).attr('action');
            $.ajax({
                type: "POST",
                url: submit,
                data: input,
                success: function (resp) {
                    var obj = jQuery.parseJSON(resp);
                    update_csrf(obj);
                    if (obj.state === "1") {
                        swal({
                            title: obj.title,
                            html: obj.msg,
                            type: "success"
                        }).then((result) => {
                            if (result.value) {
                                table_trn_indikator.ajax.reload();
                                get_chart_nilai_unit();
                                $("#tgl_tran").val('');
                                $("#keterangan").val('');
                                $("#num").val('');
                                $("#denum").val('');
                            }
                        });
                    } else {
                        swal({
                            title: obj.title,
                            html: obj.msg,
                            type: "error"
                        }).then((result) => {
                            if (result.value) {

                            }
                        });
                    }
                },
                error: function (event, textStatus, errorThrown) {
                    swal({
                        title: "Kesalahan!",
                        html: 'Pesan: ' + textStatus + ' , HTTP: ' + errorThrown,
                        type: "error"
                    }).then((result) => {
                        if (result.value) {
                            //location.reload();
                        }
                    });
                }
            });
        });
        
        get_chart_nilai_unit();
    });
    
    function get_chart_nilai_unit() {
        var indikator_id = $('#indikator_id').val();
        var periode = $('#periode').val();
        $.ajax({
            type: "GET",
            url: "<?= site_url('indikator/get_chart_nilai_unit'); ?>",
            data: {
                "indikator_id": indikator_id
                ,"periode": periode
            },
            beforeSend: function () {
                
            },
            success: function (resp) {
                if (resp) {
                    var obj = jQuery.parseJSON(resp);
                    var PDataNilai = [];
                    var PLabel = [];
                    $.each(obj, function (key, data) {
                        PDataNilai.push(data.hasil * 100);
                        PLabel.push(data.hari);
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
                            position: 'bottom',
                            fontSize: 9,
                            boxWidth: 20
                        },
                        scales: {
                            xAxes: [{
                                    stacked: true
                                }],
                            yAxes: [{
                                    stacked: true,
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
                                    return "Tanggal " + data['labels'][tooltipItem[0]['index']];
                                },
                                label: function (tooltipItem, data) {
                                    return numeral(tooltipItem.yLabel).format('0,0') + "%";
                                }
                            },
                            titleFontSize: 16,
                            titleFontColor: '#fff',
                            bodyFontColor: '#fff',
                            bodyFontSize: 14,
                            displayColors: true
                        },
                        title: {
                            display: true,
                            text: 'Grafik Penilaian Unit '
                        },
                        chartArea: {
                            backgroundColor: 'rgba(255, 255, 255, 1)'
                        }
                    };

                    var config = {
                        type: 'line',
                        data: {
                            datasets: [
                                {
                                    type: 'line',
                                    data: PDataNilai,
                                    backgroundColor: 'rgb(244, 67, 54)',
                                    borderColor: 'rgb(76, 175, 80)',
                                    fill: false,
                                    lineTension: 0.1,
                                    label: 'Nilai Unit Per Hari'
                                }
                            ],

                            labels: PLabel
                        },
                        options: chartOpt
                    };
                    var my_chart = $('#bar-penilaian-unit').get(0).getContext('2d');
                    if (typeof chart_penilaian_unit != 'undefined') {
                        chart_penilaian_unit.destroy();
                    }
                    chart_penilaian_unit = new Chart(my_chart, config);
                }
            },
            error: function (event, textStatus, errorThrown) {
                console.log("Error !", 'Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown, "error");
            }
        });
    }
    
    function edit_nilai(tgl_tran,keterangan,num,denum){
        $("#tgl_tran").val(tgl_tran);
        $("#keterangan").val(keterangan);
        $("#num").val(num);
        $("#denum").val(denum);
    }
    
    function delete_nilai(tgl_tran){
        var indikator_id = $('#indikator_id').val();
        swal({
            title: "Konfirmasi Hapus",
            text: "Data yang dihapus, tidak dapat dikembalikan!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#c9302c",
            confirmButtonText: "Ya, Lanjutkan",
            cancelButtonText: "Tidak, Batalkan"
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?=site_url('indikator/submit_trn_indikator'); ?>",
                    data: {"indikator_id": indikator_id
                        , "tgl_tran": tgl_tran
                        , "state": "delete"
                        , "<?= $this->security->get_csrf_token_name(); ?>": $('meta[name=csrf]').attr("content")
                    },
                    success: function (resp) {
                        var obj = jQuery.parseJSON(resp);
                        update_csrf(obj);
                        if (obj.state === "1") {
                            table_trn_indikator.ajax.reload();
                            get_chart_nilai_unit();
                        } else {
                            swal({
                                title: obj.title,
                                html: obj.msg,
                                type: "error"
                            }).then((result) => {
                                if (result.value) {

                                }
                            });
                        }
                    },
                    error: function (event, textStatus, errorThrown) {
                        swal({
                            title: "Kesalahan!",
                            html: 'Pesan: ' + textStatus + ' , HTTP: ' + errorThrown,
                            type: "error"
                        }).then((result) => {
                            if (result.value) {
                                //location.reload();
                            }
                        });
                    }
                });
            }
        });
    }
</script>