<h1><?= $title;?></h1>
<form id="registerform" class="authorizeform" action="/register" data-action="register" method="post">
    <div>
        <label for="login">Логин:</label>
        <input type="text" name="login" placeholder="Введите имя пользователя" size="40" spellcheck required>
    </div>
    <div>
        <label for="email">e-mail:</label>
        <input type="text" name="email" placeholder="Введите адрес почты" size="40" spellcheck required>
    </div>
    <div>
        <label for="password">Пароль:</label>
        <input type="password" name="password" placeholder="Введите пароль" size="40" required>
    </div>
    <div>
        <label for="password2">Повтор:</label>
        <input type="password" name="password2" placeholder="Введите пароль еще раз" size="40" required>
    </div>
</form>
<div class="authorizebuttons">
    <button type="button" name="fCancel" class="authorizebutton authorizebuttons_cancel">Отмена</button>
    <button type="submit" name="fRegister" class="authorizebutton authorizebuttons_register" form="registerform">Регистрация</button>
</div>
<?php

