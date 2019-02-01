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

$attributes = array(
    'role' => 'form'
    , 'id' => 'form_add'
    , 'class' => 'form-horizontal'
    , 'name' => 'form_add');
echo form_open($submit, $attributes);
echo form_input($form['id']);
?> 
<div class="row clearfix">
    <div class="col-sm-6" style="z-index: 500">
        <?= form_label('Pilih Unit', '', array('class' => '',)); ?>
        <div class="input-group">
            <div class="form-line">
                <?=
                form_dropdown($form['unit_id']['name']
                        , $form['unit_id']['data']
                        , $form['unit_id']['value']
                        , $form['unit_id']['attr']);
                ?>
            </div>
        </div>
        <?= form_error('unit_id', '<div class="note">', '</div>'); ?>
    </div>
    <div class="col-sm-6" style="z-index: 499">
        <?= form_label('Jenis Indikator', '', array('class' => '',)); ?>
        <div class="input-group">
            <div class="form-line">
                <?=
                form_dropdown($form['jenis_id']['name']
                        , $form['jenis_id']['data']
                        , $form['jenis_id']['value']
                        , $form['jenis_id']['attr']);
                ?>
            </div>
        </div>
        <?= form_error('jenis_id', '<div class="note">', '</div>'); ?>
    </div>
    <div class="col-sm-12">
        <?=form_label($form['nama']['placeholder'], '', array('class' => '',));?>
        <div class="input-group">
            <div class="form-line">
                <?=form_input($form['nama']);?>
            </div>
        </div>
        <?=form_error('nama', '<div class="note">', '</div>');?>
    </div>
    <div class="col-sm-6">
        <?=form_label($form['tujuan']['placeholder'], '', array('class' => '',));?>
        <div class="input-group">
            <div class="form-line">
                <?=form_textarea($form['tujuan']);?>
            </div>
        </div>
        <?=form_error('tujuan', '<div class="note">', '</div>');?>
    </div>
    <div class="col-sm-6">
        <?=form_label($form['definisi']['placeholder'], '', array('class' => '',));?>
        <div class="input-group">
            <div class="form-line">
                <?=form_textarea($form['definisi']);?>
            </div>
        </div>
        <?=form_error('definisi', '<div class="note">', '</div>');?>
    </div>
    <div class="col-sm-6">
        <?=form_label($form['inklusi']['placeholder'], '', array('class' => '',));?>
        <div class="input-group">
            <div class="form-line">
                <?=form_textarea($form['inklusi']);?>
            </div>
        </div>
        <?=form_error('inklusi', '<div class="note">', '</div>');?>
    </div>
    <div class="col-sm-6">
        <?=form_label($form['eksklusi']['placeholder'], '', array('class' => '',));?>
        <div class="input-group">
            <div class="form-line">
                <?=form_textarea($form['eksklusi']);?>
            </div>
        </div>
        <?=form_error('eksklusi', '<div class="note">', '</div>');?>
    </div>
    <div class="col-sm-6">
        <?=form_label($form['num']['placeholder'], '', array('class' => '',));?>
        <div class="input-group">
            <div class="form-line">
                <?=form_textarea($form['num']);?>
            </div>
        </div>
        <?=form_error('num', '<div class="note">', '</div>');?>
    </div>
    <div class="col-sm-6">
        <?=form_label($form['denum']['placeholder'], '', array('class' => '',));?>
        <div class="input-group">
            <div class="form-line">
                <?=form_textarea($form['denum']);?>
            </div>
        </div>
        <?=form_error('denum', '<div class="note">', '</div>');?>
    </div>
    <div class="col-sm-6" style="z-index: 498">
        <?= form_label('Frekuensi', '', array('class' => '',)); ?>
        <div class="input-group">
            <div class="form-line">
                <?=
                form_dropdown($form['frekuensi']['name']
                        , $form['frekuensi']['data']
                        , $form['frekuensi']['value']
                        , $form['frekuensi']['attr']);
                ?>
            </div>
        </div>
        <?= form_error('frekuensi', '<div class="note">', '</div>'); ?>
    </div>
    <div class="col-sm-6">
        <?=form_label($form['periode_analisa']['placeholder'], '', array('class' => '',));?>
        <div class="input-group">
            <div class="form-line">
                <?=form_input($form['periode_analisa']);?>
            </div>
        </div>
        <?=form_error('periode_analisa', '<div class="note">', '</div>');?>
    </div>
    <div class="col-sm-6" style="z-index: 497">
        <?= form_label('Tipe Indikator', '', array('class' => '',)); ?>
        <div class="input-group">
            <div class="form-line">
                <?=
                form_dropdown($form['tipe_id']['name']
                        , $form['tipe_id']['data']
                        , $form['tipe_id']['value']
                        , $form['tipe_id']['attr']);
                ?>
            </div>
        </div>
        <?= form_error('tipe_id', '<div class="note">', '</div>'); ?>
    </div>
    <div class="col-sm-6">
        <?=form_label($form['sumber_data']['placeholder'], '', array('class' => '',));?>
        <div class="input-group">
            <div class="form-line">
                <?=form_input($form['sumber_data']);?>
            </div>
        </div>
        <?=form_error('sumber_data', '<div class="note">', '</div>');?>
    </div>
    <div class="col-sm-6">
        <?=form_label($form['nama_pj']['placeholder'], '', array('class' => '',));?>
        <div class="input-group">
            <div class="form-line">
                <?=form_input($form['nama_pj']);?>
            </div>
        </div>
        <?=form_error('nama_pj', '<div class="note">', '</div>');?>
    </div>
    <div class="col-sm-6">
        <?=form_label($form['standar']['placeholder'], '', array('class' => '',));?>
        <div class="input-group">
            <div class="form-line">
                <?=form_input($form['standar']);?>
            </div>
        </div>
        <?=form_error('standar', '<div class="note">', '</div>');?>
    </div>
    <div class="col-sm-6">
        <div class="input-group">
            <?= form_checkbox($form['stat']);?>
            <label for="<?=$form['stat']['id'];?>">
                <?=$form['stat']['placeholder'];?>
            </label>
        </div>
        <?=form_error('stat', '<div class="note">', '</div>');?>
    </div>
    
    <div class="col-sm-6 text-right">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" aria-label="Close">
            Batal
        </button>
        <button type="submit" class="btn btn-primary btn-sm">
            Simpan
        </button>    
    </div>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function () {
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
                                table.ajax.reload();
                                $('#form-modal').modal("hide");
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