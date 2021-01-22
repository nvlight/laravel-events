@php
    // получение УРЛ-а для запроса - тут пока что http, потом переделать!
    // dump($_SERVER);
    // код ниже не работает при включенном дебагБаре !

    $httpMethod = ($_SERVER['REQUEST_SCHEME'] === 'https') ? 'https' : 'http';
    $url = $httpMethod . '://' . $_SERVER['HTTP_HOST'] . '/' . 'exchange-rate-update';
    //dump($httpMethod);
    //dump($url);
@endphp

<script>
var exchangerRateTagFind = document.querySelector('.result-exchange-rate');
var btnUpdateRate = document.querySelector('#btnUpdateRate');
var exchangeRateUpdateSvgTag = document.querySelector('.exchangeRateUpdateSvg');
var url = '<?=$url?>';

function setTagInnerHtml(tag, html){
    if (tag){
        tag.innerHTML = html;
    }
}

function addClassByTag(tag, className) {
    if (tag){
        tag.classList.add(className);
    }
}

function removeClassByTag(tag, className) {
    if (tag){
        tag.classList.remove(className);
    }
}

function updateRate3(url) {
    fetch(url)
        .then(response => response.json())
        .then(response => {
            calculateRateRow();
        });
}

function updateRate2(url) {
    axios.get(url)
        .then(response => {
            //console.log("response", response.data.html)
            let el = document.querySelector(".result-exchange-rate");
            console.log('response_success:'+response.data['success']);
            console.log('response_success:'+response.data.data['success']);
            //el.innerHTML = response.data['data'].html;
            calculateRateRow();
        })
        .catch(error => console.log('updateRate___error: ' + error));
}

function btnUpdateRateHandler(){
    var btnUpdateRate = document.getElementById('btnUpdateRate');
    btnUpdateRate.addEventListener('click', function() {
        setTagInnerHtml(exchangerRateTagFind, "");
        updateRateHandler()
    });
}

function updateRate(url)
{
    const request = new XMLHttpRequest();
    request.open("GET", url);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.addEventListener("readystatechange", () => {
        if (request.readyState === 4 && request.status === 200) {
            removeClassByTag(exchangeRateUpdateSvgTag, 'd-block');
            addClassByTag(exchangeRateUpdateSvgTag, 'd-none');

            let rs = JSON.parse(request.response);
            setTagInnerHtml(exchangerRateTagFind, rs.html)
            calculateRateRow();
        }
    });
    request.send();
}

function calculateRateRow(){
    {{-- Автоматический подсчет курса по вводу нужного значения --}}
    $('[class^=amount-computed]').on('keyup', function(e) {
        let parent_tr = $(this).parent().parent();
        let value = parent_tr.find('.Value').text();
        let nominal = parent_tr.find('.Nominal').text();
        let computed = ( (value * 1) / (nominal * 1) ) * ( $(this).val() * 1);
        parent_tr.find('.exchange-rate-result').val(computed.toFixed(2));
        //console.log(value + ' : ' + nominal + ' --- ' + computed.toFixed(2));
    });
}

function updateRateHandler(){
    removeClassByTag(exchangeRateUpdateSvgTag, 'd-none');
    addClassByTag(exchangeRateUpdateSvgTag, 'd-block');
    updateRate(url);
}

btnUpdateRateHandler();
updateRateHandler();

</script>