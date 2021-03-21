var currentEventoId = 0, token = "some token...";
var findToken = document.head.querySelector('meta[name="csrf-token"]');
var addStandAloneCategoryBtnFind = document.querySelector('#addStandAloneCategoryBtnId');
var editCategoryInputText = "";

var resultMessageInnerForStandaloneCategory = document.querySelector('form[name=addStandaloneCategoryForm] .resultMessage');
var resultMessageInnerForStandaloneTag = document.querySelector('form[name=addStandaloneTagForm] .resultMessage');

var addCategoryModal = document.getElementById('add-category-modal');
var addTagModal = document.getElementById('add-tag-modal');
var addCategoryForm = document.querySelector('form[name=addCategoryForm]');
var addEventoTagForm = document.querySelector('form[name=addEventoTagForm]');

var currentDeleteItemHref = null;
var deleteItemA = document.querySelectorAll('a.deleteItem');

var openDeactivateDialog = document.querySelector('#openDeactivateDialog');
var cancelBtn = document.querySelector('.cancelBtn');
var closeMainDialogOnDarkSide = document.querySelector('#main_dialog');
var eventoDeleteLinks = document.querySelectorAll('.evento_delete');
var addStandaloneTagForm = document.querySelector('form[name=addStandaloneTagForm]');

// modals
var attachmentModal = document.getElementById('add-attachment-modal');
var eventoModal = document.getElementById('add-evento-modal');
var addEventoModal;
var addAttachmentModal;
var myAddCategoryModal;
var myAddTagModal;
var eventoShowModal = document.getElementById('show-evento-modal');
var eventoEditModal = document.getElementById('edit-evento-modal');
var tagEditModal = document.getElementById('edit-tag-modal');
var deleteEventoMessage = 'Delete evento?';
var categoryEditId = document.getElementById('edit-category-modal');
var tagvaluesPieDiagrammId = document.getElementById('tagvalue-pie-modal');
var tagvaluesMonthDiagrammId = document.getElementById('tagvalue-gistogramm-modal');

var classListFor__spinMessage = ['text-danger', 'text-success'];
var categoryEditModal;
var tagvaluesPieDiagrammModal;
var tagvaluesMonthDiagrammModal;

var pieDiagrammCanvas = document.getElementById("pieDiagrammCanvas");
let pieDiagrammCanvasContext = pieDiagrammCanvas.getContext("2d");
pieDiagrammCanvas.width = 250;
pieDiagrammCanvas.height = 250;

var Piechart = function(options){
    this.options = options;
    this.canvas = options.canvas;
    this.ctx = this.canvas.getContext("2d");
    this.colors = options.colors;

    this.draw = function(){

        var total_value = 0;
        var color_index = 0;
        for (var categ in this.options.data){
            var val = this.options.data[categ];
            total_value += val;
        }

        var start_angle = 0;
        for (categ in this.options.data){
            val = this.options.data[categ];
            var slice_angle = 2 * Math.PI * val / total_value;

            drawPieSlice(
                this.ctx,
                this.canvas.width/2,
                this.canvas.height/2,
                Math.min(this.canvas.width/2,this.canvas.height/2),
                start_angle,
                start_angle+slice_angle,
                this.colors[color_index%this.colors.length]
            );

            start_angle += slice_angle;
            color_index++;
        }

        if (this.options.doughnutHoleSize){
            drawPieSlice(
                this.ctx,
                this.canvas.width/2,
                this.canvas.height/2,
                this.options.doughnutHoleSize * Math.min(this.canvas.width/2,this.canvas.height/2),
                0,
                2 * Math.PI,
                "#ffffff"
            );
        }

        start_angle = 0;
        for (categ in this.options.data){
            val = this.options.data[categ];
            slice_angle = 2 * Math.PI * val / total_value;
            var pieRadius = Math.min(this.canvas.width/2,this.canvas.height/2);
            var labelX = this.canvas.width/2 + (pieRadius / 2) * Math.cos(start_angle + slice_angle/2);
            var labelY = this.canvas.height/2 + (pieRadius / 2) * Math.sin(start_angle + slice_angle/2);

            if (this.options.doughnutHoleSize){
                var offset = (pieRadius * this.options.doughnutHoleSize ) / 2;
                labelX = this.canvas.width/2 + (offset + pieRadius / 2) * Math.cos(start_angle + slice_angle/2);
                labelY = this.canvas.height/2 + (offset + pieRadius / 2) * Math.sin(start_angle + slice_angle/2);
            }

            var labelText = Math.round(100 * val / total_value);
            this.ctx.fillStyle = "white";
            this.ctx.font = "bold 15px Arial";
            this.ctx.fillText(labelText+"%", labelX,labelY);
            start_angle += slice_angle;
        }

        if (this.options.legend){
            color_index = 0;
            var legendHTML = "";
            for (categ in this.options.data){
                let val = this.options.data[categ];
                let currentTagProcent = Math.round(100 * val / total_value);
                legendHTML += "<div style='display: flex; align-items: center;'>" +
                    "<span class='tagNameCircle' style='background-color:"+this.colors[color_index++]+";'>" +
                    "&nbsp;</span> <span>"+`${categ} (${val} ${currentTagProcent}%)`+"</span> </div>";
            }
            this.options.legend.innerHTML = legendHTML;
        }
    }
}
//tagValues = {};
//tagColors = [];

let monthGistogrammCanvas = document.getElementById("monthGistogrammCanvas");
let monthGistogrammCanvasContext = monthGistogrammCanvas.getContext("2d");
monthGistogrammCanvas.width = 450;
monthGistogrammCanvas.height = 400;

let Barchart = function(options){
    this.options = options;
    this.canvas = options.canvas;
    this.ctx = this.canvas.getContext("2d");
    this.colors = options.colors;

    this.draw = function(){

        let numberOfBars = 0;
        let numberOfGroups = 0;
        let maxValue = 0;
        for (let i in this.options.data) {
            for (let j in this.options.data[i]) {
                maxValue = Math.max(maxValue, this.options.data[i][j]['value']);
                numberOfBars++;
            }
            numberOfGroups++;
        }
        //console.log('maxValue: '+maxValue);

        let canvasActualHeight = this.canvas.height - this.options.padding * 2;
        let canvasActualWidth = this.canvas.width - this.options.padding * 2;

        //drawing the bars
        let barIndex = 0;
        let barOffset = 10;
        let barSize = (canvasActualWidth)/ (numberOfBars + numberOfGroups - 1);

        let offset = 0; //for
        for (let i in this.options.data){

            let val0 = this.options.data[i];

            let firstOffset = 0;
            for (let j in val0){

                if (!firstOffset){
                    firstOffset++;

                    // draw month title
                    this.ctx.save();
                    this.ctx.fillStyle = this.options.gridColor;
                    this.ctx.font = "bold 11px Arial";
                    this.ctx.fillText(i,
                        this.options.padding + (barIndex * barSize) + offset,
                        this.canvas.height - this.options.padding + 11);
                    this.ctx.restore();
                }

                let val   = val0[j]['value'];
                let color = val0[j]['color'];

                let barHeight = Math.round( canvasActualHeight * val/maxValue);
                drawBar(
                    this.ctx,
                    this.options.padding + barIndex * barSize + offset,
                    this.canvas.height - barHeight - this.options.padding,
                    barSize,
                    barHeight,
                    color,
                );

                //draw bar value
                this.ctx.save();
                this.ctx.fillStyle = this.options.gridColor;
                this.ctx.font = "bold 11px Arial";
                this.ctx.fillText(val,
                    //this.options.padding + (barIndex * barSize + barSize/2 - val.toString().length*2 ) + offset,
                    this.options.padding + (barIndex * barSize + 3) + offset,
                    this.canvas.height - barHeight - this.options.padding - 5);
                this.ctx.restore();
                barIndex++;

            }

            offset += barOffset;
        }

        //drawing series name
        // this.ctx.save();
        // this.ctx.textBaseline="bottom";
        // this.ctx.textAlign="center";
        // this.ctx.fillStyle = "#000000";
        // this.ctx.font = "bold 14px Arial";
        // this.ctx.fillText(this.options.seriesName, this.canvas.width/2,this.canvas.height);
        // this.ctx.restore();

        //draw legend
        let selector = `legend[for="${options.canvas_id}"]`;
        let legend = document.querySelector(selector);
        //console.log(selector);
        //console.log(legend);
        if (legend){
            legend.innerHTML = "";
            let ul = document.createElement("ul");
            legend.append(ul);

            let columnNames = {};
            let columnColors = {};
            for (let i in this.options.data){
                for (let j in this.options.data[i]){
                    let vl = this.options.data[i][j];

                    if (!columnNames[j]){
                        columnNames[j] = vl['value'];
                    }else{
                        columnNames[j] += vl['value'];
                    }

                    if (!columnColors[j]){
                        columnColors[j] = vl['color'];
                    }
                }
            }
            //console.log(columnNames);
            //console.log(columnColors);

            barIndex = 0;
            for (let i in columnNames){
                let li = document.createElement("li");
                li.style.listStyle = "none";
                li.style.borderLeft = "20px solid "+columnColors[i];
                li.style.padding = "5px";
                li.textContent = i + ` (${columnNames[i]})`;
                ul.append(li);
                barIndex++;
            }
        }

    }
}

