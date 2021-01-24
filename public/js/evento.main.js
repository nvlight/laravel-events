var currentEventoId = 0, token = "some token...";
var findToken = document.head.querySelector('meta[name="csrf-token"]');
var addStandAloneCategoryBtnFind = document.querySelector('#addStandAloneCategoryBtnId');
var editCategoryInputText = "";
if (findToken){
    if (findToken.hasAttribute('content')){
        token = findToken.getAttribute('content');
    }
}
let resultMessageInnerForStandaloneCategory = document.querySelector('form[name=addStandaloneCategoryForm] .resultMessage');
let resultMessageInnerForStandaloneTag = document.querySelector('form[name=addStandaloneTagForm] .resultMessage');

//
function categoryAddEditButtonCatch()
{
    var categoryAddEditButton = document.querySelectorAll('.category-add--edit-button');

    for(let i=0; i<categoryAddEditButton.length; i++){
        categoryAddEditButton[i].addEventListener('click', categoryAddEditButtonHandler);
    }
}

function removeOldAddCategoryButtons()
{
    let oldButtons = document.querySelectorAll('.add-category-crud--buttons');
    if (oldButtons){
        for(let i=0; i<oldButtons.length; i++){
            oldButtons[i].remove();
        }
    }
}

function categoryAddEditButtonHandler(e)
{
    e.stopImmediatePropagation();
    //console.log(e);
    //console.log(e.target);
    //console.log(e.target.parentElement);
    let needTr = e.target.parentElement.parentElement;
    //console.log(needTr);

    if (needTr){
        let nameTd = needTr.querySelector('.add-category-crud--name-field');
        //console.log(nameTd);
        if (nameTd){
            // delete old div with confirm/cancel buttons.
            // todo!
            removeOldAddCategoryButtons();
            deleteInputForChangeCategoryText();

            let catTextWithForm = addInputTagForEditCategoryText(needTr);

            addButtonsForAddCategoryTd(needTr, nameTd, catTextWithForm);
        }
    }

    //console.log(e.target.parentElement.parentElement.getAttribute('class'));
    return false;
}

function catchEnterPressForEditInputCategoryText() {
    var form = document.querySelector('form[name=crudNameEditForm]');
    if (form) {
        form.onsubmit = function (e) {

            // check this?
            changeCategoryCrudHandler(e);

            return false;
        }
    }
}

function deleteInputForChangeCategoryText()
{
    // todo2
    let input = document.querySelectorAll('.add-category-crud--name-field .text');
    if (input){
        for(let i=0; i<input.length; i++){
            let innerInput = input[i].querySelector('input');
            if (innerInput){
                //input[i].innerHTML = innerInput.value;
                input[i].innerHTML = editCategoryInputText;
                break;
            }
        }
    }
}

function addFocusForEditCategoryInput()
{
    let input = document.querySelector("input[name='crudEditCategoryInput']");
    if (input){
        editCategoryInputText = input.value;
        input.focus();
        //console.log('current_input:'+editCategoryInputText);
    }
}

function addInputTagForEditCategoryText(needTr)
{
    let categoryText = needTr.querySelector('.add-category-crud--name-field .text');
    if (categoryText){
        // save current input value
        editCategoryInputText = categoryText.innerHTML;

        let input = document.createElement('input');
        input.setAttribute('class', 'form-control test-classs');
        input.setAttribute('name', 'crudEditCategoryInput');
        input.setAttribute('value',categoryText.innerHTML);
        input.setAttribute('placeholder', 'type new category');

        let form = document.createElement('form');
        form.setAttribute('name', 'crudNameEditForm');
        form.setAttribute('class', 'crudNameEditForm');
        form.appendChild(input);

        categoryText.innerHTML = "";
        categoryText.appendChild(form);
    }
    return categoryText;
}

