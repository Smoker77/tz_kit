let Tree = {}

/*
* Загрузка дерева
* */
Tree.load = ()=>{
    // Дерево
    App.ajax(
        'tree',
        'getTree',
        (response)=>{document.querySelector('.sidebar div.tree').innerHTML=response;},
        {}
    );

    // Добавить элемент
    App.ajax(
        'tree',
        'getSelectOption',
        (response)=>{document.querySelector('main.content .addtreeitem select[name=parent]').innerHTML=response;},
        {'selected':1, 'empty':false}
    );

    // Редактировать элемент => Элемент для редактирования
    App.ajax(
        'tree',
        'getSelectOption',
        (response)=>{document.querySelector('main.content select[name=treeitem]').innerHTML=response;},
        {'selected':0, 'empty':true}
    );

    // Редактировать элемент => Родитель
    App.ajax(
        'tree',
        'getSelectOption',
        (response)=>{document.querySelector('main.content .edittreeitem select[name=parent]').innerHTML=response;},
        {'selected':1, 'empty':false}
    );

    for (var item of document.querySelectorAll('main.content form')) {
        item.reset();
    }
}

Tree.sendForm = (controller, action, formData)=>{
    App.ajax(controller, action, Tree.checkAjaxAuthError, formData);
}

/*
* Проверяет результат Ajax запроса
* ok  => Перегружает Ajaxом контент
* !ok => Выводит invalid_feedback c jib,rjq
* */
Tree.checkAjaxAuthError = (text)=>{
    if(text != 'ok'){
        App.error('Ошибка!'+'<br>'+text);
    }else{
        Tree.load();
    }
}

Tree.clearForm = (formId)=>{
    name = ''; parent_id=0; descr = '';

    let form = document.querySelector('main.content form#'+formId);

    //form.querySelector('select[name=parent]').selectedIndex = parent_id;
    form.querySelector('select[name=parent]').value = parent_id;
    form.querySelector('input[name=name]').value = name;
    form.querySelector('textarea[name=description]').value = descr;
}




document.addEventListener('DOMContentLoaded', function(){
    /*
    * Клик по дереву
    * */
    document.querySelector('.sidebar div.tree').addEventListener('click', function(e) {
        e.preventDefault();
        //if (e.target.localName == 'a'){}
        //if (e.target.classList.contains('aaa')){}
    });

    /*
    * Клик по кнопкам форм
    * */
    document.querySelector('body').addEventListener('click', function(e){
        //console.log(e.target);

        if (e.target.classList.contains('formtreeitembutton')){
            // Клик по какой-то из кнопок форм
            e.preventDefault();
            if ( e.target.form != null){
                // Кнопка с тегом form
                let action = e.target.form.dataset.action;
                let formData = new FormData(e.target.form);
                let formDataEntries = Object.fromEntries(new FormData(e.target.form).entries());

                if(e.target.name == 'del') {
                    action = 'deltreeitem';
                }
                Tree.sendForm('tree', action, formDataEntries);



                //console.log(action);
                //console.log(formDataEntries);
            }else{
                // Любая другая кнопка
                console.log('Любая другая кнопка');
                Tree.clearForm('addtreeitem');
                Tree.clearForm('edittreeitem');
            }
        }

    });

    /*
    * Изменение select Элемент для редактирования
    * document.querySelector('#edittreeitem select[name=parent]').selectedIndex=2
    * document.querySelector('aside div.tree a[data-id="6"]').dataset.name
    * */
    document.querySelector('#edittreeitem select[name=treeitem]').addEventListener('change', function(e){
        console.log('Изменение select Элемент для редактирования');
        //let id = e.target.selectedIndex;
        let id = e.target.value;


        etarget = e.target;
        console.log(e.target);
        console.log(id);

        if(id == 0){
            var name = ''; var parent_id=1; var descr = '';
        }else{
            var name = document.querySelector('aside div.tree a[data-id="'+id+'"]').dataset.name;
            var parent_id = document.querySelector('aside div.tree a[data-id="'+id+'"]').dataset.parent_id;
            var descr = document.querySelector('aside div.tree a[data-id="'+id+'"]').parentNode.querySelector('span.description').title;
        }

        let form = document.querySelector('main.content form#edittreeitem');

        //form.querySelector('select[name=parent]').selectedIndex = parent_id;
        form.querySelector('select[name=parent]').value = parent_id;
        form.querySelector('input[name=name]').value = name;
        form.querySelector('textarea[name=description]').value = descr;
    });





    Tree.load();

});