function conlog(e){
    console.log(e);
}

function tagEditModalFunction() {
    if (tagEditModal){
        tagEditModal = new bootstrap.Modal(tagEditModal, {keyboard: false});
    }
}
function eventoEditModalFunction() {
    if (eventoEditModal){
        eventoEditModal = new bootstrap.Modal(eventoEditModal, {keyboard: false});
    }
}
function eventoShowModalFunction() {
    if (eventoShowModal){
        eventoShowModal = new bootstrap.Modal(eventoShowModal, {keyboard: false});
        eventoEditModal.addEventListener('shown.bs.modal', function () {
            spinMessages__startingHide();
        });
    }
}
function attachmentModalFunction() {
    if (attachmentModal){
        addAttachmentModal = new bootstrap.Modal(attachmentModal, {keyboard: false});
    }
}
function eventoModalFunction() {
    if (eventoModal) {
        addEventoModal = new bootstrap.Modal(eventoModal, {keyboard: false});

        eventoModal.addEventListener('shown.bs.modal', function () {
            spinMessages__startingHide();
        });
    }
}
function categoryEditModalFunction(){
    if (categoryEditId){
        categoryEditModal = new bootstrap.Modal(categoryEditId, {keyboard: false});
    }
}

function tagvaluesPieDiagrammFunction() {
    if (tagvaluesPieDiagrammId){
        tagvaluesPieDiagrammModal = new bootstrap.Modal(tagvaluesPieDiagrammId, {keyboard: false});
    }
}

function tagvaluesMonthDiagrammFunction() {
    if (tagvaluesMonthDiagrammId){
        tagvaluesMonthDiagrammModal = new bootstrap.Modal(tagvaluesMonthDiagrammId, {keyboard: false});
    }
}

function categoryAddEditButtonCatch() {
    var categoryAddEditButton = document.querySelectorAll('.category_edit_for_crud');

    for(let i=0; i<categoryAddEditButton.length; i++){
        categoryAddEditButton[i].onclick = categoryAddEditButtonHandler;
    }
}

// todo - here
function categoryAddEditButtonHandler(e)
{
    let current = e.currentTarget;
    //conlog(current);

    // todo -  получить данные текущей категории и показать их на формочке
    // <a class="category_edit_for_crud" href="/cabinet/evento/category/edit/now/130" data-categoryid="130">
    let categoryId;
    if (current.hasAttribute('data-categoryid')){
        categoryId = current.getAttribute('data-categoryid');
    }

    if (categoryId){
        getCategoryXhr(categoryId);
    }

    return false;
}

/// ################################################
//  start --- add category for evento
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

function getUserCategories() {
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

function getCategories() {
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
//  end --- add category for evento
/// ################################################

/// ################################################
// category delete links
function deleteCategoryForCrud() {
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
        categoryAddEditButtonCatch();
    }
}

function getUserTags() {
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

function findTokenFunction(){
    if (findToken){
        if (findToken.hasAttribute('content')){
            token = findToken.getAttribute('content');
        }
    }
}

function addCategoryModalFunction(){
    // сохранение категории для Евенто, не просто для категории
    if (addCategoryModal){
        myAddCategoryModal = new bootstrap.Modal(document.getElementById('add-category-modal'), {keyboard: false});

        addCategoryModal.addEventListener('shown.bs.modal', function (e)
        {
            console.log('+ for category modal');

            // +plus category pressed!
            getCategories();
            getUserCategories();
            showCategoryAddSuccessMessage();
            hideCategoryAddSuccessMessage();
        });
    }
}

// сохранение тега для Евенто, не просто для категории
function addTagModalFunction() {
    if (addTagModal){
        myAddTagModal = new bootstrap.Modal(document.getElementById('add-tag-modal'), {keyboard: false});

        addTagModal.addEventListener('shown.bs.modal', function (e)
        {
            console.log('+ for tag modal');

            // +plus tag pressed!
            addEventoTagForm.reset();

            if (resultMessageInnerForStandaloneTag){
                resultMessageInnerForStandaloneTag.classList.add('d-none');
            }
            getUserTags();
            getTags();
        });
    }
}

// сохранение категории - перехват сабмита и отправка xhr запроса.
function addCategoryFormFunction() {
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
                                let need_tr = document.querySelector('tr[data-evento-id="'+currentEventoId+'"] .category_td .categories_wrapper');
                                let delete_link_div_wrapper = rs['eventoCategoryDiv'];

                                need_tr.innerHTML =  need_tr.innerHTML + delete_link_div_wrapper;

                                deleteEventoCategoryAddHandler();

                                //myAddCategoryModal.hide();
                            }
                        }
                    });
                    request.send(params);
                }
            }

            return false;
        };
    }
}

// сохранение тега (+значение) - перехват сабмита и отправка xhr запроса.
function addEventoTagFormFunction(){
    if (addEventoTagForm) {
        addEventoTagForm.onsubmit = function (e) {
            let tagsSelect = document.querySelector('form[name=addEventoTagForm] select[name=tags]');
            if (tagsSelect && tagsSelect.selectedOptions.length){
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

                var addTagData = '&evento_id=' + currentEventoId + '&tag_id=' + tagId + '&value=' + tagValue.value + '&caption=' + tagCaption.value;

                // xhr
                const url = "/cabinet/evento/eventotag/store_ajax/";
                const params = "_token=" + token + addTagData;
                const request = new XMLHttpRequest();
                request.open("POST", url);
                request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                request.addEventListener("readystatechange", () => {
                    if(request.readyState === 4 && request.status === 200) {
                        let rs = JSON.parse(request.responseText);

                        if (rs['success']){
                            let need_tr = document.querySelector('tr[data-evento-id="'+currentEventoId+'"] .tag_td .tags_wrapper');

                            need_tr.innerHTML = need_tr.innerHTML + rs['eventoTagDiv'];

                            deleteEventoTagAddHandler();

                            //myAddTagModal.hide();
                        }
                    }
                });
                request.send(params);
            }

            return false;
        };
    }
}

