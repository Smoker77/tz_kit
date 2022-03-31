<main class="content">
    <h2>Добавить элемент</h2>

    <form id="addtreeitem" class="addtreeitem" action="/addtreeitem" data-action="addtreeitem" method="post">
        <div>
            <label for="parent">Родитель:</label>
            <select name="parent" >
                <option selected value="1">Чебурашка</option>
                <option value="2">Крокодил Гена</option>
                <option value="3">Шапокляк</option>
                <option value="4">Крыса Лариса</option>
            </select>
        </div>
        <div>
            <label for="name">Название:</label>
            <input type="text" name="name" placeholder="Введите название узла" size="40" spellcheck required>
        </div>
        <div>
            <label for="description">Описание:</label>
            <textarea name="description" placeholder="Введите описание узла" rows="5" cols="40" spellcheck required></textarea>
        </div>
    </form>
    <div class="addtreeitembuttons">
        <button type="button" name="cancel" class="formtreeitembutton addtreeitembutton addtreeitembuttons_cancel">Очистить</button>
        <button type="submit" name="submit" class="formtreeitembutton addtreeitembutton addtreeitembuttons_submit" form="addtreeitem">Добавить</button>
    </div>



    <h2>Редактировать элемент</h2>
    <form id="edittreeitem" class="edittreeitem" action="/edittreeitem" data-action="edittreeitem" method="post">
        <div>
            <label for="treeitem"><b>Элемент для редактирования / удаления:</b><br></label>
            <select name="treeitem" >
                <option selected value="1">Чебурашка</option>
                <option value="2">Крокодил Гена</option>
                <option value="3">Шапокляк</option>
                <option value="4">Крыса Лариса</option>
            </select>
        </div>
        <div>
            <label for="parent">Родитель:</label>
            <select name="parent" >
                <option selected value="1">Чебурашка</option>
                <option value="2">Крокодил Гена</option>
                <option value="3">Шапокляк</option>
                <option value="4">Крыса Лариса</option>
            </select>
        </div>
        <div>
            <label for="name">Название:</label>
            <input type="text" name="name" placeholder="Введите название узла" size="40" spellcheck required>
        </div>
        <div>
            <label for="description">Описание:</label>
            <textarea name="description" placeholder="Введите описание узла" rows="5" cols="40" spellcheck required></textarea>
        </div>
    </form>
    <div class="edittreeitembuttons">
        <button type="button" name="cancel" class="formtreeitembutton edittreeitembutton edittreeitembuttons_cancel">Очистить</button>
        <button type="submit" name="submit" class="formtreeitembutton edittreeitembutton edittreeitembuttons_submit" form="edittreeitem">Изменить</button>
        <button type="submit" name="del" class="formtreeitembutton deltreeitembutton deltreeitembuttons_submit" form="edittreeitem">Удалить</button>
    </div>



</main>
<aside class="sidebar">
    <h2>Меню</h2>
    <div class="tree"></div>

</aside>

<?php

