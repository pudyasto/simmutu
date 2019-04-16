<?php
/*
 * ***************************************************************
 * Script : 
 * Version : 
 * Date :
 * Author : Pudyasto Adi W.
 * Email : mr.pudyasto@gmail.com
 * Keterangan : 
 * ***************************************************************
 */
?>
<div class="container-fluid">
    <input type="hidden" id="group_id" name="group_id" value="<?php echo $group_id; ?>">
    <button type="button" class="btn btn-default m-btn--pill btn-sm btn-sm" data-dismiss="modal" aria-label="Close">
        Tutup
    </button> 
    <button type="button" class="btn btn-info btn-refersh m-btn--pill btn-sm btn-sm">
        Refresh
    </button>  
    <hr> 
</div>
<div class="table-responsive">
    <table class="table table-bordered table-hover table-sm table-group-access" style="width: 100%;">
        <thead>
            <tr>
                <th style="min-width: 100px;width: 100px;text-align: center;">Set Akses</th>
                <th style="min-width: 200px;width: 200px;text-align: center;">Main Menu</th>
                <th style="text-align: center;">Sub Menu</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Aksi</th>
                <th>Main Menu</th>
                <th>Sub Menu</th>
            </tr>
        </tfoot>
        <tbody></tbody>
    </table> 
</div>