function deleteEventoCategoryAddHandler() {
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

function deleteEventoTagAddHandler() {
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

/* ################################################
 * scripts for all delete buttons for confirmed them
 */
function deleteItemAFunction(){
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
}

function openDeactivateDialogFunction(){
    if (openDeactivateDialog){
        openDeactivateDialog.addEventListener('click', dialogOpenBtnHandler)
    }
}

function cancelBtnFunction() {
    if (cancelBtn){
        cancelBtn.addEventListener('click', dialogCloseBtnHandler);
    }
}

function closeMainDialogOnDarkSideFunction() {
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
function eventoDeleteLinksFunction() {
    if (eventoDeleteLinks.length){
        for(let i=0; i<eventoDeleteLinks.length; i++){
            eventoDeleteLinks[i].onclick = function (e) {

                if (!confirm(deleteEventoMessage)){
                    return false;
                }

                let href = e.currentTarget;
                //conlog(href);
                if (href.hasAttribute('href')){
                    let str = href.getAttribute('href');
                    //let str = "http://laravel-events:86/cabinet/evento/destroy/91";
                    let pattern = /destroy\/(\d+)$/;
                    let result = str.match(pattern);
                    if (result){
                        //conlog(result[1]);
                        eventoDeleteAjax(result[1]);
                    }
                }

                return false;
            };
        }
    }
}

function addStandAloneCategoryBtnFindClick(e) {
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

            categoryAddEditButtonCatch();
        }
    });
    categoryAddRequest.send(categoryAddRequestParams);

    return false;
}

// #### add standalone category
function addStandAloneCategoryBtnFindFunction() {
    if (addStandAloneCategoryBtnFind){
        addStandAloneCategoryBtnFind.onclick = addStandAloneCategoryBtnFindClick;
    }
}
// #### END

// ### show/hide && wait/hide CategoryAddSuccessMessage
function hideCategoryAddSuccessMessage() {
    if (resultMessageInnerForStandaloneCategory){
        resultMessageInnerForStandaloneCategory.classList.add('d-none');
    }
}
function showCategoryAddSuccessMessage() {
    if (resultMessageInnerForStandaloneCategory){
        resultMessageInnerForStandaloneCategory.classList.remove('d-none');
    }
}
function waitAndHideCategoryAddSuccessMessage(time=2000) {
    setTimeout(hideCategoryAddSuccessMessage, time);
}

// todo - its here!
function changeCategoryCrudHandlerAjax(categoryId, name) {
    const requestUrl = "/cabinet/evento/category/edit_category/"+categoryId;
    const params = "_token=" + token + '&name=' + name + '&parent_id=' + 0 + '&color=' + '#ccc';

    const xhr = new XMLHttpRequest();
    xhr.open("POST", requestUrl);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.addEventListener("readystatechange", () => {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let rs = JSON.parse(xhr.responseText);
            if (rs['success']){

                let nameHtml = document.querySelector('.add-category--tr_id-'+rs['categoryId']+ ' .add-category-crud--name-field .text');

                nameHtml.innerHTML = rs['name'];

                changeAllCategorysByName(editCategoryInputText, rs['name']);

                getUserCategories();
            }
        }
    });
    xhr.send(params);
}

function changeAllCategorysByName(oldName, newName) {
    let allCatsSelector = 'span[class=categoryNameText][data-textValue="'+oldName+'"]';
    let allCats = document.querySelectorAll(allCatsSelector);

    if (allCats){
        for(let i=0; i<allCats.length; i++){
            allCats[i].innerHTML = newName;
            allCats[i].setAttribute('data-textValue', newName);
        }
    }
}

// #### add standalone tag
function addStandaloneTagFormFunction() {
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
}
// сохранение тега (+его цвет) - перехват сабмита и отправка xhr запроса.
// #### END

// ### show/hide && wait/hide CategoryAddSuccessMessage
function hideTagAddSuccessMessage() {
    if (resultMessageInnerForStandaloneTag){
        resultMessageInnerForStandaloneTag.classList.add('d-none');
    }
}
function showTagAddSuccessMessage() {
    if (resultMessageInnerForStandaloneTag){
        resultMessageInnerForStandaloneTag.classList.remove('d-none');
        resultMessageInnerForStandaloneTag.classList.remove('text-danger');
        resultMessageInnerForStandaloneTag.classList.add('text-success');
    }
}
function waitAndHideTagAddSuccessMessage(time=2000) {
    setTimeout(hideTagAddSuccessMessage, time);
}

////////////////
function getTags() {
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

                tagEditLinksHandler();
            }
        }
    });
    request.send(params);
}

// tag delete links
function deleteTagForCrud() {
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
    }
}

// ########################################
// загрузка файлов через js, /attachment
// start
function insertAttachments(html, eventoId){
    let attachments = document.querySelector('.eventos_table tbody tr[data-evento-id="'+eventoId+'"] .attachments');
    if (attachments){
        attachments.innerHTML = html;
    }
}

function storeAttachmentAjax(formData) {
    let url = "/cabinet/evento/attachment/store_ajax/";
    //url = "../js_handler.php";
    const xhr = new XMLHttpRequest();
    xhr.open("POST", url);

    //xhr.setRequestHeader("Content-Type", "multipart/form-data");
    //xhr.setRequestHeader("Content-type","multipart/form-data; charset=utf-8; boundary=" + Math.random().toString().substr(2));

    xhr.addEventListener("readystatechange", () => {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let rs = JSON.parse(xhr.responseText);
            if (rs['success']){
                addAttachmentModal.hide();
                insertAttachments(rs['attachments'], rs['eventoId']);
                addHandlerForAttachmentDelete();
            }else{
                // catch error and show that
            }
        }
    });

    xhr.send(formData);
}

function storeAttachmentHandler(href, evento_id){
    //
    let form = document.querySelector('form[name=addAttachmentForm]');
    if (form){
        form.onsubmit = function () {
            //conlog('submit is done!');

            let addAttachmentForm = document.querySelector('form[name=addAttachmentForm]');
            if (addAttachmentForm){

                let input_evento_id = addAttachmentForm.querySelector('input[name=evento_id]');
                if (input_evento_id){
                    input_evento_id.value = evento_id;
                }

                let input_token = addAttachmentForm.querySelector('input[name=_token]');
                if (input_token){
                    input_token.value = token;
                }

                let formData = new FormData(addAttachmentForm);

                let file = form.querySelector('input[type=file]');
                if (file && file.files.length){
                    formData.append('file', file.files[0]);
                }

                storeAttachmentAjax(formData);
            }

            return false;
        }
    }

}

function storeAttachment(e) {

    //let href = e.target.parentElement.getAttribute('href');
    //let evento_id = e.target.parentElement.getAttribute('data-evento-id');

    let href = e.currentTarget.getAttribute('href');
    let evento_id = e.currentTarget.getAttribute('data-evento-id');

    // main
    storeAttachmentHandler(href, evento_id);

    return false;
}

function addHandlerForAttachmentsStoreButton() {
    let a = document.querySelectorAll('a.attachment_store_ajax');
    if (a && a.length){
        for(let i=0; i<a.length; i++){
            a[i].onclick = storeAttachment;
        }
    }
}

// загрузка файлов через js, /attachment
// end
// ##########################################

// ########################################
// удаление файлов через js ---> /attachment/delete
// start
// attachment_delete
function addHandlerForAttachmentDelete() {
    let a = document.querySelectorAll('a.attachment_delete');
    if (a && a.length){
        for(let i=0; i<a.length; i++){
            a[i].onclick = deleteAttachmentHandler;
        }
    }
}

function deleteAttachmentHandler(e) {

    let href = e.target.getAttribute('href');
    let evento_id = e.target.getAttribute('data-eventoId');
    let attachment_id = e.target.getAttribute('data-attachmentId');

    // main
    //conlog(attachment_id);

    deleteAttachment(attachment_id);

    return false;
}

function deleteAttachment(attachment_id) {
    let url = "/cabinet/evento/attachment/destroyAjax/"+attachment_id;
    const xhr = new XMLHttpRequest();
    const params = "_token=" + token;

    xhr.open("POST", url);

    //xhr.setRequestHeader("Content-Type", "multipart/form-data");
    //xhr.setRequestHeader("Content-type","multipart/form-data; charset=utf-8; boundary=" + Math.random().toString().substr(2));
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.addEventListener("readystatechange", () => {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let rs = JSON.parse(xhr.responseText);
            if (rs['success']) {
                // get new attachments and insert HTML
                getAttachmentById(rs['evento_id']);
            }
        }
    });
    xhr.send(params);
}
// удаление файлов через js ---> /attachment/delete
// end
// ########################################

