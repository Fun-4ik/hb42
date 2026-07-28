
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Партнерам</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/general-style.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/header.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/referal.css">
</head>
<body>
    <?require_once __DIR__.'/../php/header.php'?>

    <main>
        <section class="user--section">
            
            <form action="" method="POST" class="reg-block">
                <h1>Партнерам</h1>
                <p>Хотите разместить свои услуги у нас, тогда заполните форму и оставьте заявку. Мы обязательно ее рассмотрим.</p>
                <input type="text" name="userName" class="input-name" placeholder="Название организации">
                <input type="text" max="2008-06-01" name="userBirthDate" onfocus="(this.type='date')" onblur="if(!this.value) this.type='text'" class="input-birthdate" placeholder="ФИО Руководителя">
                <input type="email" name="userEmail" class="input-email" placeholder="Желаемые разделы размещения">
                <input type="tel" id="phone" name="userPhone" class="input-phone" placeholder="Город">
                <input type="password" name="userPassword" class="input-password" placeholder="Почта">
                <input type="password" name="userPasswordRepeat" class="input-password" placeholder="Телефон">
                
                <input name="registration" type="submit" class="reg-enter" value="Зарегистрироваться">
                
                <div class="error-reg">
                    <?echo $error ?? '';?>
                </div>
            </form>
            
        </section>

        

    </main>
    <script src="/assets/js/jquery-3.7.1.js"></script>

</body>
</html>