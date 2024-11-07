<?php
require_once 'db.php';

// مقداردهی اولیه به متغیرها
$name = $family_name = $email = $role = $password = $confirm_password = "";
$name_err = $family_name_err = $email_err = $role_err = $password_err = $confirm_password_err = "";

// پردازش ارسال فرم
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // اعتبارسنجی نام
    if (empty(trim($_POST["name"]))) {
        $name_err = "لطفا نام خود را وارد کنید.";
    } else {
        $name = trim($_POST["name"]);
    }

    // اعتبارسنجی نام خانوادگی
    if (empty(trim($_POST["family_name"]))) {
        $family_name_err = "لطفا نام خانوادگی خود را وارد کنید.";
    } else {
        $family_name = trim($_POST["family_name"]);
    }

    // اعتبارسنجی ایمیل
    if (empty(trim($_POST["email"]))) {
        $email_err = "لطفا ایمیل خود را وارد کنید.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "لطفا یک ایمیل معتبر وارد کنید.";
    } else {
        // بررسی اینکه آیا ایمیل قبلاً ثبت شده است
        $sql = "SELECT id FROM users WHERE email = :email";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $email = trim($_POST["email"]);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $email_err = "این ایمیل قبلاً ثبت شده است.";
            }
            unset($stmt);
        }
    }

    // اعتبارسنجی نقش
    if (empty(trim($_POST["role"]))) {
        $role_err = "لطفا نقش خود را انتخاب کنید.";
    } else {
        $role = trim($_POST["role"]);
    }

    // اعتبارسنجی پسورد
    if (empty(trim($_POST["password"]))) {
        $password_err = "لطفا رمز عبور خود را وارد کنید.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "رمز عبور باید حداقل 6 کاراکتر باشد.";
    } else {
        $password = trim($_POST["password"]);
    }

    // اعتبارسنجی تکرار پسورد
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "لطفا رمز عبور خود را دوباره وارد کنید.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if ($password != $confirm_password) {
            $confirm_password_err = "رمز عبور و تکرار آن با هم مطابقت ندارند.";
        }
    }

    // درج کاربر در دیتابیس در صورت عدم وجود خطا
    if (empty($name_err) && empty($family_name_err) && empty($email_err) && empty($role_err) && empty($password_err) && empty($confirm_password_err)) {
        $sql = "INSERT INTO users (name, family_name, email, role, password) VALUES (:name, :family_name, :email, :role, :password)";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":name", $name, PDO::PARAM_STR);
            $stmt->bindParam(":family_name", $family_name, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":role", $role, PDO::PARAM_STR);
            $stmt->bindParam(":password", password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
            $stmt->execute();
            header("location: login.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>ثبت‌نام</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            direction: rtl;
            text-align: right;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2>فرم ثبت‌نام</h2>
    <form action="register.php" method="post">
        <div class="form-group">
            <label>نام</label>
            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
            <span class="invalid-feedback"><?php echo $name_err; ?></span>
        </div>
        <div class="form-group">
            <label>نام خانوادگی</label>
            <input type="text" name="family_name" class="form-control <?php echo (!empty($family_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $family_name; ?>">
            <span class="invalid-feedback"><?php echo $family_name_err; ?></span>
        </div>
        <div class="form-group">
            <label>ایمیل</label>
            <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
            <span class="invalid-feedback"><?php echo $email_err; ?></span>
        </div>
        <div class="form-group">
            <label>نقش</label>
            <select name="role" class="form-control <?php echo (!empty($role_err)) ? 'is-invalid' : ''; ?>">
                <option value="">یک نقش انتخاب کنید</option>
                <option value="admin" <?php echo ($role == 'admin') ? 'selected' : ''; ?>>مدیر</option>
                <option value="seller" <?php echo ($role == 'seller') ? 'selected' : ''; ?>>فروشنده</option>
                <option value="customer" <?php echo ($role == 'customer') ? 'selected' : ''; ?>>مشتری</option>
            </select>
            <span class="invalid-feedback"><?php echo $role_err; ?></span>
        </div>
        <div class="form-group">
            <label>رمز عبور</label>
            <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
            <span class="invalid-feedback"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group">
            <label>تکرار رمز عبور</label>
            <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
            <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="ثبت‌نام">
        </div>
        <p>قبلا حساب کاربری دارید؟ <a href="login.php">وارد شوید</a>.</p>
    </form>
</div>
</body>
</html>