function getAttachmentById(evento_id) {
    const xhr = new XMLHttpRequest();
    let url = "/cabinet/evento/attachment/getAttachmentsByEventoId/?evento_id="+evento_id;

    xhr.open("get", url);

    //xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    //xhr.setRequestHeader("Content-type", "application/json");
    //xhr.setRequestHeader("Content-Type", "multipart/form-data");
    //xhr.setRequestHeader("Content-type","multipart/form-data; charset=utf-8; boundary=" + Math.random().toString().substr(2));

    xhr.addEventListener("readystatechange", () => {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let rs = JSON.parse(xhr.responseText);
            if (rs['success']) {
                insertAttachments(rs['attachments'], evento_id);
            }
        }
    });

    xhr.send();
}

/////////////////////////////////////
// start
// add_evento
function create_evento_xhr(params) {
    let url = "/cabinet/evento/store_ajax/";
    const xhr = new XMLHttpRequest();

    xhr.open("POST", url);

    // hide spinMessage__*
    // show spin
    let spinWrapper = spinMessage__getScopeClass('.eventoStore__wrapper');
    spinMessage__hide(spinWrapper);
    spinMessage__showSpin(spinWrapper);

    xhr.addEventListener("readystatechange", () => {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let rs = JSON.parse(xhr.responseText);

            let spinWrapper = spinMessage__getScopeClass('.eventoStore__wrapper');
            spinMessage__hideSpin(spinWrapper);

            if (rs['success']) {

                var eventos_table_tr = document.querySelector('.eventos_table tbody tr');
                if (eventos_table_tr){
                    let tr = document.createElement('tr');
                    let td = document.createElement('td');
                    td.innerHTML = "Anather test td inner!";

                    tr.appendChild(td);
                    tr.innerHTML = rs['eventoHtml'];
                    tr.setAttribute('data-evento-id', rs['eventoId']);

                    eventos_table_tr.before(tr);
                }
                eventoDeleteLinks = document.querySelectorAll('.evento_delete');

                // for delete
                eventoDeleteLinksFunction();
                // for attachments
                addHandlerForAttachmentsStoreButton();
                // for edit
                eventoEditAjaxHanlder();
                // for show
                eventoGetAjaxHanlder();

                addEventoModal.hide();

                // required
                // functionsInitialStart(); // ?
                saveCurrentDataEventoId();
            }
            spinMessage__setClassForMessageHandler(spinWrapper, rs['success']);
            spinMessage__setMessage(spinWrapper, rs['message']);
            spinMessage__showMessage(spinWrapper);
        }
    });

    xhr.addEventListener("progress", () => {
        eventoStoreWrapper__hideSpin();
    });
    xhr.addEventListener("load", () => {
        eventoStoreWrapper__hideSpin();
    });
    xhr.addEventListener("error", () => {
        eventoStoreWrapper__hideSpin();
    });
    xhr.addEventListener("abort", () => {
        eventoStoreWrapper__hideSpin();
    });

    xhr.send(params);
}
function eventoStoreWrapper__hideSpin() {
    let spinWrapper = document.querySelector('.eventoStore__wrapper');
    spinMessage__hideSpin(spinWrapper);
}

function create_evento__handler(e, form){

    let formData = new FormData(form);

    formData.append('_token', token);

    //conlog('description: '+formData.get('description'));
    //conlog('date: '+formData.get('date'));

    create_evento_xhr(formData);
}

function create_evento__submit(){
    var form = document.querySelector('form[name=addEventoForm]');
    if (form) {
        form.onsubmit = function (e) {

            create_evento__handler(e, form);

            return false;
        }
    }
}
// end
// add_evento
/////////////////////////////////////

function eventoDeleteAjax(eventoId){

    let url = "/cabinet/evento/destroy_ajax/"+eventoId;
    const xhr = new XMLHttpRequest();

    xhr.open("get", url);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.addEventListener("readystatechange", () => {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let rs = JSON.parse(xhr.responseText);
            if (rs['success']) {
                // delete row with old eventoId
                let eventoId = rs['eventoId'];
                let tr = document.querySelector("tr[data-evento-id='"+eventoId+"']");
                if (tr){
                    tr.remove();
                }
            }
        }
    });
    xhr.send();
}

function setFlatpickrInstances(){
    flatpickr(".flatpickrEventoCreateDate");
    flatpickr(".flatpickrEventoEditDate");
}

function eventoGetAjaxHanlder(){
    let selector = document.querySelectorAll('.evento_get_ajax');
    if (selector && selector.length){
        for (let i=0; i<selector.length; i++){
            selector[i].onclick = eventoGetAjax;
        }
    }
}
function eventoGetAjax(e){

    let current = e.currentTarget;
    if (current.hasAttribute('href')){
        let href = current.getAttribute('href');
        let pattern = /show\/(\d+)$/;
        let result = href.match(pattern);
        if (result){
            eventoGetAjaxXhr(result[1]);
        }
    }

    return false;
}
function eventoGetAjaxXhr(eventoId){
    let url = "/cabinet/evento/get_ajax/"+eventoId;
    const xhr = new XMLHttpRequest();

    xhr.open("get", url);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.addEventListener("readystatechange", () => {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let rs = JSON.parse(xhr.responseText);
            if (rs['success']) {
                eventoShowModal.show();
                // #show-evento-modal .modal-body
                let body = document.querySelector('#show-evento-modal .modal-body');
                body.innerHTML = "";
                if (body){
                    let div = document.createElement('div');
                    let eventoTable = document.createElement('table');
                    let eventoButtons = document.createElement('div');
                    eventoTable.innerHTML = rs['htmlEventoTable'];
                    eventoTable.setAttribute('class', rs['eventoTableClass']);
                    eventoButtons.innerHTML = rs['htmlEventoEditDeleteButtons'];
                    div.appendChild(eventoTable);
                    div.appendChild(eventoButtons);
                    body.appendChild(div);

                    // for delete button
                    deleteShowedWithAjaxEventoButtonClick();
                    // for edit button
                    eventoEditAjaxHanlder();
                    // for new button
                    editAjaxCreateNewButtonHandler();
                }
            }
        }
    });
    xhr.send();
}

function deleteShowedWithAjaxEventoButtonClick() {
    let a = document.querySelectorAll('.deleteShowedWithAjaxEventoButton');
    if (a && a.length){
        for(let i=0; i<a.length; i++){
            a[i].onclick =  deleteShowedWithAjaxEventoButtonHandler;
        }
    }
}
function deleteShowedWithAjaxEventoButtonHandler(e) {
    if (!confirm(deleteEventoMessage)){
        return false;
    }

    // close old showed evento modal
    closeAllEventoModals();

    let current = e.currentTarget;
    if (current.hasAttribute('href')){
        let href = current.getAttribute('href');
        let pattern = /destroy\/(\d+)$/;
        let result = href.match(pattern);
        if (result){
            eventoDeleteAjax(result[1]);
        }
    }
    return false;
}

function eventoEditAjaxHanlder() {
    let selector = document.querySelectorAll('.evento_edit_ajax');
    if (selector && selector.length){
        for (let i=0; i<selector.length; i++){
            selector[i].onclick = eventoEditAjax;
        }
    }
}
function eventoEditAjax(e) {
    closeAllEventoModals();
    let current = e.currentTarget;
    if (current.hasAttribute('href')){
        let href = current.getAttribute('href');
        let pattern = /edit\/(\d+)$/;
        let result = href.match(pattern);
        if (result){
            eventoEditAjaxXhr(result[1]);
        }
    }

    return false;
}
function eventoEditAjaxXhr(eventoId) {
    let url = "/cabinet/evento/edit_ajax/"+eventoId;
    const xhr = new XMLHttpRequest();

    xhr.open("get", url);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.addEventListener("readystatechange", () => {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let rs = JSON.parse(xhr.responseText);
            if (rs['success']) {
                eventoEditModal.show();
                let body = document.querySelector('#edit-evento-modal .modal-body');
                if (body){
                    body.innerHTML = "";
                    let div = document.createElement('div');
                    let eventoTable = document.createElement('form');
                    eventoTable.innerHTML = rs['eventoEditTable'];
                    eventoTable.setAttribute('action', rs['action']);
                    eventoTable.setAttribute('enctype', rs['enctype']);
                    eventoTable.setAttribute('method', rs['method']);
                    div.appendChild(eventoTable);
                    body.appendChild(div);

                    // reinit flatpickr
                    setFlatpickrInstances();

                    // for delete button
                    deleteShowedWithAjaxEventoButtonClick();
                    // for new button
                    editAjaxCreateNewButtonHandler();
                    // for save button
                    saveEditedEventoAjaxButtonHandler();
                }
            }
        }
    });
    xhr.send();
}

