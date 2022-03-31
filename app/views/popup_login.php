<h1><?= $title;?></h1>
<form id="loginform" class="authorizeform" action="/login" data-action="login" method="post">
        <div>
            <label for="login">Логин:</label>
            <input type="text" name="login" placeholder="Введите имя пользователя" size="40" spellcheck required>
        </div>
        <div>
            <label for="password">Пароль:</label>
            <input type="password" name="password" placeholder="Введите пароль" size="40" required>
        </div>
</form>
<div class="authorizebuttons">
    <button type="button" name="fCancel" class="authorizebutton authorizebuttons_cancel">Отмена</button>
    <button type="submit" name="fLogin" class="authorizebutton authorizebuttons_login" form="loginform">Войти</button>
</div>
<?php

