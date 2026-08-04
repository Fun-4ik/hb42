<?php

spl_autoload_register();
require_once __DIR__ . '/advanced.php';
require_once __DIR__ . '/mailsender.php';

session_start();

$admin = new Class\User;

$admin->__getUser($link, $_SESSION['user_id']);

if ($admin->role != 36) {
    header("Location: ../index.php");
    exit;
}

// Обработка действий админа
if (isset($_POST['action']) && isset($_POST['app_id'])) {
    $app_id = (int)$_POST['app_id'];
    $action = $_POST['action'];

    if ($action === 'approve') {
        // 1. Получаем данные заявки
        $res = mysqli_query($link, "SELECT * FROM `referral_applications` WHERE `id` = $app_id");
        if ($app = mysqli_fetch_assoc($res)) {
            
            // Генерируем реферальный код уже ДЛЯ НЕГО (на будущее)
            $new_ref_code = bin2hex(random_bytes(5));
            $new_verification_code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            // 2. Переносим в таблицу основных пользователей с ролью executor
            $insert_query = "INSERT INTO `user` (`email`, `password`, `role`, `verification_code`, `verified`, `referral_code`) VALUES (?, ?, 2, ?, 0, ?)";
            $stmt = mysqli_prepare($link, $insert_query);
            mysqli_stmt_bind_param($stmt, "ssis", $app['email'], $app['password'], $new_verification_code, $new_ref_code);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            $email = $app['email'];
            $usid = mysqli_query($link, "SELECT * FROM `user` WHERE `email` = '$email'");

            if ($reusid  = mysqli_fetch_assoc($usid)) {
                $insert_query = "INSERT INTO `executor_data`(`user_id`, `referrer_id`, `company_name`, `director_name`, `phone`, `city`) VALUES (?,?,?,?,?,?)";
                $stmt = mysqli_prepare($link, $insert_query);
                $referrer_id_int = (int) $app['referrer_id'];
                mysqli_stmt_bind_param($stmt, "iissss", $reusid['id'], $referrer_id_int, $app['company_name'], $app['director_name'],$app['phone'],$app['city']);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                // 3. Обновляем статус заявки в архивный
                mysqli_query($link, "UPDATE `referral_applications` SET `status` = 'approved' WHERE `id` = $app_id");

                send_mail_urlcode($mail_setup, $email, $new_verification_code);

            }

        }
    } 
    elseif ($action === 'reject') {
        // При отказе просто меняем статус, пользователь не создается
        mysqli_query($link, "UPDATE `referral_applications` SET `status` = 'rejected' WHERE `id` = $app_id");
    }
    
    header("Location: admin_panel.php");
    exit();
}

// Вывод списка активных заявок для админа
$applications = mysqli_query($link, "SELECT * FROM `referral_applications` WHERE `status` = 'pending'");
?>

<h2>Новые заявки исполнителей на модерацию</h2>
<table border="1">
    <tr>
        <th>Организация</th>
        <th>Руководитель</th>
        <th>Город</th>
        <th>Email</th>
        <th>Желаемые разделы</th>
        <th>Действие</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($applications)): ?>
    <tr>
        <td><?php echo htmlspecialchars($row['company_name']); ?></td>
        <td><?php echo htmlspecialchars($row['director_name']); ?></td>
        <td><?php echo htmlspecialchars($row['city']); ?></td>
        <td><?php echo htmlspecialchars($row['email']); ?></td>
        <td><?php echo htmlspecialchars($row['desired_categories']); ?></td>
        <td>
            <form action="" method="POST" style="display:inline;">
                <input type="hidden" name="app_id" value="<?php echo $row['id']; ?>">
                <button type="submit" name="action" value="approve" style="color:green;">Одобрить</button>
                <button type="submit" name="action" value="reject" style="color:red;">Отказать</button>
            </form>
        </td>
    </tr>
    <?php endwhile; ?>
</table>