function addButtonsForAddCategoryTd(needTr, nameTd, catTextWithForm)
{
    const url = "/cabinet/evento/category/get_change_category_buttons/";
    const params = "_token=" + token;

    const request = new XMLHttpRequest();
    request.open("GET", url);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.addEventListener("readystatechange", () => {
        if (request.readyState === 4 && request.status === 200) {
            let rs = JSON.parse(request.responseText);
            //console.log('rs.length : '+rs.length);
            if (rs.success) {
                nameTd.innerHTML = '<div class="text">' + catTextWithForm.innerHTML + '</div>' + rs.buttons;

                // again
                var input = document.querySelector('input[name="crudEditCategoryInput"');
                var div = input.parentElement;

                var form = document.createElement('form');
                form.setAttribute('name', 'crudNameEditForm');
                form.setAttribute('class', 'crudNameEditForm');
                form.appendChild(input);

                div.innerHTML = '';

                div.append(form);

                // добавление перехвата - enter по полю редактирования
                catchEnterPressForEditInputCategoryText();
            }
            addFocusForEditCategoryInput();
            addCategoryCrudCancelHandler();
            changeCategoryCrudHandle();
        }
    });
    //request.addEventListener("load", () => { categoryAddEditButtonCatch(); });

    request.send(params);
}



/// ################################################
// add category for evento
function removeOptions(selectElement) {
    var i, L = selectElement.options.length - 1;
    for(i = L; i >= 0; i--) {
        selectElement.remove(i);
    }
}

function saveCurrentDataEventoId(){
    var btnsAddCat = document.querySelectorAll('svg[data-target="#add-category-modal"], svg[data-target="#add-tag-modal"]');
    for(let i=0; i<btnsAddCat.length; i++){
        btnsAddCat[i].addEventListener('click', function (e) {
            currentEventoId = this.parentElement.parentElement.getAttribute('data-evento-id');
            //console.log(currentEventoId);
        });
    }
}
saveCurrentDataEventoId();

//
function getUserCategories()
{
    const url = "/cabinet/evento/eventocategory/get_user_categories/";
    const params = "_token=" + token;

    const request = new XMLHttpRequest();
    request.open("POST", url);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.addEventListener("readystatechange", () => {
        if (request.readyState === 4 && request.status === 200) {
            let rs = JSON.parse(request.responseText);
            if (rs.length) {
                var categoriesSelect = document.querySelector('form[name=addCategoryForm] select[name=categories]');
                if (categoriesSelect) {
                    // очищение и заполнение селекта из полученных категорий
                    removeOptions(categoriesSelect);
                    for (let i = 0; i < rs.length; i++) {
                        var option = document.createElement("option");
                        option.text = rs[i]['name'];
                        option.value = rs[i]['id'];
                        categoriesSelect.add(option);
                    }
                    // первоначальное заполнение евенто_ид и категори_ид
                    if (categoriesSelect.selectedOptions.length) {
                        let categoryId = categoriesSelect.selectedOptions[0].value;

                        let eventoIdFormInput = document.querySelector('form[name=addCategoryForm] input[name=evento_id]');
                        let categoryIdFormInput = document.querySelector('form[name=addCategoryForm] input[name=category_id]');

                        if (categoryId && categoryIdFormInput) {
                            categoryIdFormInput.value = categoryId;
                        }
                        eventoIdFormInput.value = currentEventoId;
                    }
                }
                //
            }
            //
        }
    });
    //request.addEventListener("load", () => { categoryAddEditButtonCatch();});
    //categoryAddEditButtonCatch();
    request.send(params);
}

function getCategories()
{
    const url = "/cabinet/evento/category/index_ajax/";
    const params = "_token=" + token;

    const request = new XMLHttpRequest();
    request.open("GET", url);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.addEventListener("readystatechange", () => {
        if (request.readyState === 4 && request.status === 200) {
            let rs = JSON.parse(request.responseText);
            if (rs['success'] === 1) {
                let crudCats = document.querySelector('.crud_categories');
                if (crudCats){
                    crudCats.innerHTML = rs['categories']
                    deleteCategoryForCrud();
                }
            }
        }
    });
    request.send(params);
}

// category delete links
function deleteCategoryForCrud()
{
    let deleteCategoryForCrud = document.querySelectorAll('a.category_delete_for_crud');
    if (deleteCategoryForCrud.length) {
        for (let i = 0; i < deleteCategoryForCrud.length; i++) {
            deleteCategoryForCrud[i].onclick = function (e) {
                e.stopImmediatePropagation();

                let href = "/cabinet/evento/category/destroy_ajax/" + this.getAttribute('data-id');

                const params = "_token=" + token;

                const request = new XMLHttpRequest();
                request.open("GET", href);
                request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                request.addEventListener("readystatechange", () => {
                    if (request.readyState === 4 && request.status === 200) {
                        let rs = JSON.parse(request.responseText);
                        if (rs['success'] === 1) {
                            // <div class="eventoCategoryDiv" data-eventoCategoryId="{{ $category['evento_evento_category_id'] }}">
                            if (rs['evIds'] && rs['evIds'].length){
                                for(let i=0; i<rs['evIds'].length; i++){
                                    var tmpGetEventoCategoryDiv = null;
                                    tmpGetEventoCategoryDiv = document.querySelector('div.eventoCategoryDiv[data-eventoCategoryId="'+rs['evIds'][i]+'"]');
                                    if (tmpGetEventoCategoryDiv){
                                        tmpGetEventoCategoryDiv.remove();
                                    }
                                }
                            }
                            getCategories();
                            getUserCategories();
                        }
                    }

                });
                request.send(params);

                return false;
            }
        }
        // todo
        removeOldAddCategoryButtons();
        deleteInputForChangeCategoryText();
        categoryAddEditButtonCatch();
    }
}

