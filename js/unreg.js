let Tree = {}

/*
* Загрузка дерева
* */
Tree.load = ()=>{
    // Дерево
    App.ajax(
        'tree',
        'getTree',
        (response)=>{
            // Заполняем
            document.querySelector('.sidebar div.tree').innerHTML=response;
            // Проставляем невидимость
            for(var item of document.querySelectorAll('.sidebar div.tree>ul ul')){
                item.classList.add('hide');
            };

            // Проставляем классы + / -
            let li = document.querySelectorAll('.sidebar div.tree li');
            for(var item of li){
                let li_id = item.dataset.id;
                let li_nextul = item.parentElement.querySelector('li[data-id="'+li_id+'"]+ul');
                if (li_nextul == null){
                    item.classList.add('minus');
                    console.log(li_id);
                }else {
                    item.classList.add('plus');
                    console.log('gg'+li_id);
                }
            }
        },
        {}
    );
}







document.addEventListener('DOMContentLoaded', function(){
    /*
    * Клик по дереву
    * */
    document.querySelector('.sidebar div.tree').addEventListener('click', function(e) {
        e.preventDefault();
        //console.log(e.target);

        if (e.target.localName == 'li'){
            // Клик по плюсу

            let el = e.target;
            let el_id = e.target.dataset.id;
            let el_parent = el.parentElement;

            let el_ch_ul = el.parentElement.querySelector('li[data-id="'+el_id+'"]+ul'); // null если нет

            if (el_ch_ul != null){
                el_ch_ul.classList.toggle('hide');

                el.classList.toggle('plus');
                el.classList.toggle('minus');
            }
         } else if(e.target.localName == 'a'){
            // Клик по имени

            let el_description = e.target.dataset.description;
            document.querySelector('main.content div.description').innerHTML = el_description;
        }
    });

    // document.querySelector('div.tree li:after').addEventListener('click', function(e) {
    //     e.preventDefault();
    //     console.log(e.target);
    // });




    Tree.load();

});