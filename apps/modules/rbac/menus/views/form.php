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
    <div class="col-sm-12">
        <?=form_label($form['menu_name']['placeholder'], '', array('class' => '',));?>
        <div class="input-group">
            <div class="form-line">
                <?=form_input($form['menu_name']);?>
            </div>
        </div>
        <?php
            echo form_error('menu_name', '<div class="note">', '</div>');
            echo '<div class="checkbox">';
            echo form_checkbox($form['chkmainmenu']);
            echo '<label for="chkmainmenu">Menu Utama <small>( Centang jika ini adalah menu utama )</small></label>';
            echo '</div>';
        ?>
    </div>
    <div class="col-sm-12 form-mainmenu" style="z-index: 500;">
        <?=form_label('Parent Menu', '', array('class' => '',));?>
        <div class="input-group">
            <div class="form-line">
                <?=form_dropdown($form['mainmenuid']['name']
                    , $form['mainmenuid']['data']
                    , $form['mainmenuid']['value']
                    , $form['mainmenuid']['attr']);
                ?>
            </div>
        </div>
        <?=form_error('mainmenuid', '<div class="note">', '</div>');?>
    </div>
    <div class="col-sm-12">
        <?=form_label($form['link']['placeholder'], '', array('class' => '',));?>
        <div class="input-group">
            <div class="form-line">
                <?=form_input($form['link']);?>
            </div>
        </div>
        <?=form_error('link', '<div class="note">', '</div>');?>
    </div>
    <div class="col-sm-12">
        <?=form_label($form['icon']['placeholder'], '', array('class' => '',));?>
        <div class="input-group">
            <div class="form-line">
                <?=form_input($form['icon']);?>
            </div>
            <span class="input-group-addon">
                <button type="button" class="btn btn-primary btn-icon">Pilih Icon</button>
            </span>
        </div>
        <?=form_error('icon', '<div class="note">', '</div>');?>
    </div>
    <div class="col-sm-12">
        <div class="list-icon" style="display: none;">
            <?php
            echo '<div style="height: 250px; overflow-y: auto;">';
            echo $material;
            echo '</div>';
            echo form_error('icon', '<div class="note">', '</div>');
            ?>
        </div>
    </div>
    <div class="col-sm-12">
        <?=form_label($form['description']['placeholder'], '', array('class' => '',));?>
        <div class="input-group">
            <div class="form-line">
                <?=form_textarea($form['description']);?>
            </div>
        </div>
        <?=form_error('description', '<div class="note">', '</div>');?>
    </div>
    <div class="col-sm-12">
        <?=form_label('Status Menu', '', array('class' => '',));?>
        <div class="input-group">
            <div class="form-line">
                <?=form_dropdown($form['statmenu']['name']
                                , $form['statmenu']['data']
                                , $form['statmenu']['value']
                                , $form['statmenu']['attr']);?>
            </div>
        </div>
        <?=form_error('statmenu', '<div class="note">', '</div>');?>
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
<?php echo form_close(); ?>
<script type="text/javascript">
    $(document).ready(function () {
        show_main_menu();
        $("#chkmainmenu").click(function () {
            show_main_menu();
        });

        $(".btn-icon").click(function () {
            if (!$('.list-icon').is(':visible')) {
                $(".list-icon").show("slow");
            } else {
                $(".list-icon").hide("slow");
            }
        });

        $(".material-icons").click(function () {
            var icon = $(this).html();
            $("#icon").val(icon);
//            $(".list-icon").hide();
        });

        $(".icon-name").click(function () {
            var icon = $(this).html();
            $("#icon").val(icon);
//            $(".list-icon").hide();
        });

        $("#form_add").on("submit", function (event) {
            event.preventDefault();
            var input = $(this).serialize();
            var submit = "<?php echo $submit; ?>";
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
                                location.reload();
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

    function show_main_menu() {
        var link = "<?php echo $form['link']['value']; ?>";
        var mainmenuid = "<?php echo$form['mainmenuid']['value']; ?>";
        if ($("#chkmainmenu").prop("checked") === true) {
            $("#mainmenuid").attr('required', false);
            $(".form-mainmenu").hide();
            if (!link) {
                link = "#";
            }
            $("#link").attr('required', false)
                    .val(link);
        } else {
            $("#mainmenuid").attr('required', true);
            $("#mainmenuid").val(mainmenuid);
            $(".form-mainmenu").show();
            $('#link').attr('required', true)
                    .val(link);
        }
    }
</script>