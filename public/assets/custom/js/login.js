/* 
 * ***************************************************************
 * Script : login.js
 * Version : 
 * Date : Feb 22, 2018 - 10:40:44 AM
 * Author : Pudyasto Adi W.
 * Email : mr.pudyasto@gmail.com
 * Description : 
 * ***************************************************************
 */

$("#form_login").submit(function (event) {
    event.preventDefault();
    var $form = $(this),
            username = $form.find("input[name='username']").val(),
            password = $form.find("input[name='password']").val(),
            csrf_token = $form.find("input[name='csrf_token']").val(),
            url = $form.attr("action");
    $.ajax({
        type: "POST",
        url: url,
        data: {"username": username,
            "password": password,
            "csrf_token": csrf_token
        },
        beforeSend: function () {
            $("#submit").addClass("m-loader m-loader--right m-loader--light");
            $("input").attr('disabled', true);
            $("button").attr('disabled', true);
        },
        success: function (resp) {
            $("#submit").removeClass("m-loader m-loader--right m-loader--light");
            $("input").attr('disabled', false);
            $("button").attr('disabled', false);
            var obj = jQuery.parseJSON(resp);
            if (obj.state === "1") {
                $("input[name='csrf_token']").val(obj.token);
                location.replace(base_url('main'));
            } else {
                $("input[name='csrf_token']").val(obj.token);
                $("input[name='password']").val('');
                swal({
                    title: obj.title,
                    text: obj.msg,
                    type: "error",
                    footer: '<a href="javascript:void(0);" onclick="recover();">Lupa password ?</a>'
                });
            }
        },
        error: function (event, textStatus, errorThrown) {
            $("#submit").removeClass("m-loader m-loader--right m-loader--light");
            $("input").attr('disabled', false);
            $("button").attr('disabled', false);
            swal("Kesalahan!", 'Pesan: ' + textStatus + ' , HTTP: ' + errorThrown, "error");
        }
    });
});

$("#form_recover").submit(function (event) {
    event.preventDefault();

    var $form = $(this),
            username = $form.find("input[name='username']").val(),
            csrf_token = $form.find("input[name='csrf_token']").val(),
            url = $form.attr("action");

    $.ajax({
        type: "POST",
        url: url,
        data: {"username": username,
            "csrf_token": csrf_token
        },
        beforeSend: function () {
            $("#submit-recover-password").addClass("m-loader m-loader--right m-loader--light");
            $("input").attr('disabled', true);
            $("button").attr('disabled', true);
        },
        success: function (resp) {
            $("#submit-recover-password").removeClass("m-loader m-loader--right m-loader--light");
            $("input").attr('disabled', false);
            $("button").attr('disabled', false);
            var obj = jQuery.parseJSON(resp);
            if (obj.state === "1") {
                $("input[name='csrf_token']").val(obj.token);
                swal({
                    title: obj.title,
                    html: obj.msg,
                    type: "success"
                }).then((result) => {
                    if (result.value) {
                        location.replace(base_url());
                    }
                });
            } else {
                $("input[name='csrf_token']").val(obj.token);
                swal({
                    title: obj.title,
                    html: obj.msg,
                    type: "error"
                });
            }
        },
        error: function (event, textStatus, errorThrown) {
            $("#submit-recover-password").removeClass("m-loader m-loader--right m-loader--light");
            $("input").attr('disabled', false);
            $("button").attr('disabled', false);
            swal("Kesalahan!", 'Pesan: ' + textStatus + ' , HTTP: ' + errorThrown, "error");
        }
    });
});

$("#form_reset").submit(function (event) {
    event.preventDefault();

    var $form = $(this),
            password = $form.find("input[name='password']").val(),
            confirm_password = $form.find("input[name='confirm_password']").val(),
            forgotten_password_code = $form.find("input[name='forgotten_password_code']").val(),
            csrf_token = $form.find("input[name='csrf_token']").val(),
            url = $form.attr("action");

    $.ajax({
        type: "POST",
        url: url,
        data: {"password": password,
            "confirm_password": confirm_password,
            "forgotten_password_code": forgotten_password_code,
            "csrf_token": csrf_token
        },
        beforeSend: function () {
            $("#submit").addClass("m-loader m-loader--right m-loader--light");
            $("input").attr('disabled', true);
            $("button").attr('disabled', true);
        },
        success: function (resp) {
            $("#submit").removeClass("m-loader m-loader--right m-loader--light");
            $("input").attr('disabled', false);
            $("button").attr('disabled', false);
            var obj = jQuery.parseJSON(resp);
            if (obj.state === "1") {
                $("input[name='csrf_token']").val(obj.token);
                swal({
                    title: obj.title,
                    html: obj.msg,
                    type: "success"
                }).then((result) => {
                    if (result.value) {
                        location.replace(base_url('access/index/'));
                    }
                });
            } else {
                $("input[name='csrf_token']").val(obj.token);
                swal({
                    title: obj.title,
                    html: obj.msg,
                    type: "error"
                });
            }
        },
        error: function (event, textStatus, errorThrown) {
            $("#submit").removeClass("m-loader m-loader--right m-loader--light");
            $("input").attr('disabled', false);
            $("button").attr('disabled', false);
            swal("Kesalahan!", 'Pesan: ' + textStatus + ' , HTTP: ' + errorThrown, "error");
        }
    });
});

$(".btn-reset-password").click(function () {
    recover();
});

$(".btn-login").click(function () {
    location.replace(base_url('access/index/'));
});

function recover() {
    location.replace(base_url('access/recover/'));
}