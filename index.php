<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="style.css">
  <script src="script.js" defer></script>
</head>
<body>
	
<?php require 'db.php'; ?>

<div class="block" id="reg-form">

<?php

// registration
$data = $_POST;
if (isset($data['do_signup'])) {
  if (!$data['password'] || !$data['email']) { 
    echo 'заполните поля';
  } elseif ($data['password_2'] != $data['password']){
    echo 'пароли не совпадают!';
  } elseif (R::count('users', "email = ?", array($data['email'])) > 0) {
    echo 'Email уже используется!';
  } elseif ($data['tel']) {
    if (R::count('users', "tel = ?", array($data['tel'])) > 0) {
      echo 'Номер телефона уже используется!';
    }
  } else {
    $user = R::dispense( 'users' );
    $user->name = $data['name'];
    $user->email = $data['email'];
    $user->tel = $data['tel'];
    $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
    R::store( $user );
    echo 'Вы успешно зарегистрированы!';
  }
}


// authentication //$_SESSION['logged_user'] //$_SESSION['logged_user']->name;
if (isset($data['do_login']) || isset($data['do_signup']))
{ 
  $user = R::findOne('users', 'email = ?', array($data['email']));
  if (!$data['password'] || !$data['email']) {
    echo 'заполните поля';
  } elseif (strpbrk($data['password'], "'=")) {
    echo 'Некорректные символы';
  } elseif (!$user) {
    $login_email = false;
  } elseif ( !(password_verify($data['password'], $user->password))) {
    $login_pass = false;
  } else {
    echo 'Здравствуйте, ';
    $_SESSION['logged_user'] = $user;
  }
}


if (isset($_SESSION['logged_user'])) : ?>
	<?php echo $_SESSION['logged_user']->name; ?>
	<a href="/logout.php">Выйти</a><br>
<?php else : ?>

<a class="button_signup">Создать аккаунт</a>

  <div class="block__content">
    <form class="form" method="POST" action="">
      <div class="form__group">
      	<h3>Регистрация</h3>
        <div class="row">
          <div class="col-md-12">
            <input type="text" required name="name" placeholder="Имя" value="<?php echo @$data['name']; ?>">
          </div>
          <div class="col-md-12">
            <input type="email" required name="email" placeholder="Электронный адрес" value="<?php echo @$data['email']; ?>">
          </div>
          <div class="col-md-12">
            <input type="password" required name="password" placeholder="Придумайте пароль" id="pas">
          </div>
          <div class="col-md-12">
            <input type="password" required name="password_2" placeholder="Повторите пароль" id="pas2">
          </div>
          <div class="col-md-12">
            <input type="tel" pattern="\d{3}-\d{3}-\d{4}" placeholder="Номер мобильного телефона" name="tel" value="<?php echo @$data['tel']; ?>">
          </div>
        </div>
      </div>
      <div class="form__comment">
        <button type="submit" name="do_signup" id="do_signup">Зарегистрироваться</button>
	      <div>Уже есть аккаунт? <a href="#">Войти</a></div>
	      Нажимая кнопку «Зарегистрироваться»:
	      <div>
	      	<input name="agreement" type="checkbox" required checked>
          Я принимаю условия 
          <a href="#">Пользовательского соглашения</a> 
          и даю своё согласие на обработку моей персональной информации на условиях, определенных 
          <a href="#">Политикой конфиденциальности</a>.
	      </div>
      </div>
    </form>
  </div>


<a class="button_login">Войти</a>

  <div class="block__content">
    <form class="form" method="POST" action="">
      <div class="form__group">
        <div class="row">
          <div class="col-md-12">
            <span class="error"><?php if (isset($login_email)) {echo 'Такого аккаунта нет';} ?></span>
            <input type="email" required name="email" placeholder="Введите почту" value="<?php echo @$data['email']; ?>">
          </div>
          <div class="col-md-12">
            <span class="error"><?php if (isset($login_pass)) {echo 'Неверный пароль';} ?></span>
            <input type="password" required name="password" placeholder="Введите пароль">
          </div>
        </div>
      </div>
      <div class="form__group">
        <button type="submit" name="do_login">Войти</button>
      </div>
    </form>
  </div>

<?php endif; ?>

</div>

</body>
</html>