function editAjaxCreateNewButtonHandler() {
    let btns = document.querySelectorAll('.editEventoCreateNewButton');
    if (btns && btns.length){
        for(let i=0; i<btns.length; i++){
            btns[i].onclick = function (e) {
                closeAllEventoModals();
                createNewEventoButtonClick();
                return false;
            }
        }
    }
}
function createNewEventoButtonClick(){
    let a = document.querySelector('.js_create_evento');
    if (a){
        a.click();
    }
}

function updateEventXhr_startAnimation(spin, message) {
    if (spin){
        spin.classList.remove('d-none');
    }
    message.classList.add('d-none');
    let successDanger = message.querySelector('.text-danger');
    successDanger.innerHTML = "Fail!";
    successDanger.classList.add('d-none');

    let successMessage = message.querySelector('.text-success');
    successMessage.classList.add('d-none');
    successMessage.innerHTML = "Success!";
}
function updateEventXhr_stopAnimation(spin) {
    if (spin){
        spin.classList.add('d-none');
    }
}
function updateEventoAjaxXhr(eventoId, description, date) {
    let url = "/cabinet/evento/update_ajax/"+eventoId;
    const xhr = new XMLHttpRequest();
    let params = "_token=" + token + '&description='+description+'&date='+date;

    xhr.open("post", url);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    let spinWrapper = spinMessage__getScopeClass('.eventoEdit__wrapper');
    spinMessage__hide(spinWrapper);
    spinMessage__showSpin(spinWrapper);

    xhr.addEventListener("readystatechange", () => {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let rs = JSON.parse(xhr.responseText);
            spinMessage__hideSpin(spinWrapper);

            //eventoEditAjaxXhr(rs['eventoId']); // после обновить содержимое формы

            if (rs['success']){
                var eventoTr = document.querySelector('.eventos_table tbody tr[data-evento-id="'+rs['eventoId']+'"]');
                if (eventoTr){
                    let tr = document.createElement('tr');
                    tr.innerHTML = rs['eventoHtml'];
                    tr.setAttribute('data-evento-id', rs['eventoId']);
                    eventoTr.before(tr);
                    eventoTr.remove();
                }
                eventoDeleteLinks = document.querySelectorAll('.evento_delete');

                // for delete
                eventoDeleteLinksFunction();
                // for attachments
                addHandlerForAttachmentsStoreButton();
                // for edit
                eventoEditAjaxHanlder();
                // for show
                eventoGetAjaxHanlder();
                // for new button
                editAjaxCreateNewButtonHandler();

                saveCurrentDataEventoId();
            }else{
                // restore old data
                let description = document.querySelector('#edit-evento-modal textarea[name="description"]');
                let date = document.querySelector('#edit-evento-modal input[name="date"]');
                if (description){
                    description.value = rs['description'];
                }
                if (date){
                    date.value = rs['date'];
                }
            }

            spinMessage__setClassForMessageHandler(spinWrapper, rs['success']);
            spinMessage__setMessage(spinWrapper, rs['message']);
            spinMessage__showMessage(spinWrapper);
        }
    });

    xhr.addEventListener("progress", () => {
        eventoEditWrapper__hideSpin();
    });
    xhr.addEventListener("load", () => {
        eventoEditWrapper__hideSpin();
    });
    xhr.addEventListener("error", () => {
        eventoEditWrapper__hideSpin();
    });
    xhr.addEventListener("abort", () => {
        eventoEditWrapper__hideSpin();
    });

    xhr.send(params);
}
function eventoEditWrapper__hideSpin() {
    let spinWrapper = spinMessage__getScopeClass('.eventoEdit__wrapper');
    spinMessage__hideSpin(spinWrapper);
}
function saveEditedEventoAjaxButtonHandler() {
    let btn = document.querySelector('.saveEditedEventoAjaxButton');
    if (btn){
        btn.onclick = function (e) {
            let current = e.target.parentElement.parentElement.parentElement.parentElement;
            if (current.hasAttribute('action')){
                let href = current.getAttribute('action');
                let pattern = /update\/(\d+)$/;
                let result = href.match(pattern);
                if (result){
                    // get description, and date
                    let description = current.querySelector('textarea');
                    let date = current.querySelector('input');
                    let descriptionValue = "";
                    let dateValue = "";
                    if (description){
                        descriptionValue = description.value;
                    }
                    if (date){
                        dateValue = date.value;
                    }
                    let dd = document.querySelector('#date');
                    if (dd){
                        dateValue = dd.value;
                    }
                    //conlog(descriptionValue);
                    //conlog(dateValue);

                    updateEventoAjaxXhr(result[1], descriptionValue, dateValue);
                }
            }

            return false;
        }
    }
}

function closeAllEventoModals(){
    eventoShowModal.hide();
    eventoEditModal.hide();
}

function tagEditLinksHandler() {
    let tag_edit_links = document.querySelectorAll('.tag-crud__edit-link');
    if (tag_edit_links && tag_edit_links.length){
        for(let i=0; i<tag_edit_links.length; i++){
            tag_edit_links[i].onclick = tagEditLinkPressed;
        }
    }
}
function tagEditLinkPressed(e) {
    let link  = e.currentTarget;
    let tagId = null;
    if (link.hasAttribute('data-tagId')){
        tagId = link.getAttribute('data-tagId');

        // 1. get tag data with current id
        tagEditLink__mainWork(tagId);
    }

    return false;
}

function tagEditLink__mainWork(tagId) {
    getTagXhr(tagId);
}
function getTagXhr(tagId){
    let url = "/cabinet/evento/tag/get_ajax/"+tagId;
    const xhr = new XMLHttpRequest();

    xhr.open("get", url);
    //xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.addEventListener("readystatechange", () => {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let rs = JSON.parse(xhr.responseText);
            if (rs['success']) {

                spinMessages__startingHide();

                if (tagEditModal){
                    let modal = document.getElementById('edit-tag-modal');
                    let name = modal.querySelector('form input[name="name"]');
                    let color = modal.querySelector('form input[name="color"]');
                    if (modal && name && color){
                        name.value = rs['tag']['name'];
                        color.value = rs['tag']['color'];

                        let form = modal.querySelector('form');
                        if (form){
                            let findHiddenInput = form.querySelector('input[name="tagId"]');
                            if (findHiddenInput){
                                findHiddenInput.setAttribute('value', rs['tag']['id']);
                            }else{
                                let hiddenInputTagId = document.createElement('input');
                                hiddenInputTagId.setAttribute('name', 'tagId');
                                hiddenInputTagId.setAttribute('type', 'hidden');
                                hiddenInputTagId.setAttribute('value', rs['tag']['id']);
                                form.appendChild(hiddenInputTagId);
                            }
                        }
                    }
                    tagEditModal.show();
                }
            }
        }
    });
    xhr.send();
}