//
function getUserTags()
{
    const url = "/cabinet/evento/eventotag/get_user_tags/";
    const params = "_token=" + token;

    const request = new XMLHttpRequest();
    request.open("POST", url);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.addEventListener("readystatechange", () => {
        if (request.readyState === 4 && request.status === 200) {
            let rs = JSON.parse(request.responseText);
            if (rs.length) {
                var categoriesSelect = document.querySelector('form[name=addEventoTagForm] select[name=tags]');
                if (categoriesSelect) {
                    // очищение и заполнение селекта из полученных категорий
                    removeOptions(categoriesSelect);
                    for (let i = 0; i < rs.length; i++) {
                        var option = document.createElement("option");
                        option.text = rs[i]['name'];
                        option.value = rs[i]['id'];
                        categoriesSelect.add(option);
                    }
                    // первоначальное заполнение евенто_ид и категори_ид
                    if (categoriesSelect.selectedOptions.length) {
                        let categoryId = categoriesSelect.selectedOptions[0].value;

                        let eventoIdFormInput = document.querySelector('form[name=addEventoTagForm] input[name=evento_id]');
                        let categoryIdFormInput = document.querySelector('form[name=addEventoTagForm] input[name=tag_id]');

                        if (categoryId && categoryIdFormInput) {
                            categoryIdFormInput.value = categoryId;
                        }
                        eventoIdFormInput.value = currentEventoId;
                    }
                }
            }
        }
    });
    request.send(params);
}

// сохранение категории для Евенто, не просто для категории
var addCategoryModal = document.getElementById('add-category-modal');
if (addCategoryModal){
    var myAddCategoryModal = new bootstrap.Modal(document.getElementById('add-category-modal'), {keyboard: false});

    addCategoryModal.addEventListener('shown.bs.modal', function (e)
    {
        console.log('+ for category modal');

        // +plus плюсик нажат!
        getCategories();
        getUserCategories();
        showCategoryAddSuccessMessage();
        hideCategoryAddSuccessMessage();
    });
}

// сохранение тега для Евенто, не просто для категории
var addTagModal = document.getElementById('add-tag-modal');
if (addTagModal){
    var myAddTagModal = new bootstrap.Modal(document.getElementById('add-tag-modal'), {keyboard: false});

    addTagModal.addEventListener('shown.bs.modal', function (e)
    {
        console.log('+ for tag modal');

        addEventoTagForm.reset();

        if (resultMessageInnerForStandaloneTag){
            resultMessageInnerForStandaloneTag.classList.add('d-none');
        }
        getUserTags();
        getTags();
    });
}

