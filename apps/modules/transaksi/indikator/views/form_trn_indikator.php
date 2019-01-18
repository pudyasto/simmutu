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
                        <td style="width: 135px;">Tanggal Penilaian</td>
                        <td style="width: 220px;">: <?= datetime_id(date('Y-m-d H:i:s')); ?></td>
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
        <div class="table-responsive">
            <table class="table table-hover table-bordered tableTrnIndikator" style="width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 250px;text-align: center;">Tgl Penilaian</th>
                        <th style="text-align: center;">Keterangan</th>
                        <th style="width: 80px;text-align: center;">Numerator</th>
                        <th style="width: 80px;text-align: center;">Denumerator</th>
                        <th style="width: 80px;text-align: center;">Hasil</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" aria-label="Close">
        Batal
    </button>
</div>

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
            "lengthMenu": [[50, 100 ,-1], [50, 100, "All"]],
            "columnDefs": column_def_trn_indikator ,
            "columns": column_list_trn_indikator ,
            "order": [[0, "desc"]],
            "fnServerParams": function (aoData) {
                aoData.push({"name": $('meta[name=csrf]').attr("id")
                    , "value": $('meta[name=csrf]').attr("content")});
                aoData.push({"name": 'indikator_id'
                    , "value": $('#indikator_id').val()});
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
                    "sPrevious": "<i class='fa fa-angle-double-left'></i>",
                    "sNext": "<i class='fa fa-angle-double-right'></i>"
                }
            }
        });
        
        $(".btn-refresh").click(function(){
            table_trn_indikator.ajax.reload();
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
    });
</script>