function editTagFormHandler() {
    let form = document.querySelector('form[name="editTagForm"]');
    if (form){
        form.onsubmit = editTagFormHandle;
    }
}
function editTagFormHandle(e) {
    let formData = new FormData(e.currentTarget);

    editTagXhr(formData);

    return false;
}
function editTagXhr(formData) {
    const url = "/cabinet/evento/tag/update_ajax/"+formData.get('tagId');
    if (!formData.has('_token')){
        formData.append('_token', token)
    }else{
        formData.set('_token', token);
    }

    const xhr = new XMLHttpRequest();
    xhr.open("POST", url);

    // hide spinMessage__*
    // show spin
    let spinWrapper = spinMessage__getScopeClass('.tagEdit__wrapper');
    spinMessage__hide(spinWrapper);
    spinMessage__showSpin(spinWrapper);

    xhr.addEventListener("readystatechange", () => {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let rs = JSON.parse(xhr.responseText);
            spinMessage__hideSpin(spinWrapper);

            if (rs['success']) {
                let tr = document.querySelector('.add-tag--tr_id-'+rs['tag']['id']);
                if (tr){
                    let dataName = tr.querySelector('[data-name]');
                    let dataColor = tr.querySelector('[data-color]');
                    if (tr && dataName) {
                        dataName.innerHTML = rs['tag']['name'];
                    }
                    if (tr && dataColor){
                        dataColor.innerHTML = rs['tag']['color'];
                    }
                }
                // update tag caption && color
                editTagsInEventoRowTagsColumns(rs['tag']['id'], rs['tag']['name'], rs['tag']['color']);
            }else{
                let modal = document.getElementById('edit-tag-modal');
                let name = modal.querySelector('form input[name="name"]');
                let color = modal.querySelector('form input[name="color"]');
                if (modal && name && color){
                    name.value = rs['oldTag']['name'];
                    color.value = rs['oldTag']['color'];
                }
            }
            spinMessage__setClassForMessageHandler(spinWrapper, rs['success']);
            spinMessage__setMessage(spinWrapper, rs['message']);
            spinMessage__showMessage(spinWrapper);
        }
    });

    xhr.send(formData);

    xhr.addEventListener("progress", () => {
        tagEditWrapper__hideSpin();
    });
    xhr.addEventListener("load", () => {
        tagEditWrapper__hideSpin();
    });
    xhr.addEventListener("error", () => {
        tagEditWrapper__hideSpin();
    });
    xhr.addEventListener("abort", () => {
        tagEditWrapper__hideSpin();
    });
}
function tagEditWrapper__hideSpin() {
    let spinWrapper = spinMessage__getScopeClass('.tagEdit__wrapper');
    spinMessage__hideSpin(spinWrapper);
}
function editTagsInEventoRowTagsColumns(eventotag_id, name, color) {
    let eventotags =  document.querySelectorAll('.tags_wrapper [data-tagid="'+eventotag_id+'"]');
    if (eventotags && eventotags.length){
        for(let i=0; i<eventotags.length; i++){
            // > button style="background-color: #f6c417; border-color: #f6c417;"
            // > button .eventotag_name
            let button = eventotags[i].querySelector('button');
            if (button){
                button.setAttribute('style', "background-color: "+color+"; border-color: "+color+";");
                let eventotag_name = button.querySelector('.eventotag_name');
                if (eventotag_name){
                    eventotag_name.innerHTML = name;
                }
            }
        }
    }

}
function editCategoriesInEventoRowCategoriesColumns(category_id, name, color) {
    conlog('editCategoriesInEventoRowCategoriesColumns: '+category_id);
    let categories = document.querySelectorAll('.categories_wrapper [data-categoryId="'+category_id+'"]');
    if (categories && categories.length){
        for(let i=0; i<categories.length; i++){
            let categoryName = categories[i].querySelector('.categoryNameText');
            if (categoryName){
                categoryName.innerHTML = name;
            }
        }
    }

}

// #############################################
// spin_message --- hide/show for all modal/etc
// start
function spinMessage__getScopeClass(className) {
    let spinWrapper = document.querySelector('.spinMessage__wrapper'+className); // .eventoStore__wrapper
    return spinWrapper;
}
function spinMessage__hide(wrapper) {
    spinMessage__hideSpin(wrapper);
    spinMessage__hideMessage(wrapper);
}
function spinMessage__show(wrapper) {
    spinMessage__showSpin(wrapper);
    spinMessage__showMessage(wrapper);
}
function spinMessage__showSpin(wrapper){
    if (wrapper){
        let spin = wrapper.querySelector('svg.svg');
        if (spin){
            spin.classList.remove('d-none');
        }
    }
}
function spinMessage__hideSpin(wrapper){
    if (wrapper){
        let spin = wrapper.querySelector('svg.svg');
        if (spin){
            spin.classList.add('d-none');
        }
    }
}
function spinMessage__showMessage(wrapper,addit_class_name=''){
    if (wrapper){
        let selector = 'span.message';
        if (addit_class_name){
            selector += '.' + addit_class_name;
        }
        let message = wrapper.querySelector(selector);

        if (message){
            message.classList.remove('d-none');
        }
    }
}
function spinMessage__hideMessage(wrapper){
    if (wrapper){
        let message = wrapper.querySelector('span.message');
        if (message){
            message.classList.add('d-none');
        }
    }
}
function spinMessage__setMessage(wrapper, messageText) {
    if (wrapper){
        let message = wrapper.querySelector('span.message');
        if (message){
            message.innerHTML = messageText;
        }
    }
}
function spinMessages__startingHide() {
    let spinWrappers = document.querySelectorAll('.spinMessage__wrapper');
    if (spinWrappers && spinWrappers.length){
        for(let i=0; i<spinWrappers.length; i++){
            spinMessage__hide(spinWrappers[i]);
        }
    }
}
function spinMessage__setClassForMessageHandler(wrapper, rs_success) {
    let className = 'text-danger';
    if (rs_success){
        className = 'text-success';
    }
    spinMessage__setClassForMessage(wrapper, className);
}
function spinMessage__setClassForMessage(wrapper, className){
    if (wrapper){
        spinMessage__clearMessageClasses(wrapper);
        let message = wrapper.querySelector('span.message');
        if (message){
            message.classList.add(className);
        }
    }
}
function spinMessage__clearMessageClasses(wrapper){
    let classList = classListFor__spinMessage;
    if (wrapper){
        let message = wrapper.querySelector('span.message');
        if (message){
            for (let i=0; i<classList.length; i++){
                message.classList.remove(classList[i]);
            }
        }
    }
}
// end
// spin_message --- hide/show for all modal/etc
// #############################################

function editCategoryFormHandler() {
    let form = document.querySelector('form[name="editCategoryForm"]');
    if (form){
        form.onsubmit = function (e) {
            conlog('editCategoryFormHandler');

            let formData = new FormData(e.currentTarget);

            //editTagXhr(formData);
            editCategoryXhr(formData);

            return false;
        }
    }
}

function getCategoryXhr(categoryId){
    let url = "/cabinet/evento/category/get_ajax/"+categoryId;
    const xhr = new XMLHttpRequest();

    xhr.open("get", url);

    xhr.addEventListener("readystatechange", () => {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let rs = JSON.parse(xhr.responseText);
            if (rs['success']) {

                spinMessages__startingHide();

                // todo - last
                if (categoryEditModal){
                    let modal = categoryEditId;
                    let name = modal.querySelector('form input[name="name"]');
                    let img = modal.querySelector('form input[name="img"]');
                    if (modal && name && img){
                        name.value = rs['category']['name'];
                        img.value = rs['category']['img'];

                        let form = modal.querySelector('form');
                        if (form){
                            let categoryFieldName = 'categoryId';
                            let categoryId = rs['category']['id'];

                            let findHiddenInput = form.querySelector(`input[name="${categoryFieldName}"]`);
                            if (findHiddenInput){
                                findHiddenInput.setAttribute('value', categoryId);
                            }else{
                                let hiddenInput = document.createElement('input');
                                hiddenInput.setAttribute('name', categoryFieldName);
                                hiddenInput.setAttribute('type', 'hidden');
                                hiddenInput.setAttribute('value', categoryId);
                                form.appendChild(hiddenInput);
                            }
                        }
                    }
                    categoryEditModal.show();
                }
            }
        }
    });
    xhr.send();
}