// сохранение категории - перехват сабмита и отправка xhr запроса.
var addCategoryForm = document.querySelector('form[name=addCategoryForm]');
if (addCategoryForm) {
    addCategoryForm.onsubmit = function (e) {
        //console.log('submit stoped');

        var categoriesSelect = document.querySelector('form[name=addCategoryForm] select[name=categories]');
        if (categoriesSelect){
            if (categoriesSelect.selectedOptions.length){
                let categoryId = categoriesSelect.selectedOptions[0].value;

                let eventoIdFormInput   = document.querySelector('form[name=addCategoryForm] input[name=evento_id]');
                let categoryIdFormInput = document.querySelector('form[name=addCategoryForm] input[name=category_id]');

                if (categoryId && categoryIdFormInput){
                    categoryIdFormInput.value = categoryId;
                }
                eventoIdFormInput.value = currentEventoId;

                // all data prepared for add
                var addCategoryData = '&evento_id=' + currentEventoId + '&category_id=' + categoryId;
                //console.log(addCategoryData);

                // xhr
                const url = "/cabinet/evento/eventocategory/store_ajax/";
                const params = "_token=" + token + addCategoryData;
                const request = new XMLHttpRequest();
                request.open("POST", url);
                request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                request.addEventListener("readystatechange", () => {
                    if(request.readyState === 4 && request.status === 200) {
                        let rs = JSON.parse(request.responseText);
                        //console.log(rs);
                        if (rs['success']){
                            let need_tr = document.querySelector('tr[data-evento-id="'+currentEventoId+'"] .category_td');

                            // добавление ссылки, который будет производить удаление через перезагрузку страницы
                            //let delete_link = '<a href="/cabinet/evento/eventocategory/destroy/' + rs['eventocategory_id'] + '" class="delete_category" data-categoryId="' + rs['eventocategory_id'] + '">delete</a>';
                            let delete_link = '<a href="/cabinet/evento/eventocategory/destroy/' + rs['eventocategory_id'] + '"' +
                                                   'class="delete_category" data-categoryId="' + rs['eventocategory_id'] + '">' +
                                                    '<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg" role="button">' +
                                                        '<path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/>' +
                                                    '</svg>' +
                                                '</a>';
                            let textHtml = '<span class="categoryNameText" data-textvalue="'+rs['category_name']+'">'+rs['category_name']+'</span>';
                            let delete_link_div_wrapper = '<div class="eventoCategoryDiv" data-eventocategoryid="'+rs['eventocategory_id']+'">' + textHtml + delete_link + '</div>';
                            need_tr.innerHTML =  delete_link_div_wrapper + need_tr.innerHTML;

                            deleteEventoCategoryAddHandler();

                            myAddCategoryModal.hide();
                        }
                    }
                });
                request.send(params);
            }
        }

        return false;
    };
}

// сохранение тега (+значение) - перехват сабмита и отправка xhr запроса.
var addEventoTagForm = document.querySelector('form[name=addEventoTagForm]');
if (addEventoTagForm) {
    addEventoTagForm.onsubmit = function (e) {
        //console.log('submit stoped');

        var tagsSelect = document.querySelector('form[name=addEventoTagForm] select[name=tags]');
        if (tagsSelect){
            if (tagsSelect.selectedOptions.length){

                let tagId = tagsSelect.selectedOptions[0].value;
                let eventoIdFormInput = document.querySelector('form[name=addEventoTagForm] input[name=evento_id]');
                let tagIdFormInput = document.querySelector('form[name=addEventoTagForm] input[name=tag_id]');
                let tagValue = document.querySelector('form[name=addEventoTagForm] input[name=value]');
                let tagCaption = document.querySelector('form[name=addEventoTagForm] input[name=caption]');

                if (tagId && tagIdFormInput){
                    tagIdFormInput.value = tagId;
                }
                eventoIdFormInput.value = currentEventoId;
                if (!tagValue){
                    tagValue.value = null;
                }
                if (!tagCaption){
                    tagCaption.value = null;
                }

                // all data prepared for add
                var addTagData = '&evento_id=' + currentEventoId + '&tag_id=' + tagId + '&value=' + tagValue.value + '&caption=' + tagCaption.value
                //console.log(addTagData);

                // xhr
                const url = "/cabinet/evento/eventotag/store_ajax/";
                const params = "_token=" + token + addTagData;
                const request = new XMLHttpRequest();
                request.open("POST", url);
                request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                request.addEventListener("readystatechange", () => {
                    if(request.readyState === 4 && request.status === 200) {
                        let rs = JSON.parse(request.responseText);
                        //console.log(rs);
                        if (rs['success']){
                            let need_tr = document.querySelector('tr[data-evento-id="'+currentEventoId+'"] .tag_td');

                            // добавление ссылки, который будет производить удаление через перезагрузку страницы
                            let delete_link = '<a href="/cabinet/evento/eventotag/destroy/' + rs['eventotag_id'] + '"' +
                                'class="delete_tag" data-tagId="' + rs['eventotag_id'] + '">' +
                                '<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg" role="button">' +
                                '<path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/>' +
                                '</svg>' +
                                '</a>';
                            let delete_link_div_wrapper;
                            let textHtml;

                            if (rs['tag_value'] == undefined){
                                textHtml = '<span class="tagNameText" data-textvalue="'+rs['tag_name']+'">'+rs['tag_name'] +'</span>';
                                delete_link_div_wrapper = '<div class="eventoTagDiv" data-eventotagid="'+rs['eventotag_id']+'">' + textHtml + delete_link + '</div>';
                            }else{
                                textHtml = '<span class="tagNameText" data-textvalue="'+rs['tag_name']+'">'+rs['tag_name']+ ' (' + rs['tag_value'] +  ') ' +'</span>';
                                delete_link_div_wrapper = '<div class="eventoTagDiv" data-eventotagid="'+rs['eventotag_id']+'">' + textHtml + delete_link + '</div>';
                            }

                            need_tr.innerHTML =  delete_link_div_wrapper + need_tr.innerHTML;

                            deleteEventoTagAddHandler();

                            myAddTagModal.hide();
                        }
                    }
                });
                request.send(params);
            }
        }

        return false;
    };
}

