var currentEventoId = 0, token = "some token...";
var findToken = document.head.querySelector('meta[name="csrf-token"]');
if (findToken){
    if (findToken.hasAttribute('content')){
        token = findToken.getAttribute('content');
    }
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
    var btnsAddCat = document.querySelectorAll('svg[data-target="#add-category-modal"]');
    for(let i=0; i<btnsAddCat.length; i++){
        btnsAddCat[i].addEventListener('click', function (e) {
            currentEventoId = this.parentElement.parentElement.getAttribute('data-evento-id');
            //console.log(currentEventoId);
        });
    }
}
saveCurrentDataEventoId();

var addCategoryModal = document.getElementById('add-category-modal');
if (addCategoryModal){
    var myAddCategoryModal = new bootstrap.Modal(document.getElementById('add-category-modal'), {keyboard: false});
}
if (addCategoryModal) {
    addCategoryModal.addEventListener('shown.bs.modal', function (e) {

        //console.log(e);
        //console.log(e.target.id);
        const url = "/cabinet/evento/eventocategory/create_ajax/";
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

                            // all data prepared for add
                            var addCategoryData = 'evento_id=' + currentEventoId + '&category_id=' + categoryId;
                            //console.log(addCategoryData);
                        }
                    }
                }
            }
        });
        request.send(params);
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
                            let delete_link_div_wrapper = '<div>' + rs['category_name'] + ' ' + delete_link + '</div>';
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

function deleteEventoCategoryAddHandler(){
// delete category a
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

/// ################################################
// scripts for all delete buttons for confirmed them
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

            console.log('item deleted!');
        };
    }
}