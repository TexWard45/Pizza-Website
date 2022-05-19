<style>
    .center-location {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
    }

    .box {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 200px;
        height: 200px;
        background-color: var(--bs-gray-dark);
        border-radius: 5px;
        padding: 10px;
        margin: 50px;
        text-align: center;
        vertical-align: middle;
        user-select: none;
    }

    .box:hover {
        opacity: 0.8;
    }

    .box:active {
        opacity: 1.0;
    }
</style>

<div class="center-location">
    <div class="box text-white category" data-path="category"> 
        Thống kê doanh thu theo danh mục bánh pizza 
    </div>
    <div class="box text-white pizza"  data-path="pizza">
        Thống kê doanh thu theo bánh pizza
    </div>
</div>

<script>
    $(".category").click(function() {
        let element = $(this)[0];

        currentMenu = element.dataset.path;

        $.ajax({
            url: "/admin/statistic/" + element.dataset.path + "/index.php", 
            method: "POST",
            data: {},
            success: function(response){
                if (response == 'no_permission') {
                    alert("Bạn không có quyền truy cập!");
                }else {
                    $(".content").html(response);
                }
            }
        });
    });

    $(".pizza").click(function() {
        let element = $(this)[0];

        currentMenu = element.dataset.path;

        $.ajax({
            url: "/admin/statistic/" + element.dataset.path + "/index.php", 
            method: "POST",
            data: {},
            success: function(response){
                if (response == 'no_permission') {
                    alert("Bạn không có quyền truy cập!");
                }else {
                    $(".content").html(response);
                }
            }
        });
    });
</script>