function deleteEventoCategoryAddHandler()
{
    let deleteCategoryTagA = document.querySelectorAll('a.delete_category');
    if (deleteCategoryTagA.length){
        for(let i=0; i<deleteCategoryTagA.length; i++){
            deleteCategoryTagA[i].onclick = function(e){
                e.stopImmediatePropagation();
                //console.log('delete category a');
                let categoryId = this.getAttribute('data-categoryId');
                //console.log(categoryId);

                const url = "/cabinet/evento/eventocategory/destroy_ajax/"+categoryId;
                const params = "_token=" + token + '&_method=DELETE';
                const request = new XMLHttpRequest();
                request.open("POST", url);
                request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                request.addEventListener("readystatechange", () => {
                    if(request.readyState === 4 && request.status === 200) {
                        let rs = JSON.parse(request.responseText);
                        if (rs['success']){
                            this.parentElement.remove();
                        }
                    }
                });
                request.send(params);

                saveCurrentDataEventoId();

                return false;
            }
        }
    }
}
deleteEventoCategoryAddHandler();

function deleteEventoTagAddHandler()
{
    let deleteTagTagA = document.querySelectorAll('a.delete_tag');
    if (deleteTagTagA.length){
        for(let i=0; i<deleteTagTagA.length; i++){
            deleteTagTagA[i].onclick = function(e){
                e.stopImmediatePropagation();

                let tagId = this.getAttribute('data-tagId');

                const url = "/cabinet/evento/eventotag/destroy_ajax/"+tagId;
                const params = "_token=" + token + '&_method=DELETE';
                const request = new XMLHttpRequest();
                request.open("POST", url);
                request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                request.addEventListener("readystatechange", () => {
                    if(request.readyState === 4 && request.status === 200) {
                        let rs = JSON.parse(request.responseText);
                        if (rs['success']){
                            this.parentElement.remove();
                        }
                    }
                });
                request.send(params);

                saveCurrentDataEventoId();

                return false;
            }
        }
    }
}
deleteEventoTagAddHandler();


/* ################################################
 * scripts for all delete buttons for confirmed them
 */
var currentDeleteItemHref = null;
let deleteItemA = document.querySelectorAll('a.deleteItem');
if (deleteItemA.length){
    for (let i=0; i<deleteItemA.length; i++){
        deleteItemA[i].onclick = function (e) {
            e.stopImmediatePropagation();
            if (deleteItemA[i].hasAttribute('href')){
                let href = deleteItemA[i].getAttribute('href');
                currentDeleteItemHref = href;
                //console.log(href);
                dialogOpenBtnHandler();

                let deleteConfirmBtn = document.querySelector('.deleteConfirmBtn');
                if (deleteConfirmBtn){
                    deleteConfirmBtn.onclick = function () {
                        deleteConfirmBtnHandler(currentDeleteItemHref);
                    }
                }
            }
            return false;
        }
    }
}

let openDeactivateDialog = document.querySelector('#openDeactivateDialog');
if (openDeactivateDialog){
    openDeactivateDialog.addEventListener('click', dialogOpenBtnHandler)
}

let cancelBtn = document.querySelector('.cancelBtn');
if (cancelBtn){
    cancelBtn.addEventListener('click', dialogCloseBtnHandler);
}

let closeMainDialogOnDarkSide = document.querySelector('#main_dialog');
if (closeMainDialogOnDarkSide){
    closeMainDialogOnDarkSide.onclick = function(e) {
        //console.log(e.target.classList + ' clicked ' + Math.random(100));
        let targetClass = '#main_dialog';
        let isFindTarget = document.querySelector(targetClass);

        if (e.target.classList.contains('modalBg') && isFindTarget ){
            isFindTarget.classList.toggle('d-none');
        }
    };
}

