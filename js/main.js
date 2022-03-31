let App = {};
/*
* Вывод сообщения об ошибке
* @param string Текст ошибки
* @param integer optional Время отображения
* */
App.error = (text, timeout=3000)=>{
    let errDiv = document.querySelector('#invalid_feedback');
    errDiv.innerHTML = text;
    errDiv.classList.toggle('show');
    setTimeout(() => {
        errDiv = document.querySelector('#invalid_feedback').classList.toggle('show');
        }, timeout);
};

/*
* Отправка Ajax запроса
* @param string Имя контроллера
* @param string Имя экшена
* @param function optional Функция обработки ответа
* @param object optional Объект с POST данными
* */
App.ajax = (controller, action, func=null, paramObj={})=>{
    //console.log('App.ajax');
    //console.log(paramObj);

    //let url = "http://kit.loc/"+controller+"/"+action;
    let url = "/"+controller+"/"+action;
    let params = '';
    for (var key in paramObj){
        params += (params.length == 0)?'':'&';
        params += ''+key+'='+paramObj[key];
    }
    //console.log(url);
    //console.log(params);

    let request = new XMLHttpRequest();
    request.responseType = "text";
    request.open("POST", url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.addEventListener("readystatechange", () => {
         if (request.readyState === 4 && request.status === 200) {
             //console.log(request.response);
             if(func != null){
                 func(request.response);
             }
         }
    });
    request.send(params);
};
App.createPopup = (html)=>{
    document.querySelector('#popup').innerHTML = html;
};
App.destroyPopup = ()=>{
    document.querySelector('#popup').innerHTML = '';
};

App.openPopup = (action)=>{
    App.ajax(
        'popup',
        action,
        App.createPopup,
        {'qq':'qqqq', 'w':'wwww'}
    );
};

/*
* Проверяет результат Ajax запроса
* ok  => Закрывает модалку и релоадит при успехе
* !ok => Выводит invalid_feedback c jib,rjq
* */
App.checkAjaxAuthError = (text)=>{
    if(text != 'ok'){
        App.error('Ошибка!'+'<br>'+text);
    }else{
        App.destroyPopup();
        window.location.href = '/';
    }
}

App.sendForm = (controller, action, formData)=>{
    App.ajax(controller, action, App.checkAjaxAuthError, formData);
}





document.addEventListener('DOMContentLoaded', function(){
    document.querySelector('.authorization').addEventListener('click', function(e){
        //console.log(e.target);

        if (e.target.classList.contains('login')) {
            // Клик по ссылке Войти
            e.preventDefault();
            console.log('Вход');
            App.openPopup('login');
        }else if (e.target.classList.contains('register')){
            // Клик по ссылке Регистрация
            e.preventDefault();
            console.log('Регистрация');
            App.openPopup('register');
        }else if (e.target.classList.contains('logout')){
            // Клик по ссылке Выход
            e.preventDefault();
            App.sendForm('user', 'logout', []);
        }
    });

    document.querySelector('body').addEventListener('click', function(e){
        //console.log(e.target);

        if (e.target.classList.contains('popup_wrapper')) {
            // Клик по затемнению
            e.preventDefault();
            App.destroyPopup();
        }else if (e.target.classList.contains('authorizebutton')){
            // Клик по какой-то из кнопок форм регистрация - вход
            e.preventDefault();
            if ( e.target.form != null){
                // Кнопка с тегом form
                let action = e.target.form.dataset.action;
                let formData = new FormData(e.target.form);
                let formDataEntries = Object.fromEntries(new FormData(e.target.form).entries());
                App.sendForm('user', action, formDataEntries);
            }else{
                // Любая другая кнопка
                App.destroyPopup();
            }
        }

    });







});



