function updateEventoAjaxXhr(eventoId, description, date) {
    let url = "/cabinet/evento/update_ajax/"+eventoId;
    const xhr = new XMLHttpRequest();
    let params = "_token=" + token + '&description='+description+'&date='+date;

    xhr.open("post", url);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.addEventListener("readystatechange", () => {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let rs = JSON.parse(xhr.responseText);

            //eventoEditAjaxXhr(rs['eventoId']); // после обновить содержимое формы

            message.classList.remove('d-none');
            if (rs['success']){
                // todo - осталось найти текущую строку и обновить ее данные
                let successMessage = message.querySelector('.text-success');
                successMessage.classList.remove('d-none');
                successMessage.innerHTML = rs['message'];

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
                let successDanger = message.querySelector('.text-danger');
                successDanger.classList.remove('d-none');
                successDanger.innerHTML = rs['message'];

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
        }
    });

    let message = document.querySelector('.eventoEdit__successEditMessage');
    let spin = document.querySelector('.eventoEdit__successEditSpin');

    updateEventXhr_startAnimation(spin, message);

    xhr.addEventListener("progress", () => {
        updateEventXhr_stopAnimation(spin)
    });
    xhr.addEventListener("load", () => {
        updateEventXhr_stopAnimation(spin)
    });
    xhr.addEventListener("error", () => {
        updateEventXhr_stopAnimation(spin)
    });
    xhr.addEventListener("abort", () => {
        updateEventXhr_stopAnimation(spin)
    });

    xhr.send(params);
}


// eventoEdit__wrapper
let message = document.querySelector('.eventoEdit__successEditMessage');
let spin = document.querySelector('.eventoEdit__successEditSpin');
updateEventXhr_startAnimation(spin, message);

updateEventXhr_stopAnimation(spin);