function editCategoryXhr(formData) {
    const url = "/cabinet/evento/category/update_ajax/"+formData.get('categoryId');
    if (!formData.has('_token')){
        formData.append('_token', token)
    }else{
        formData.set('_token', token);
    }

    const xhr = new XMLHttpRequest();
    xhr.open("POST", url);

    // hide spinMessage__*
    // show spin
    let spinWrapper = spinMessage__getScopeClass('.categoryEdit__wrapper');
    spinMessage__hide(spinWrapper);
    spinMessage__showSpin(spinWrapper);

    xhr.addEventListener("readystatechange", () => {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let rs = JSON.parse(xhr.responseText);
            spinMessage__hideSpin(spinWrapper);

            if (rs['success']) {
                let rsn = rs['category'];

                // update category crud table
                getCategories();
                // update eventocategory table
                getUserCategories();

                // update category caption && img in all category rows
                editCategoriesInEventoRowCategoriesColumns(rsn['id'], rsn['name'], rsn['img']);
            }else{
                let modal = categoryEditId;
                let name = modal.querySelector('form input[name="name"]');
                let img = modal.querySelector('form input[name="img"]');
                if (modal && name && img){
                    name.value = rs['oldCategory']['name'];
                    img.value = rs['oldCategory']['img'];
                }
            }

            spinMessage__setClassForMessageHandler(spinWrapper, rs['success']);
            spinMessage__setMessage(spinWrapper, rs['message']);
            spinMessage__showMessage(spinWrapper);
        }
    });

    xhr.send(formData);

    xhr.addEventListener("progress", () => {
        categoryEditWrapper__hideSpin();
    });
    xhr.addEventListener("load", () => {
        categoryEditWrapper__hideSpin();
    });
    xhr.addEventListener("error", () => {
        categoryEditWrapper__hideSpin();
    });
    xhr.addEventListener("abort", () => {
        categoryEditWrapper__hideSpin();
    });
}
function categoryEditWrapper__hideSpin() {
    let spinWrapper = spinMessage__getScopeClass('.categoryEdit__wrapper');
    spinMessage__hideSpin(spinWrapper);
};

function tagValuesPieDiagrammSvgXhr(formData) {
    const url = "/cabinet/evento/eventotagcounting/get_pie_ajax/";

    const xhr = new XMLHttpRequest();
    xhr.open("GET", url);

    xhr.addEventListener("readystatechange", () => {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let rs = JSON.parse(xhr.responseText);

            if (rs['success']){

                let pie = rs['pie'];
                var tagValues = {};
                var tagColors = [];
                for(let i=0; i<pie.length; i++){
                    tagValues[pie[i]['tag_name']] = +pie[i]['tag_value'];
                    tagColors.push(pie[i]['tag_color']);
                }

                // tagValues = {
                //     "BeeLine": 15640,
                //     "Megafon": 5350,
                //     "Rostelecom":4700,
                //     "доход": 16600,
                //     "расход": 34800,
                // };
                // conlog(tagValues);

                var tagValuesDiagramm = new Piechart({
                    canvas: pieDiagrammCanvas,
                    data:   tagValues,
                    colors: tagColors,
                    legend: pieDiagrammLegend,
                    //doughnutHoleSize:0.5,
                });

                tagValuesDiagramm.draw();
                tagvaluesPieDiagrammModal.show();

                let yearsSelect = document.querySelector('.getPieDiagrammByYear__wrapper select[name="year"]');
                let year = +rs['current_year'];
                addYearsAndsetCurrentYearSelectedForPieDiagramm(rs['years'], yearsSelect);
                setOptionSelected(yearsSelect, year);
            }
        }
    });

    xhr.send(formData);
}

function tagValuesPieDiagrammSvgHandler() {
    let btn = document.querySelector('#tagValuesPieDiagrammSvg');
    if (btn){
        btn.onclick = function(e) {
            //conlog('tagValuesPieDiagrammSvgHandler pressed!');

            //
            let formData = new FormData();
            tagValuesPieDiagrammSvgXhr(formData);

            return false;
        }
    }
}

function drawLine(ctx, startX, startY, endX, endY){
    ctx.beginPath();
    ctx.moveTo(startX,startY);
    ctx.lineTo(endX,endY);
    ctx.stroke();
}
function drawArc(ctx, centerX, centerY, radius, startAngle, endAngle){
    ctx.beginPath();
    ctx.arc(centerX, centerY, radius, startAngle, endAngle);
    ctx.stroke();
}
function drawPieSlice(ctx,centerX, centerY, radius, startAngle, endAngle, color ){
    ctx.fillStyle = color;
    ctx.beginPath();
    ctx.moveTo(centerX,centerY);
    ctx.arc(centerX, centerY, radius, startAngle, endAngle);
    ctx.closePath();
    ctx.fill();
}
//drawLine(ctx,100,100,200,200);
//drawArc(ctx, 150,150,150, 0, Math.PI/3);
//drawPieSlice(ctx, 150,150,150, Math.PI/2, Math.PI/2 + Math.PI/4, '#ff0000');

function DiagrammPieByYearFormSubmitHandler() {
    let form = document.querySelector('form[name=DiagrammPieByYear]');
    if (form){
        form.onsubmit = function (e) {

            let formData = new FormData(e.currentTarget);

            getDiagrammPieByYearXhr(formData);

            return false;
        }
    }
}
// todo - refactor this after, explode 2 functions
function addYearsAndsetCurrentYearSelectedForPieDiagramm(data, selector) {
    if (data.length && selector){
        removeOptions(selector);

        // default option
        let option = document.createElement("option");
        option.text = 'Select need year';
        //option.setAttribute('selected', 'selected');
        selector.add(option);

        for (let i = 0; i < data.length; i++) {
            let option = document.createElement("option");
            option.text = data[i]['date'];
            option.value = +data[i]['date'];
            selector.add(option);
        }
    }
}
function setOptionSelected(selector, value) {
    let options = selector.querySelectorAll('option');
    if (options && options.length){
        for (let i = 0; i < options.length; i++) {
            if ( ( options[i].hasAttribute('value') ) &&
                ( (+options[i].getAttribute('value')) ===  value ) ){
                options[i].setAttribute('selected', 'selected');
                break;
            }
        }
    }
}
function getDiagrammPieByYearXhr(formData) {
    let url = "/cabinet/evento/eventotagcounting/get_pie_ajax_by_year/";
    if (formData.has('year')){
        url += formData.get('year');
    }else{
        url += (new Date).getFullYear();
    }

    const xhr = new XMLHttpRequest();
    xhr.open("GET", url);

    // hide spinMessage__*
    // show spin
    let spinWrapper = spinMessage__getScopeClass('.getPieDiagrammByYear__wrapper');
    spinMessage__hide(spinWrapper);
    spinMessage__showSpin(spinWrapper);

    xhr.addEventListener("readystatechange", () => {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let rs = JSON.parse(xhr.responseText);
            if (rs['success']){

                let pie = rs['pie'];
                var tagValues = {};
                var tagColors = [];
                for(let i=0; i<pie.length; i++){
                    tagValues[pie[i]['tag_name']] = +pie[i]['tag_value'];
                    tagColors.push(pie[i]['tag_color']);
                }
                //conlog(tagValues);

                var tagValuesDiagramm = new Piechart({
                    canvas: pieDiagrammCanvas,
                    data:   tagValues,
                    colors: tagColors,
                    legend: pieDiagrammLegend,
                    //doughnutHoleSize:0.5,
                });
                pieDiagrammCanvasContext.clearRect(0, 0, pieDiagrammCanvas.width, pieDiagrammCanvas.height);
                tagValuesDiagramm.draw();
                tagvaluesPieDiagrammModal.show();

                let yearsSelect = document.querySelector('.getPieDiagrammByYear__wrapper select[name="year"]');
                let year = +rs['current_year'];
                addYearsAndsetCurrentYearSelectedForPieDiagramm(rs['years'], yearsSelect);
                setOptionSelected(yearsSelect, year);

                spinMessage__setClassForMessageHandler(spinWrapper, rs['success']);
                spinMessage__setMessage(spinWrapper, rs['message']);
                let none_class = 'none_' + Math.random().toString(36).substring(7);
                spinMessage__showMessage(spinWrapper, none_class);
            }
        }
    });

    xhr.addEventListener("progress", () => {
        getPieDiagrammCategory__hideSpin();
    });
    xhr.addEventListener("load", () => {
        getPieDiagrammCategory__hideSpin();
    });
    xhr.addEventListener("error", () => {
        getPieDiagrammCategory__hideSpin();
    });
    xhr.addEventListener("abort", () => {
        getPieDiagrammCategory__hideSpin();
    });

    xhr.send(formData);
}
function getPieDiagrammCategory__hideSpin() {
    let spinWrapper = spinMessage__getScopeClass('.getPieDiagrammByYear__wrapper');
    spinMessage__hideSpin(spinWrapper);
};

