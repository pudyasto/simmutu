/* 
 * ***************************************************************
 * Script : main.js
 * Version : 
 * Date : Feb 22, 2018 - 2:13:39 PM
 * Author : Pudyasto Adi W.
 * Email : mr.pudyasto@gmail.com
 * Description : 
 * ***************************************************************
 */
var ajax_g_proces;
setInterval(function () {
    var tanggal = moment().format('DD MMMM YYYY, H:mm:ss');
    $(".date-time").html(tanggal);
}, 1000);

$(".btn-logout").click(function () {
    logout();
});

function logout() {
    location.replace(base_url('access/logout/'));
}

window.chartArrayColors = [
	'rgb(255, 99, 99)',
	'rgb(249, 162, 180)',
	'rgb(255, 159, 64)',
	'rgb(255, 205, 86)',
	'rgb(75, 192, 192)',
	'rgb(99, 169, 255)',
	'rgb(99, 233, 255)',
	'rgb(153, 102, 255)',
	'rgb(255, 99, 255)',
	'rgb(201, 203, 207)',
	'rgb(201, 203, 150)',
	'rgb(201, 203, 100)'
];

window.chartColors = {
	red: 'rgb(255, 99, 132)',
	orange: 'rgb(255, 159, 64)',
	yellow: 'rgb(255, 205, 86)',
	green: 'rgb(75, 192, 192)',
	blue: 'rgb(54, 162, 235)',
	purple: 'rgb(153, 102, 255)',
	grey: 'rgb(201, 203, 207)'
};

$(".chosen-select").chosen({
    no_results_text: "Maaf, data tidak ditemukan!"
});

$(".upper").blur(function(e){
    var v = $(this).val();
    var n = v.toUpperCase();
    $(this).val(n);
});
    
$('.year').datepicker({
    startView: "year",
    minViewMode: "years",
    todayBtn: "linked",
    keyboardNavigation: false,
    forceParse: false,
    calendarWeeks: false,
    autoclose: true,
    format: "yyyy"
});

$('.expdate').datepicker({
    startView: "year",
    todayBtn: "linked",
    keyboardNavigation: false,
    forceParse: false,
    calendarWeeks: false,
    autoclose: true,
    format: "dd-mm-yyyy"
});

$('.calendar').datepicker({
    todayBtn: "linked",
    keyboardNavigation: false,
    forceParse: false,
    calendarWeeks: false,
    autoclose: true,
    format: "dd-mm-yyyy"
});

$('.calendar-en').datepicker({
    todayBtn: "linked",
    keyboardNavigation: false,
    forceParse: false,
    calendarWeeks: false,
    autoclose: true,
    format: "yyyy-mm-dd"
});

$('.month').datepicker({
    startView: "year",
    minViewMode: "months",
    todayBtn: "linked",
    keyboardNavigation: false,
    forceParse: false,
    calendarWeeks: false,
    autoclose: true,
    format: "mm-yyyy"
});

$("input:text").focus(function() { $(this).select(); } );

$('#form-modal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
//    console.log(button);
    var title = button.data('title');
    var action_url = button.data('action-url');
    var post_id = button.data('post-id');
    var width = button.data('width');
    if (width) {
//        console.log(width);
        $(".modal-dialog").css("min-width", width);
    }
    if (action_url !== undefined) {
        $.ajax({
            type: "GET",
            url: base_url(action_url),
            data: {"id": post_id},
            beforeSend: function () {
                $("#form-modal-content").html("");
            },
            success: function (resp) {
                $("#form-modal-content").html(resp);
                set_controls();
            },
            error: function (event, textStatus, errorThrown) {
                swal("Kesalahan!", 'Pesan: ' + textStatus + ' , HTTP: ' + errorThrown, "error");
            }
        });
        var modal = $(this);
        modal.find('.modal-title').text(title);
    }
});

$('#form-modal').on('hidden.bs.modal', function () {
    $(".modal-dialog").css("min-width", "");
    $("#form-modal-content").html("");
});

$('#form-modal').on('shown.bs.modal', function () {
    $('.chosen-select', this).chosen('destroy').chosen({
        no_results_text: "Maaf, data tidak ditemukan!"
    });
});

