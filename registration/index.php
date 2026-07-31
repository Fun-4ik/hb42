<?php require_once '../php/reg.php'?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/general-style.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/header.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/reg.css">
</head>
<body>
    <?require_once __DIR__.'/../php/header.php'?>

    <main>

            <?if (!isset($_GET['ref']) && $_GET['ref'] != '') {?>

            <form action="" method="POST" class="reg-block">
                <h1>Регистрация</h1>
                <input type="text" name="userName" class="input--name" placeholder="ФИО">
                <input type="text" max="2008-06-01" name="userBirthDate" onfocus="(this.type='date')" onblur="if(!this.value) this.type='text'" class="input--birthdate" placeholder="Дата рождения">
                <input type="email" name="userEmail" class="input--email" placeholder="Почта">
                <input type="tel" id="phone" name="userPhone" class="input--phone" placeholder="Номер телефона">
                <input type="password" name="userPassword" class="input--password" placeholder="Пароль">
                <input type="password" name="userPasswordRepeat" class="input--password" placeholder="Повторите пароль">
                
                <input name="registration" type="submit" class="reg-enter" value="Зарегистрироваться">
                
                <div class="error-reg">
                    <?echo $error ?? '';?>
                </div>
            </form>

            <?}elseif(isset($fatal_error)){?>
                <div class="error-reg">
                    <?echo $fatal_error ?? '';?>
                </div>
            <?}else{?>

            <form action="" method="POST" class="reg-block">
                <h1>Партнерам</h1>
                <p>Хотите разместить свои услуги у нас, тогда заполните форму и оставьте заявку. Мы обязательно ее рассмотрим.</p>
                <input type="text" name="companyName" class="input--company" placeholder="Название организации">
                <input type="text" name="userName" class="input--name" placeholder="ФИО Руководителя">
                <p>Поле "Желаемые категории" необязательно к заполнению. Если вы не нашли категорию которая вам необходима, тогда укажите нужную вам.</p>
                <input type="text" name="desiredCategories" class="input--categories" placeholder="Желаемые категории">
                <input type="text" name="city" class="input--city" placeholder="Укажите город">
                <input type="email" name="userEmail" class="input--email" placeholder="Почта">
                <input type="tel" id="phone" name="userPhone" class="input--phone" placeholder="Номер телефона">
                <input type="password" name="userPassword" class="input--password" placeholder="Пароль">
                <input type="password" name="userPasswordRepeat" class="input--password" placeholder="Повторите пароль">
                
                <input name="registration" type="submit" class="reg-enter" value="Зарегистрироваться">
                
                <div class="error-reg">
                    <?echo $error ?? '';?>
                </div>
            </form>

            <?}?>

    </main>
</body>
<script>
    const phoneInput = document.getElementById('phone');

  phoneInput.addEventListener('input', (e) => {
    let input = e.target.value.replace(/\D/g, ''); // Удаляем все нецифры
    
    // Если первая цифра 8 или 7, приводим к единому формату
    if (input.startsWith('8')) input = '7' + input.substring(1);
    if (!input.startsWith('7') && input.length > 0) input = '7' + input;

    let formatted = '';
    if (input.length > 0) formatted += '+7 ';
    if (input.length > 1) formatted += '(' + input.substring(1, 4);
    if (input.length > 4) formatted += ') ' + input.substring(4, 7);
    if (input.length > 7) formatted += '-' + input.substring(7, 9);
    if (input.length > 9) formatted += '-' + input.substring(9, 11);

    e.target.value = formatted;
  });
</script>
</html>