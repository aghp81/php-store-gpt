<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>داشبورد مدیریت سایت</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Vazir', sans-serif;
        }
        .sidebar {
            background-color: #343a40;
            color: white;
            min-height: 100vh;
            padding-top: 20px;
            position: fixed;
            width: 250px;
            transition: all 0.3s;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px 15px;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            margin-right: 250px;
            padding: 20px;
            transition: all 0.3s;
        }
        .sidebar.collapsed {
            width: 0;
            padding: 0;
        }
        .content.collapsed {
            margin-right: 0;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <h4 class="text-center">مدیریت سایت</h4>
    <a href="#">داشبورد</a>
    <a href="#">کاربران</a>
    <a href="#">محصولات</a>
    <a href="#">سفارشات</a>
    <a href="#">تنظیمات</a>
</div>

<!-- Main Content -->
<div class="content" id="content">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <button class="btn btn-secondary d-lg-none" onclick="toggleSidebar()">☰</button>
            <a class="navbar-brand" href="#">داشبورد مدیریت</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="#">خروج</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main dashboard content -->
    <div class="container mt-4">
        <div class="row">
            <!-- Card examples -->
            <div class="col-md-3">
                <div class="card text-center bg-primary text-white mb-3">
                    <div class="card-body">
                        <h5 class="card-title">تعداد کاربران</h5>
                        <p class="card-text">150 نفر</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center bg-success text-white mb-3">
                    <div class="card-body">
                        <h5 class="card-title">محصولات</h5>
                        <p class="card-text">200 محصول</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center bg-warning text-white mb-3">
                    <div class="card-body">
                        <h5 class="card-title">سفارشات</h5>
                        <p class="card-text">75 سفارش</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center bg-danger text-white mb-3">
                    <div class="card-body">
                        <h5 class="card-title">پیام‌ها</h5>
                        <p class="card-text">10 پیام</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Example table for users -->
        <div class="card mt-4">
            <div class="card-header">لیست کاربران</div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>شناسه</th>
                            <th>نام</th>
                            <th>ایمیل</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>علی رضایی</td>
                            <td>ali@example.com</td>
                            <td>فعال</td>
                            <td>
                                <button class="btn btn-sm btn-primary">ویرایش</button>
                                <button class="btn btn-sm btn-danger">حذف</button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>سارا احمدی</td>
                            <td>sara@example.com</td>
                            <td>غیرفعال</td>
                            <td>
                                <button class="btn btn-sm btn-primary">ویرایش</button>
                                <button class="btn btn-sm btn-danger">حذف</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleSidebar() {
        document.getElementById("sidebar").classList.toggle("collapsed");
        document.getElementById("content").classList.toggle("collapsed");
    }
</script>

</body>
</html>
