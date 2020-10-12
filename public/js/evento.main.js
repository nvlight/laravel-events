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

var btnsAddCat = document.querySelectorAll('button[data-target="#add-category-modal"]');
for(let i=0; i<btnsAddCat.length; i++){
    btnsAddCat[i].addEventListener('click', function (e) {
        currentEventoId = this.parentElement.parentElement.getAttribute('data-evento-id');
        //console.log(currentEventoId);
    });
}

var addCategoryModal = document.getElementById('add-category-modal');
var myAddCategoryModal = new bootstrap.Modal(document.getElementById('add-category-modal'), {keyboard: false});
addCategoryModal.addEventListener('shown.bs.modal', function (e) {

    //console.log(e);
    //console.log(e.target.id);
    const url = "/cabinet/evento/eventocategory/create_ajax/";
    const params = "_token=" + token;

    const request = new XMLHttpRequest();
    request.open("POST", url);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.addEventListener("readystatechange", () => {
        if(request.readyState === 4 && request.status === 200) {
            let rs = JSON.parse(request.responseText);
            if (rs.length){
                var categoriesSelect = document.querySelector('form[name=addCategoryForm] select[name=categories]');
                if (categoriesSelect){
                    // очищение и заполнение селекта из полученных категорий
                    removeOptions(categoriesSelect);
                    for(let i=0; i<rs.length; i++){
                        var option = document.createElement("option");
                        option.text = rs[i]['name'];
                        option.value = rs[i]['id'];
                        categoriesSelect.add(option);
                    }
                    // первоначальное заполнение евенто_ид и категори_ид
                    if (categoriesSelect.selectedOptions.length){
                        let categoryId = categoriesSelect.selectedOptions[0].value;

                        let eventoIdFormInput   = document.querySelector('form[name=addCategoryForm] input[name=evento_id]');
                        let categoryIdFormInput = document.querySelector('form[name=addCategoryForm] input[name=category_id]');

                        if (categoryId && categoryIdFormInput){
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
                            var need_tr = document.querySelector('tr[data-evento-id="'+currentEventoId+'"] .category_td')
                            need_tr.innerHTML = rs['category_name'] + '<br>' + need_tr.innerHTML;
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