function dialogOpenBtnHandler() {
    let targetClass = '#main_dialog';
    let isFindTarget = document.querySelector(targetClass);
    if (isFindTarget){
        isFindTarget.classList.toggle('d-none');
    }
}
function dialogCloseBtnHandler() {
    let targetClass = '#main_dialog';
    let isFindTarget = document.querySelector(targetClass);
    if (isFindTarget){
        isFindTarget.classList.toggle('d-none');
    }
}
function deleteConfirmBtnHandler(href) {
    document.location.href = href;
}

// evento delete confirmation
let eventoDeleteLinks = document.querySelectorAll('.evento_delete');
if (eventoDeleteLinks.length){
    for(let i=0; i<eventoDeleteLinks.length; i++){
        eventoDeleteLinks[i].onclick = function (e) {
            e.stopImmediatePropagation();

            if (!confirm('Delete item?')){
                return false;
            }

            //console.log('item deleted!');
        };
    }
}

function addStandAloneCategoryBtnFindClick(e)
{
    e.preventDefault();

    const categoryAddRequestUrl = "/cabinet/evento/category/store_ajax/";
    let name = 'default';
    let parent_id = 0;

    let realName = document.querySelector('form[name=addStandaloneCategoryForm] input[name=name]');
    let realParentId = document.querySelector('form[name=addStandaloneCategoryForm] input[name=category_id]');
    if (realName){
        name = realName.value;
    }
    if (realParentId){
        parent_id = realParentId.value;
    }

    //console.log('name: '+name);
    //console.log('parent_id: '+parent_id);

    const categoryAddRequestParams = "_token=" + token + '&name=' + name + '&parent_id=' + parent_id;

    const categoryAddRequest = new XMLHttpRequest();
    categoryAddRequest.open("POST", categoryAddRequestUrl);
    categoryAddRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    categoryAddRequest.addEventListener("readystatechange", () => {
        if (categoryAddRequest.readyState === 4 && categoryAddRequest.status === 200) {
            let rs = JSON.parse(categoryAddRequest.responseText);
            // теперь нужно показать успешность добавления, а также обновить селект сверху!
            getUserCategories();
            getCategories();
            if (rs['success']){
                if (resultMessageInnerForStandaloneCategory){
                    resultMessageInnerForStandaloneCategory.classList.remove('d-none');
                    resultMessageInnerForStandaloneCategory.classList.remove('text-danger');
                    resultMessageInnerForStandaloneCategory.classList.add('text-success');
                    resultMessageInnerForStandaloneCategory.innerHTML = rs['message'];
                    if (realName){
                        realName.value = '';
                    }
                    waitAndHideCategoryAddSuccessMessage();
                }else{
                    resultMessageInnerForStandaloneCategory.classList.remove('d-none');
                    resultMessageInnerForStandaloneCategory.classList.add('text-danger');
                    resultMessageInnerForStandaloneCategory.classList.remove('text-success');
                    resultMessageInnerForStandaloneCategory.innerHTML = rs['message'];
                }
            }

            // todo
            removeOldAddCategoryButtons();
            deleteInputForChangeCategoryText();
            categoryAddEditButtonCatch();
        }
    });
    categoryAddRequest.send(categoryAddRequestParams);

    return false;
}

// #### add standalone category
if (addStandAloneCategoryBtnFind){
    addStandAloneCategoryBtnFind.onclick = addStandAloneCategoryBtnFindClick;
}
// #### END

// ### show/hide && wait/hide CategoryAddSuccessMessage
function hideCategoryAddSuccessMessage()
{
    if (resultMessageInnerForStandaloneCategory){
        resultMessageInnerForStandaloneCategory.classList.add('d-none');
    }
}
function showCategoryAddSuccessMessage()
{
    if (resultMessageInnerForStandaloneCategory){
        resultMessageInnerForStandaloneCategory.classList.remove('d-none');
    }
}
function waitAndHideCategoryAddSuccessMessage(time=2000)
{
    setTimeout(hideCategoryAddSuccessMessage, time);
}

//
function addCategoryCrudCancelHandler()
{
    let cancel = document.querySelector('.add-category-crud--cancel');
    if (cancel){
        cancel.addEventListener('click', function () {
            deleteInputForChangeCategoryText();
            removeOldAddCategoryButtons();
        });
    }
}

