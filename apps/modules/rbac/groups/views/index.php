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
<div class="block-header">
    <h2>
        {msg_main}<small>{msg_detail}</small>
    </h2>
</div>
<!-- Basic Examples -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Daftar {msg_main}
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li class="">
                                <a class="" href="#" data-toggle="modal"
                                   data-title="Tambah Data" data-post-id=""
                                   data-action-url="groups/form"
                                   data-target="#form-modal">
                                    Tambah
                                </a>
                            </li>
                            <li class="">
                                <a href="javascript:void(0);" class="btn-delete-all">
                                    Hapus Data
                                </a>
                            </li>
                            <li class="">
                                <a href="javascript:void(0);" class="btn-refersh">
                                    Refresh
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="container-fluid" style="margin-bottom: 10px;">
                    <div >
                        <button type="button" class="btn btn-primary btn-sm waves-effect" 
                                data-toggle="modal"
                                data-title="Tambah Data" data-post-id=""
                                data-action-url="groups/form"
                                data-target="#form-modal">
                            Tambah
                        </button>
                        <button type="button" class="btn btn-danger btn-sm waves-effect btn-delete-all">
                            Hapus Data
                        </button>
                        <button type="button" class="btn btn-default btn-sm waves-effect btn-refersh">
                            Refresh
                        </button>
                    </div>
                </div>
                <!--begin: Datatable -->
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover dataTable">
                        <thead>
                            <tr>
                                <th style="text-align: center;">ID</th>
                                <th style="min-width: 100px;width: 100px;text-align: center;">Set Akses</th>
                                <th style="width: 200px;text-align: center;">Nama Grup</th>
                                <th style="text-align: center;">Keterangan</th>
                                <th style="min-width: 80px;width: 80px;text-align: center;">
                                    <i class="fa fa-th"></i>
                                </th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Aksi</th>
                                <th>Nama Grup</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody></tbody>
                    </table> 
                </div>
                <!--end: Datatable -->
            </div>
        </div>
    </div>
</div>
<!-- #END# Basic Examples -->

<script type="text/javascript">
    $(document).ready(function () {
        $(".btn-refersh").click(function () {
            table.ajax.reload();
        });

        $(".btn-delete-all").click(function () {
            var id = [];
            $('input[name=checkable]:checked').each(function () {
                id.push($(this).val());
            });
            if (id.length === 0) {
                swal({
                    title: "Peringatan",
                    html: "Silahkan pilih data yang akan dihapus!",
                    type: "error"
                });
            } else {
                swal({
                    title: "Konfirmasi Multiple Hapus",
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
                            url: "<?php echo $submit; ?>",
                            data: {"id": id
                                , "stat": "deleteall"
                                , "<?= $this->security->get_csrf_token_name(); ?>": $('meta[name=csrf]').attr("content")
                            },
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
                                        }
                                    });
                                } else {
                                    swal({
                                        title: obj.title,
                                        html: obj.msg,
                                        type: "error"
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
                                        location.reload();
                                    }
                                });
                            }
                        });
                    }
                });
            }
        });

        var column_list = [
            {"data": "id",
                render: function (data, type, row) {
                    return ' \n <input type="checkbox" value="' + data + '" name="checkable" id="basic_checkbox_' + data + '" class="m-checkable filled-in chk-col-red" />' +
                            ' \n <label class="chk-datatable" for="basic_checkbox_' + data + '"></label>';
                }
            },
            {"data": "id",
                render: function (data, type, row) {
                    var btn = '<center>' +
                            '<a class="btn bg-green btn-xs waves-effect"' +
                            ' data-toggle="modal"' +
                            ' data-title="Set Akses ' + row.name + '"' +
                            ' data-post-id="' + data + '"' +
                            ' data-action-url="groups/set_group_access"' +
                            ' data-target="#form-modal"' +
                            ' data-width="98%"' +
                            ' href="#">' +
                            '<i class="material-icons">group</i>' +
                            '</a>' +
                            '</center>';
                    return btn;
                }
            },
            {"data": "name",
                render: $.fn.dataTable.render.text()
            },
            {"data": "description",
                render: $.fn.dataTable.render.text()
            },
            {"data": "id",
                render: function (data, type, row) {
                    var btn = '<center>' +
                            '<a class="btn bg-cyan btn-xs waves-effect"' +
                            ' data-toggle="modal"' +
                            ' data-title="Edit Data"' +
                            ' data-post-id="' + data + '"' +
                            ' data-action-url="groups/form"' +
                            ' data-target="#form-modal"' +
                            ' href="javascript:void(0);">' +
                            '<i class="material-icons">mode_edit</i>' +
                            '</a>' +
                            '<a class="btn bg-red btn-xs waves-effect"' +
                            ' onclick="deleted(\'' + data + '\');"' +
                            ' href="javascript:void(0);">' +
                            '<i class="material-icons">delete</i>' +
                            '</a>' +
                            '</center>';
                    return btn;
                }
            }
        ];

        var column_def = [
            {
                "orderable": false,
                "targets": 0,
                "width": "10px"
            },
            {
                "orderable": false,
                "targets": 1
            },
            {
                "targets": [2],
                "orderData": [0, 1]
            },
            {
                "orderable": false,
                "targets": 4
            }
        ];
        var orders = [[2, "asc"]];
        set_datatable('dataTable', "<?= site_url('groups/json_dgview'); ?>", column_list, column_def, null, orders);
    });

    function deleted(id) {
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
                    url: "<?php echo $submit; ?>",
                    data: {"id": id
                        , "stat": "delete"
                        , "<?= $this->security->get_csrf_token_name(); ?>": $('meta[name=csrf]').attr("content")
                    },
                    success: function (resp) {
                        var obj = jQuery.parseJSON(resp);
                        update_csrf(obj);
                        if (obj.state === "1") {
                            table.ajax.reload();
                            swal({
                                title: obj.title,
                                html: obj.msg,
                                type: "success"
                            }).then((result) => {
                                if (result.value) {

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
            }
        });
    }
</script>