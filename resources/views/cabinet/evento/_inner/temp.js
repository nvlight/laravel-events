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
    let spinWrapper = spinMessage__getScopeClass('.eventoStore__wrapper');
    spinMessage__hideSpin(spinWrapper);
}