<script type="text/javascript">
    var tgroup;

    $(document).ready(function () {
        $(".btn-refersh").click(function () {
            tgroup.ajax.reload();
        });

        var column_list = [
            {"data": "set_access",
                render: function (data, type, row) {
                    if (data) {
                        var btn = '<center>' +
                                '<button class="btn btn-success btn-sm btn-akses"' +
                                ' type="button"' +
                                ' onclick="set_submenu(\'' + row.id + '\')">' +
                                ' <i class="material-icons">check_box</i>' +
                                '</button>' +
                                '</center>';
                    } else {
                        var btn = '<center>' +
                                '<button class="btn btn-default btn-sm btn-akses"' +
                                ' type="button"' +
                                ' onclick="set_submenu(\'' + row.id + '\')">' +
                                ' <i class="material-icons">check_box_outline_blank</i>' +
                                '</button>' +
                                '</center>';
                    }
                    return btn;
                }
            },
            {"data": "menu_name",
                render: $.fn.dataTable.render.text()
            },
            {"data": "submenu",
                render: $.fn.dataTable.render.text()
            }
        ];

        var column_def = [
            {
                "orderable": false,
                "targets": 0
            }
        ];

        var data_push = [
            {"name": "group_id", "value": $("#group_id").val()}
        ];

        tgroup = $('.table-group-access').DataTable({
            "bProcessing": true,
            "responsive": !0,
            "bServerSide": true,
            "columns": column_list,
            "columnDefs": column_def,
            "ordering": false,
            "lengthMenu": [[25, -1], [25, "All"]],
            "pagingType": "full_numbers",
            "fnServerParams": function (aoData) {
                aoData.push({"name": $('meta[name=csrf]').attr("id")
                    , "value": $('meta[name=csrf]').attr("content")});
            },
            "fnServerData": function (sSource, aoData, fnCallback) {
                if (data_push) {
                    for (i = 0; i < data_push.length; i++) {
                        aoData.push(data_push[i]);
                    }
                }
                $.ajax({
                    "dataType": 'json',
                    "type": "POST",
                    "url": sSource,
                    "data": aoData,
                    "success": function (resp) {
                        update_csrf(resp);
                        //$('meta[name=csrf]').attr("content",resp.csrf_return);
                        fnCallback(resp);
                    },
                    "error": function (event, textStatus, errorThrown) {
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
            "sAjaxSource": "<?= site_url('groups/json_group_access'); ?>",
            buttons: [
                {
                    extend: 'copy',
                    exportOptions: {orthogonal: 'export'},
                    className: 'btn btn-default btn-sm m-btn m-btn m-btn--icon m-btn--pill btn-sm'
                },
                {
                    extend: 'excel',
                    exportOptions: {orthogonal: 'export'},
                    className: 'btn btn-success btn-sm m-btn m-btn m-btn--icon m-btn--pill btn-sm bg-success'
                }
            ],
            "sDom": "<'row'<'col-sm-6'B><'col-sm-6 text-right' l> r> t <'row'<'col-sm-6'i><'col-sm-6 text-right'p>> ",
            "oLanguage": {
                "sLengthMenu": "_MENU_",
                "sZeroRecords": "Maaf, data yang anda cari tidak ditemukan",
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


        $('.table-group-access tfoot th').each(function () {
            var title = $('.table-group-access  tfoot th').eq($(this).index()).text();
            if (title !== "Aksi" && title !== "ID") {
                $(this).html('<input type="text" class="form-control form-datatable" style="width:100%;border-radius: 0px;" placeholder="Cari ' + title + '" />');
            } else {
                $(this).html('');
            }
        });

        tgroup.columns().every(function () {
            var that = this;
            $('input', this.footer()).on('keyup change', function (ev) {
                //if (ev.keyCode == 13) { //only on enter keypress (code 13)
                that
                        .search(this.value)
                        .draw();
                //}
            });
        });

        tgroup.on("change", ".m-group-checkable", function () {
            var e = $(this).closest("table").find("td:first-child .m-checkable"), a = $(this).is(":checked");
            $(e).each(function () {
                a ? ($(this).prop("checked", !0), $(this).closest("tr").addClass("active")) : ($(this).prop("checked", !1), $(this).closest("tr").removeClass("active"));
            });
        });
        
        $(".dt-buttons").removeClass("btn-group");
        $(".dt-buttons").css("margin-top","10px");
        $(".dt-buttons").css("text-align","left");
    });

    function refresh() {
        tgroup.ajax.reload();
    }

    function set_submenu(menu_id) {
        var group_id = $("#group_id").val();
        var submit = "<?= site_url('groups/submit_group_access'); ?>";
        $.ajax({
            type: "POST",
            url: submit,
            data: {"group_id": group_id, "menu_id": menu_id
                , "privilege": "1,1,1", "stat": "submenu"
                , "<?= $this->security->get_csrf_token_name(); ?>": $('meta[name=csrf]').attr("content")},
            success: function (resp) {
                var obj = jQuery.parseJSON(resp);
                update_csrf(obj);
                if (obj.state !== "1") {
                    swal({
                        title: obj.title,
                        html: obj.msg,
                        type: "error"
                    }).then((result) => {
                        if (result.value) {

                        }
                    });
                }
                tgroup.ajax.reload(null, false);
            }
        });

    }

    function set_access(menu_id) {
        var group_id = $("#group_id").val();
        var submit = "<?= site_url('groups/submit_group_access'); ?>";
        var T = "";
        var E = "";
        var H = "";
        var privilege = "0,0,0";
        if ($("#T" + menu_id).prop("checked")) {
            T = "1";
        } else {
            T = "0";
        }
        if ($("#E" + menu_id).is(":checked")) {
            E = "1";
        } else {
            E = "0";
        }
        if ($("#H" + menu_id).is(":checked")) {
            H = "1";
        } else {
            H = "0";
        }
        privilege = T + "," + E + "," + H;
        $.ajax({
            type: "POST",
            url: submit,
            data: {"group_id": group_id, "menu_id": menu_id
                , "privilege": privilege, "stat": "access"
                , "<?= $this->security->get_csrf_token_name(); ?>": $('meta[name=csrf]').attr("content")},
            success: function (resp) {
                var obj = jQuery.parseJSON(resp);
                update_csrf(obj);
                if (obj.state !== "1") {
                    swal({
                        title: obj.title,
                        html: obj.msg,
                        type: "error"
                    }).then((result) => {
                        if (result.value) {

                        }
                    });
                }
                tgroup.ajax.reload(null, false);
            }
        });
    }
</script>