function set_controls() {
    $(".chosen-select").chosen({
        no_results_text: "Maaf, data tidak ditemukan!"
    });

    $(".upper").blur(function(e){
        var v = $(this).val();
        var n = v.toUpperCase();
        $(this).val(n);
    });

    $(".money").blur(function(e){
        var v = $(this).val();
        var n = numeral(v).format('0,0');
        $(this).val(n);
    });

    $(".money").focus(function(e){
        var v = $(this).val();
        var n = numeral(v).value();
        $(this).val(n);
    });

    $(".percent").blur(function(e){
        var v = $(this).val();
        var n = numeral(v).format('0,0.00');
        $(this).val(n);
    });

    $(".percent").focus(function(e){
        var v = $(this).val();
        var n = numeral(v).value();
        $(this).val(n);
    });

    $('.year').datepicker({
        startView: "year",
        minViewMode: "years",
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: false,
        autoclose: true,
        format: "yyyy"
    });

    $('.expdate').datepicker({
        startView: "years",
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: false,
        autoclose: true,
        format: "dd-mm-yyyy"
    });

    $('.calendar').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: false,
        autoclose: true,
        format: "dd-mm-yyyy"
    });


    $('.calendar-en').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: false,
        autoclose: true,
        format: "yyyy-mm-dd"
    });

    $('.month').datepicker({
        startView: "year",
        minViewMode: "months",
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: false,
        autoclose: true,
        format: "mm-yyyy"
    });
    
    $("input:text").focus(function() { $(this).select(); } );
    
    $(".dt-buttons").removeClass("btn-group");
    $(".dt-buttons").css("margin-top","10px");
    $(".dt-buttons").css("text-align","left");
    $.AdminBSB.input.activate();
    $.AdminBSB.select.activate();
    $.AdminBSB.search.activate();
}

function update_csrf(param) {
    $("meta[name=csrf]").attr("content", param.csrf_return);
    $("input[name^='csrf']").val(param.csrf_return);
    $("hidden[name^='csrf']").val(param.csrf_return);
}

function format_mask_tgl(tanggal){
    var str = tanggal;
    var dd = str.substring(0, 2);
    var mm = str.substring(2,4);
    var yyyy = str.substring(4,8);
    return dd+"-"+mm+"-"+yyyy;
}

function format_kode_akun(kd_akun){
    if(kd_akun.toString().length>3){
        var kode_depan = kd_akun.toString().substr(0, 3);
        var kode_belakang = kd_akun.toString().substr(3, kd_akun.toString().length);
        return kode_depan + "-" + kode_belakang;
    }else{
        return kd_akun;
    }
}

function format_phone_number(phone){
    var str  = phone.toString().substr(0, 2);
    if(str!=="0"){
        return "0"+phone;
    }else{
        return phone;
    }
}

/*
 * Datatable Generator
 * 
 * element = Class HTML Document Object Model (DOM) 
 * url = Url Destination
 * column_list = Column list for datasource 
 * ex : 
 * var column_list = [
 {"data": "menu_name",
 render: $.fn.dataTable.render.text()
 },
 {"data": "submenu",
 render: $.fn.dataTable.render.text()
 },
 {"data": "description",
 render: $.fn.dataTable.render.text()
 },
 {"data": "id",
 render: function (data, type, row) {
 var btn = '<a class="btn btn-outline-primary btn-sm"' + 
 ' data-toggle="modal"' + 
 ' data-title="Edit Data"' + 
 ' data-post-id="'+data+'"' +
 ' data-action-url="menus/form"' +
 ' data-target="#form-modal"' +
 ' href="javascript:void(0);">' + 
 '<i class="fa fa-pencil"></i></a>' + 
 '' + 
 '<a class="btn btn-outline-danger btn-sm"' + 
 ' onclick="deleted(\''+data+'\');"' +
 ' href="javascript:void(0);">' + 
 '<i class="fa fa-trash"></i></a>';
 return btn;
 }
 }
 ];
 * column_def = Column Definition for custom column 
 * ex :
 * var column_def = [
 {"orderable": false, "targets": 3}
 ];
 * data_push = Extra data if you need for more variable
 * ex : 
 * var data_push = [
 { "name": "kelas", "value": 1 }
 ,{ "name": "id_tahun_akademik", "value": 2018 }
 ];
 */

