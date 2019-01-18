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
?> 
<div class="row clearfix">
    <div class="col-sm-12">
        <?=form_input($form['id']);?>
        <?=form_label($form['nama']['placeholder'], '', array('class' => '',));?>
        <div class="input-group">
            <div class="form-line">
                <?=form_input($form['nama']);?>
            </div>
        </div>
        <?=form_error('nama', '<div class="note">', '</div>');?>
    </div>
    <div class="col-sm-12">
        <?=form_label($form['keterangan']['placeholder'], '', array('class' => '',));?>
        <div class="input-group">
            <div class="form-line">
                <?=form_textarea($form['keterangan']);?>
            </div>
        </div>
        <?=form_error('keterangan', '<div class="note">', '</div>');?>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" aria-label="Close">
        Batal
    </button>
    <button type="submit" class="btn btn-primary btn-sm">
        Simpan
    </button>
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