function changeCategoryCrudHandlerAjax(categoryId, name)
{
    const requestUrl = "/cabinet/evento/category/edit_category/"+categoryId;
    const params = "_token=" + token + '&name=' + name + '&parent_id=' + 0 + '&color=' + '#ccc';

    //console.log('name: '+name);

    const xhr = new XMLHttpRequest();
    xhr.open("POST", requestUrl);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.addEventListener("readystatechange", () => {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let rs = JSON.parse(xhr.responseText);
            if (rs['success']){
                //console.log('name: '+name);
                //console.log('name: '+rs['name']);

                // search tr
                let nameHtml = document.querySelector('.add-category--tr_id-'+rs['categoryId']+ ' .add-category-crud--name-field .text');
                //console.log('needTr: '+nameHtml);
                nameHtml.innerHTML = rs['name'];

                deleteInputForChangeCategoryText();
                removeOldAddCategoryButtons();

                // нужно заменить тексты всех категорий, которые совпадают с тем, что был заменен!
                changeAllCategorysByName(editCategoryInputText, rs['name']);

                // раз имя категории изменено, нужно обновить и категории, которые может добавить пользователь
                getUserCategories();
            }else{
                // show error in html ...
            }
        }
    });
    xhr.send(params);
}

function changeCategoryCrudHandle()
{
    let confirm = document.querySelector('.add-category-crud--confirm');
    if (confirm){
        confirm.addEventListener('click', changeCategoryCrudHandler);
    }
}
function changeCategoryCrudHandler(e)
{
    let confirm = document.querySelector('.add-category-crud--confirm');
    if (confirm){
        let needTr = confirm.parentElement.parentElement.parentElement;

        let categoryId = 0;
        let name = '';

        let nameSearch = needTr.querySelector('.add-category-crud--name-field .text input[name=crudEditCategoryInput]');
        if (nameSearch){
            //console.log(name);
            name = nameSearch.value;
        }

        let categoryTd = needTr.querySelector('.categoryId');
        if (categoryTd) {
            categoryId = +categoryTd.innerHTML;
            //console.log('catId: '+categoryId);
        }

        // save also current category input value

        changeCategoryCrudHandlerAjax(categoryId, name);
    }
}

function changeAllCategorysByName(oldName, newName)
{
    //console.log('oldName: '+oldName);
    //console.log('newName: '+newName);
    let allCatsSelector = 'span[class=categoryNameText][data-textValue="'+oldName+'"]';
    let allCats = document.querySelectorAll(allCatsSelector);
    //console.log(allCatsSelector);
    //console.log(allCats);

    if (allCats){
        for(let i=0; i<allCats.length; i++){
            allCats[i].innerHTML = newName;
            allCats[i].setAttribute('data-textValue', newName);
        }
    }
}

// #### add standalone tag
// сохранение тега (+его цвет) - перехват сабмита и отправка xhr запроса.
var addStandaloneTagForm = document.querySelector('form[name=addStandaloneTagForm]');
if (addStandaloneTagForm){
    addStandaloneTagForm.onsubmit = function (e) {
        e.stopImmediatePropagation();

        const tagAddRequestUrl = "/cabinet/evento/tag/store_ajax/";
        let name = 'default';
        let parent_id = 0;
        let color = "#ccc";

        let realName = document.querySelector('form[name=addStandaloneTagForm] input[name=name]');
        let realParentId = document.querySelector('form[name=addStandaloneTagForm] input[name=tag_id]');
        let realColor = document.querySelector('form[name=addStandaloneTagForm] input[name=color]');
        if (realName){
            name = realName.value;
        }
        if (realParentId){
            parent_id = realParentId.value;
        }
        if (realColor){
            color = realColor.value;
        }

        const tagAddRequestParams = "_token=" + token + '&name=' + name + '&parent_id=' + parent_id + '&color=' + color;

        const tagAddRequest = new XMLHttpRequest();
        tagAddRequest.open("POST", tagAddRequestUrl);
        tagAddRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        tagAddRequest.addEventListener("readystatechange", () => {
            if (tagAddRequest.readyState === 4 && tagAddRequest.status === 200) {
                let rs = JSON.parse(tagAddRequest.responseText);

                // теперь нужно показать успешность добавления, а также обновить селект сверху!
                if (rs['success']){

                    getUserTags();
                    getTags();

                    if (resultMessageInnerForStandaloneTag){

                        showTagAddSuccessMessage();
                        resultMessageInnerForStandaloneTag.innerHTML = rs['message'];
                        if (realName){
                            realName.value = '';
                        }
                        if (realColor){
                            realColor.value = '';
                        }
                        waitAndHideTagAddSuccessMessage(5000);
                    }
                }else{
                    if (resultMessageInnerForStandaloneTag) {
                        resultMessageInnerForStandaloneTag.classList.remove('d-none');
                        //resultMessageInnerForStandaloneTag.classList.add('text-danger');
                        resultMessageInnerForStandaloneTag.classList.remove('text-success');

                        //resultMessageInnerForStandaloneTag.innerHTML = rs['message'];
                        resultMessageInnerForStandaloneTag.innerHTML = "";

                        // show error lines
                        var errors = rs['errors'];
                        var customAttributes = rs['customAttributes'];

                        let keys = Object.keys(errors);
                        for(let i=0; i<keys.length; i++){
                            let p = document.createElement('p');
                            p.classList.add('m-0');
                            p.innerHTML = customAttributes[keys[i]] + ' - ' +
                            "<span class='text-danger pt-2'>" +  errors[keys[i]][0] + "</span>";
                            //console.log(span.innerHTML);
                            resultMessageInnerForStandaloneTag.appendChild(p);
                        }
                        //waitAndHideTagAddSuccessMessage(5000);
                    }
                }
            }
        });
        tagAddRequest.send(tagAddRequestParams);

        return false;
    }
}
// #### END