// Variable global untuk datatable
var glob_where_datatable;
function set_datatable(
  element
, url
, column_list
, column_def
, data_push
, order
, groupColumn
, colspan
, lengthMenu
, action_url
, ordering
, checkall) {
    if (!order) {
        order = [[1, "asc"]];
    };
    if(!lengthMenu){
        lengthMenu = [[10, 25, -1], [10, 25, "All"]];
    }
    if(ordering===undefined || ordering === null){
        ordering = true;
    }
    if(checkall===undefined){
        checkall = true;
    }
    
    table = $('.' + element).DataTable({
        "bProcessing": true,
        "responsive": !0,
        "bServerSide": true,
        "columns": column_list,
        "columnDefs": column_def,
        "order": order,
        "ordering": ordering,
        "lengthMenu": lengthMenu,
        "pagingType": "full_numbers",
        "fnServerParams": function (aoData) {
            aoData.push({"name": $('meta[name=csrf]').attr("id")
                , "value": $('meta[name=csrf]').attr("content")});
        },
        "headerCallback": function (e, a, t, n, s) {
            if(checkall===true){
                e.getElementsByTagName("th")[0].innerHTML = '<input type="checkbox" name="checkable" id="basic_checkbox_main_header" class="filled-in chk-col-red m-group-checkable" /> <label style="height: 9px; padding-left: 12px;" for="basic_checkbox_main_header"></label>';
            }
        },
        "drawCallback": function (settings) {
//            console.log(groupColumn);
            if (!isNaN(groupColumn) && groupColumn!==undefined && groupColumn!==null) {
                var api = this.api();
                var rows = api.rows({page: 'current'}).nodes();
                var last = null;

                api.column(groupColumn, {page: 'current'}).data().each(function (group, i) {
                    if (last !== group) {
                        var d = new Date(group);
                        if(d.getFullYear()){
                            var bulan = ["Jan","Feb","Mar","Apr","Mei","Juni","Juli","Agt","Sept","Okt","Nov","Des"];
                            group = d.getDate() + " " + bulan[d.getMonth()] + " " + d.getFullYear();
                        }
                        $(rows).eq(i).before(
                                '<tr class="group"><td colspan="'+colspan+'"><b>' + group + '</b></td></tr>'
                                );

                        last = group;
                    }
                });
            }
        },
        "fnServerData": function (sSource, aoData, fnCallback) {
            if (glob_where_datatable) {
                for (i = 0; i < glob_where_datatable.length; i++) {
                    aoData.push(glob_where_datatable[i]);
                }
            }
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
                "beforeSend": function () {
                    $(".btn").addClass('disabled');
                },
                "success": function (resp) {
                    $(".btn").removeClass('disabled');
                    update_csrf(resp);
                    //$('meta[name=csrf]').attr("content",resp.csrf_return);
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
        "sAjaxSource": url,
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
        "sDom": "<'row'<'col-sm-6'B><'col-sm-6 text-right' l> r> t <'row'<'col-sm-6'i><'col-sm-6 text-right'p>> ",
        //"sDom": "<'row'<'col-sm-6'l><'col-sm-6 text-right'>r> t <'row'<'col-sm-6'i><'col-sm-6 text-right'p>> ",
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

    $('.' + element).tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    });

    $('.' + element + ' tfoot th').each(function () {
        var title = $('.' + element + '  tfoot th').eq($(this).index()).text();
        if (title !== "Aksi" && title !== "ID") {
            $(this).html('<input type="text" class="form-control form-control-sm form-datatable" style="width:100%;border-radius: 0px;" placeholder="Cari ' + title + '" />');
        } else {
            $(this).html('');
        }
    });

    table.columns().every(function () {
        var that = this;
        $('input', this.footer()).on('keyup change', function (ev) {
            //if (ev.keyCode == 13) { //only on enter keypress (code 13)
            that
                    .search(this.value)
                    .draw();
            //}
        });
    });

    if(checkall===true){
        table.on("change", ".m-group-checkable", function () {
            var e = $(this).closest("table").find("td:first-child .m-checkable"), a = $(this).is(":checked");
            $(e).each(function () {
                a ? ($(this).prop("checked", !0), $(this).closest("tr").addClass("active")) : ($(this).prop("checked", !1), $(this).closest("tr").removeClass("active"));
            });
        });
    }

    $(".dt-buttons").removeClass("btn-group");
    $(".dt-buttons").css("margin-top","10px");
    $(".dt-buttons").css("text-align","left");
//    if (groupColumn !== null) {
//        $('.' + element + ' tbody').on('click', 'tr.group', function () {
//            var currentOrder = table.order()[0];
//            if (currentOrder[0] === groupColumn && currentOrder[1] === 'asc') {
//                table.order([groupColumn, 'desc']).draw();
//            } else {
//                table.order([groupColumn, 'asc']).draw();
//            }
//        });
//    }
}