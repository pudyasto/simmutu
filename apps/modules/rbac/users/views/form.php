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
        <?=form_label($form['full_name']['placeholder'], '', array('class' => '',));?>
        <div class="input-group">
            <div class="form-line">
                <?=form_input($form['full_name']);?>
            </div>
        </div>
        <?=form_error('full_name', '<div class="note">', '</div>');?>
    </div>
    
    <div class="col-sm-12">
        <?=form_label($form['username']['placeholder'], '', array('class' => '',));?>
        <div class="input-group">
            <div class="form-line">
                <?=form_input($form['username']);?>
            </div>
        </div>
        <?=form_error('username', '<div class="note">', '</div>');?>
    </div>
    
    <div class="col-sm-12">
        <?=form_label($form['email']['placeholder'], '', array('class' => '',));?>
        <div class="input-group">
            <div class="form-line">
                <?=form_input($form['email']);?>
            </div>
        </div>
        <?=form_error('email', '<div class="note">', '</div>');?>
    </div>
    
    <div class="col-sm-12">
        <?=form_label($form['password']['placeholder'], '', array('class' => '',));?>
        <div class="input-group">
            <div class="form-line">
                <?=form_input($form['password']);?>
            </div>
        </div>
        <?=form_error('password', '<div class="note">', '</div>');?>
    </div>
    
    <div class="col-sm-12">
        <?=form_label($form['password_confirm']['placeholder'], '', array('class' => '',));?>
        <div class="input-group">
            <div class="form-line">
                <?=form_input($form['password_confirm']);?>
            </div>
        </div>
        <?=form_error('password_confirm', '<div class="note">', '</div>');?>
    </div>
    
    <div class="col-sm-12" style="z-index: 401;">
        <?=form_label('Pilih Unit Pelayanan', '', array('class' => '',));?>
        <div class="input-group">
            <div class="form-line">
                <?=form_dropdown($form['unit_id']['name'], $form['unit_id']['data'], $form['unit_id']['value'], $form['unit_id']['attr']);?>
            </div>
        </div>
        <?=form_error('unit_id', '<div class="note">', '</div>');?>
    </div>
    
    <div class="col-sm-12" style="z-index: 400;">
        <?=form_label('Pilih Grup Pengguna', '', array('class' => '',));?>
        <div class="input-group">
            <div class="form-line">
                <?=form_dropdown($form['group_id']['name'], $form['group_id']['data'], $form['group_id']['value'], $form['group_id']['attr']);?>
            </div>
        </div>
        <?=form_error('group_id', '<div class="note">', '</div>');?>
    </div>
    
    <div class="col-sm-12">
        <?=form_label('Pilih Status Aktif', '', array('class' => '',));?>
        <div class="input-group">
            <div class="form-line">
                <?=form_dropdown($form['active']['name'], $form['active']['data'], $form['active']['value'], $form['active']['attr']);?>
            </div>
        </div>
        <?=form_error('active', '<div class="note">', '</div>');?>
    </div>
    
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal" aria-label="Close">
        Batal
    </button>
    <button type="submit" class="btn btn-sm btn-primary">
        Simpan
    </button>
</div>
<?php echo form_close();?>

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