////// gistogramm data - tagValues
// start

function tagValuesMonthGistogrammSvgHandler() {
    let btn = document.querySelector('#tagValuesMonthGistogrammSvg');
    if (btn){
        btn.onclick = function(e) {
            //conlog('tagValuesMonthGistogrammSvg pressed!');

            let formData = new FormData();
            tagValuesMonthGistogrammSvgXhr(formData);

            return false;
        }
    }
}

function tagValuesMonthGistogrammSvgXhr(formData) {
    let url = "/cabinet/evento/eventotagcounting/get_month_gistogramm_by_year_ajax/";

    if (formData.has('year')){
        url += formData.get('year');
    }else{
        url += (new Date).getFullYear();
    }

    const xhr = new XMLHttpRequest();
    xhr.open("GET", url);

    // hide spinMessage__*
    // show spin
    let spinWrapper = spinMessage__getScopeClass('.getMonthDiagrammByYear__wrapper');
    spinMessage__hide(spinWrapper);
    spinMessage__showSpin(spinWrapper);

    xhr.addEventListener("readystatechange", () => {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let rs = JSON.parse(xhr.responseText);

            if (rs['success']){

                tagvaluesMonthDiagrammModal.show();

                let tagValues = {};

                for (let i in rs['gistogramm']){
                    tagValues[i] = {};
                    for (let j in rs['gistogramm'][i]){
                        tagValues[i][j] = {};
                        tagValues[i][j]['value'] = +rs['gistogramm'][i][j]['tag_value'];
                        tagValues[i][j]['color'] =  rs['gistogramm'][i][j]['tag_color'];
                    }
                }
                //conlog(tagValues);
                // tagValues = {
                //     'january' : {
                //         "dohodi": { 'value' : 25000, 'color': "#a55ca5", },
                //         "rashodi": { 'value' : 15000, 'color': "#67b6c7", },
                //         "Internet": { 'value' : 2100, 'color': "#bccd7a", },
                //         "Svet/Elektro": { 'value' : 1000, 'color': "#eb9743", },
                //     },
                //     'february' : {
                //         "dohodi": { 'value' : 33000, 'color': "#a55ca5", },
                //         "rashodi": { 'value' : 19000, 'color': "#67b6c7", },
                //         "Internet": { 'value' : 2100, 'color': "#bccd7a", },
                //         "Svet/Elektro": { 'value' : 2300, 'color': "#eb9743", },
                //     },
                //     'march' : {
                //         "dohodi": { 'value' : 15000, 'color': "#a55ca5", },
                //         "rashodi": { 'value' : 29000, 'color': "#67b6c7", },
                //         "Internet": { 'value' : 2500, 'color': "#bccd7a", },
                //         "Svet/Elektro": { 'value' : 1100, 'color': "#eb9743", },
                //     },
                //     'april' : {
                //         "dohodi": { 'value' : 17000, 'color': "#a55ca5", },
                //         "rashodi": { 'value' : 12000, 'color': "#67b6c7", },
                //         "Internet": { 'value' : 2100, 'color': "#bccd7a", },
                //         "Svet/Elektro": { 'value' : 1500, 'color': "#eb9743", },
                //     },
                // };
                // conlog(tagValues);

                let tagValuesChart = new Barchart(
                    {
                        canvas:monthGistogrammCanvas,
                        canvas_id:'monthGistogrammCanvas',
                        padding:15,
                        gridScale:5,
                        gridColor:"#000",
                        data:tagValues,
                    }
                );
                monthGistogrammCanvasContext.clearRect(0, 0, monthGistogrammCanvas.width, monthGistogrammCanvas.height);
                tagValuesChart.draw();

                let yearsSelect = document.querySelector('.getMonthDiagrammByYear__wrapper select[name="year"]');
                let year = +rs['current_year'];
                addYearsAndsetCurrentYearSelectedForPieDiagramm(rs['years'], yearsSelect);
                setOptionSelected(yearsSelect, year);

                spinMessage__setClassForMessageHandler(spinWrapper, rs['success']);
                spinMessage__setMessage(spinWrapper, rs['message']);
                let none_class = 'none_' + Math.random().toString(36).substring(7);
                spinMessage__showMessage(spinWrapper, none_class);
            }
        }
    });

    xhr.addEventListener("progress", () => {
        monthTagValueGistogramm__hideSpin();
    });
    xhr.addEventListener("load", () => {
        monthTagValueGistogramm__hideSpin();
    });
    xhr.addEventListener("error", () => {
        monthTagValueGistogramm__hideSpin();
    });
    xhr.addEventListener("abort", () => {
        monthTagValueGistogramm__hideSpin();
    });

    xhr.send(formData);
}

function drawBar(ctx, upperLeftCornerX, upperLeftCornerY, width, height,color){
    ctx.save();
    ctx.fillStyle=color;
    ctx.fillRect(upperLeftCornerX,upperLeftCornerY,width,height);
    ctx.restore();
}

function GistogrammTagValuesByYearFormSubmitHandler() {
    let form = document.querySelector('form[name=monthDiagrammByYear]');
    if (form){
        form.onsubmit = function (e) {

            let formData = new FormData(e.currentTarget);

            tagValuesMonthGistogrammSvgXhr(formData);

            return false;
        }
    }
}

function monthTagValueGistogramm__hideSpin() {
    let spinWrapper = spinMessage__getScopeClass('.getMonthDiagrammByYear__wrapper');
    spinMessage__hideSpin(spinWrapper);
};

// end
////// gistogramm data - tagValues

// ###################################################
// all functions with one initial start
// start
function functionsInitialStart(){
    findTokenFunction();
    attachmentModalFunction();
    eventoModalFunction();
    addCategoryModalFunction();
    addStandaloneTagFormFunction();
    deleteItemAFunction();
    openDeactivateDialogFunction();
    cancelBtnFunction();
    closeMainDialogOnDarkSideFunction();
    addTagModalFunction();
    addCategoryFormFunction();
    addEventoTagFormFunction();
    eventoDeleteLinksFunction();
    addStandAloneCategoryBtnFindFunction();

    saveCurrentDataEventoId();
    deleteEventoCategoryAddHandler();
    deleteEventoTagAddHandler();
    addHandlerForAttachmentsStoreButton();
    addHandlerForAttachmentDelete();
    create_evento__submit();

    setFlatpickrInstances();
    eventoGetAjaxHanlder();
    eventoShowModalFunction();
    eventoEditModalFunction();
    eventoEditAjaxHanlder();
    tagEditModalFunction();
    editTagFormHandler();
    spinMessages__startingHide();
    categoryEditModalFunction();
    editCategoryFormHandler();
    tagvaluesPieDiagrammFunction();

    tagValuesPieDiagrammSvgHandler();
    DiagrammPieByYearFormSubmitHandler();

    GistogrammTagValuesByYearFormSubmitHandler();
    tagValuesMonthGistogrammSvgHandler();
    tagvaluesMonthDiagrammFunction();
}
functionsInitialStart();
// end
// all functions with one initial start
// ##################
// #################################