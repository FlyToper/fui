<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/3 0003
 * Time: 11:45
 */
?>
<!DOCTYPE html>
<html style="height: auto">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>考拉管理系统登录</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="/AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/AdminLTE/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="/AdminLTE/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/AdminLTE/dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/AdminLTE/plugins/iCheck/square/blue.css">

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="/admin/index"><b>考拉(Kola)</b> 管理系统</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">要进入后台,请先登录你的账户</p>

<!--        <form action="../../index2.html" method="post">-->
            <div class="form-group has-feedback">
                <input id="txtEmail" type="email" class="form-control" placeholder="邮箱">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input id="txtPassword" type="password" class="form-control" placeholder="密码">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>

        <div class="form-group has-feedback">
            <input id="txtCode" type="text" class="form-control" placeholder="请输入验证码">
            <span class="glyphicon glyphicon-check form-control-feedback"></span>

        </div>




            <div class="row">
                <div class="col-xs-8">
                    <?php
                    echo Captcha::widget(['name'=>'captchaimg','captchaAction'=>'/admin/index/captcha',
                        'imageOptions'=>['id'=>'captchaimg', 'title'=>'换一个', 'alt'=>'换一个', 'style'=>'cursor:pointer;margin-left:0px;'],'template'=>'{image}']);?>
                    <div class="checkbox icheck">
<!--                        <label>-->
<!--                            <input type="checkbox"> 记住密码-->
<!--                        </label>-->

                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">

                    <button id="btnLogin" class="btn btn-info btn-block btn-flat">登录</button>

                </div>
                <!-- /.col -->
            </div>
        <input type="hidden" id="txtUrl" value="<?=$url?>">
        <input type="hidden" id="txtCsrf" value="<?php echo Yii::$app->request->csrfToken; ?>" />
<!--        </form>-->

<!--        <div class="social-auth-links text-center">-->
<!--            <p>- OR -</p>-->
<!--            <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using-->
<!--                Facebook</a>-->
<!--            <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using-->
<!--                Google+</a>-->
<!--        </div>-->
<!--       -->
<!---->
<!--        <a href="#">I forgot my password</a><br>-->
<!--        <a href="register.html" class="text-center">Register a new membership</a>-->

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="/AdminLTE/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="/AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="/AdminLTE/plugins/iCheck/icheck.min.js"></script>
<script>
    $("#btnLogin").bind('click',subLogin);

    $("#txtCode").bind('keydown',function (event) {
        if(event.keyCode == '13'){
            subLogin();
        }
    });

    function subLogin() {
        var email = $("#txtEmail").val();
        var password = $("#txtPassword").val();
        var code = $("#txtCode").val();

        if(email == "" || password == "" || code == ""){
            alert("请填写完整登录信息！");
            return;
        }

        $.post("/admin/index/check-login", {"account":email ,"password":password, "_csrf":$("#txtCsrf").val(), "code":code},function (rst) {
            var json = JSON.parse(rst);

            if(json['code'] == 200) {
                //alert('success');
                var url = $("#txtUrl").val();
                if (url == "")
                    location.href = "/admin/index";
                else
                    location.href = url;
            }else if(json['code'] == 450){
                alert('验证码错误！');
            }else{
                alert(json['msg']);
            }
        });
    }


    $("#captchaimg").click(function () {
        $.get("/admin/index/captcha?refresh=1",{},function (rst) {
            //var json = JSON.parse(rst);
            $("#captchaimg").attr("src", rst['url']);
        });

    });

</script>
</body>
</html>

