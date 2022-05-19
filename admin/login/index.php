<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/ico" href="/img/logo.ico">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.css">
    <script src="/node_modules/jquery/dist/jquery.js"></script>
    <title> Đăng nhập </title>
</head>

<style>
    body {
        margin: 0px;
    }

    .wrapper {
        position: relative;
        width: 100%;
        height: 100vh;
        background-color: var(--red-color);
    }

    .login-form {
        position: absolute;
        background-color: white;
        border-radius: 5px;
        padding: 15px;
        width: 400px;
    }

    .shadow {
        box-shadow: 0 0 10px 0 rgb(0 0 0 / 20%);
    }

    .forget-password {
        float: right;
    }
</style>

<body class="wrapper">
    <form class="login-form center shadow" onsubmit="return false;">
        <div class="h3 fw-bold">
            Đăng nhập
        </div>

        <p class="h5"> Tài khoản </p>
        <input id="login-username" class="form-control" name="username" type="text" placeholder="Nhập tài khoản">

        <p class="h5 pt-2"> Mật khẩu </p>
        <input id="login-password" class="form-control" name="password" type="password" placeholder="Nhập mật khẩu">

        <button class="btn btn-primary w-100 mt-3" type="submit"> Đăng nhập </button>
    </form>
</body>
</html>

<script>
    $(".login-form").submit(function(e) {
        let username = $("#login-username")[0].value;
        let password = $("#login-password")[0].value;

        $.ajax({
            url: "/admin/login/login.php", 
            method: "POST",
            data: {"username": username, "password": password},
            success: function(response){
                console.log(response);
                if (response == 'success') {
                    alert("Đăng nhập thành công!");
                    window.location.href = "/admin/";
                }else if (response == 'admin') {
                    alert("Tài khoản không có quyền đăng nhập vào trang quản trị!");
                }else {
                    alert("Thông tin đăng nhập bị sai!");
                }
            }
        });
    });
</script>