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
    <title> Đăng ký </title>
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

    .signup-form {
        position: absolute;
        background-color: white;
        border-radius: 5px;
        padding: 15px;
        width: 475px;
    }

    .shadow {
        box-shadow: 0 0 10px 0 rgb(0 0 0 / 20%);
    }
</style>

<body class="wrapper">
    <form class="signup-form center shadow" onsubmit="return false;">
        <div class="h3 fw-bold">
            Đăng ký
        </div>

        <p class="h5"> Tài khoản </p>
        <input id="signup-username" class="form-control" name="username" type="text" placeholder="Nhập tài khoản" required>

        <p class="h5 pt-2"> Mật khẩu </p>
        <input id="signup-password" class="form-control" name="password" type="password" placeholder="Nhập mật khẩu" required>

        <p class="h5 pt-2"> Nhập lại mật khẩu </p>
        <input id="signup-retype-password" class="form-control" name="retypepassword" type="password" placeholder="Nhập lại mật khẩu" required>

        <div class="py-2 form-check"> 
            <input id="signup-term" class="form-check-input" name="term" type="checkbox">
            <label class="form-check-label" for="signup-term"> Tôi chấp nhận Điều khoản, Điều kiện và Thông tin bảo mật </label> 
        </div>
        
        <button class="btn btn-primary w-100" type="submit"> Đăng ký </button>
        <div class="pt-2 text-center"> Đã có tài khoản? <a href="/login"> Đăng nhập ngay </a> </div>
    </form>
</body>
</html>

<script>
    $(".signup-form").submit(function(e) {
        let username = $("#signup-username")[0].value;
        let password = $("#signup-password")[0].value;
        let term = $("#signup-term")[0].checked;

        if (!term) {
            alert("Chấp thuận điều khoản để có thể tiến hành đăng ký!");
            return;
        }

        $.ajax({
            url: "signup.php", 
            method: "POST",
            data: {"username": username, "password": password},
            success: function(response){
                console.log(response);
                if (response == 'success') {
                    alert("Đăng ký thành công!");
                    window.location.href = "/login";
                }else if (response == "exists") {
                    alert("Tên tài khoản này đã có người sử dụng. Hãy đặt tên tài khoản khác!");
                }else {
                    alert("Đăng ký thất bại");
                }
            }
        });
    });
</script>