// ### show/hide && wait/hide CategoryAddSuccessMessage
function hideTagAddSuccessMessage()
{
    if (resultMessageInnerForStandaloneTag){
        resultMessageInnerForStandaloneTag.classList.add('d-none');
    }
}
function showTagAddSuccessMessage()
{
    if (resultMessageInnerForStandaloneTag){
        resultMessageInnerForStandaloneTag.classList.remove('d-none');
        resultMessageInnerForStandaloneTag.classList.remove('text-danger');
        resultMessageInnerForStandaloneTag.classList.add('text-success');
    }
}
function waitAndHideTagAddSuccessMessage(time=2000)
{
    setTimeout(hideTagAddSuccessMessage, time);
}

////////////////
function getTags()
{
    const url = "/cabinet/evento/tag/index_ajax/";
    const params = "_token=" + token;

    const request = new XMLHttpRequest();
    request.open("GET", url);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.addEventListener("readystatechange", () => {
        if (request.readyState === 4 && request.status === 200) {
            let rs = JSON.parse(request.responseText);
            if (rs['success'] === 1) {
                let crudTags = document.querySelector('.crud_tags');
                if (crudTags){
                    crudTags.innerHTML = rs['tags']
                    deleteTagForCrud();
                }
            }
        }
    });
    request.send(params);
}

// tag delete links
function deleteTagForCrud()
{
    let deleteTagForCrud = document.querySelectorAll('a.tag_delete_for_crud');
    if (deleteTagForCrud.length) {
        for (let i = 0; i < deleteTagForCrud.length; i++) {
            deleteTagForCrud[i].onclick = function (e) {
                e.stopImmediatePropagation();

                let href = "/cabinet/evento/tag/destroy_ajax/" + this.getAttribute('data-id');

                const params = "_token=" + token;

                const request = new XMLHttpRequest();
                request.open("GET", href);
                request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                request.addEventListener("readystatechange", () => {
                    if (request.readyState === 4 && request.status === 200) {
                        let rs = JSON.parse(request.responseText);
                        if (rs['success'] === 1) {

                            // удаление строки с основной таблицы, в котором тег, который мы только что удалили.
                            if (rs['evIds'] && rs['evIds'].length){
                                for(let i=0; i<rs['evIds'].length; i++){
                                    var tmpGetEventoCategoryDiv = null;
                                    tmpGetEventoCategoryDiv = document.querySelector('div.eventoTagDiv[data-eventoTagId="'+rs['evIds'][i]+'"]');
                                    if (tmpGetEventoCategoryDiv){
                                        tmpGetEventoCategoryDiv.remove();
                                    }
                                }
                            }

                            getUserTags();
                            getTags();
                        }
                    }

                });
                request.send(params);

                return false;
            }
        }
        // todo
        //removeOldAddCategoryButtons();
        //deleteInputForChangeCategoryText();
        //categoryAddEditButtonCatch();
    }
}