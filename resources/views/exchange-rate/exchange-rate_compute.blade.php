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

let url = '<?=$url?>';
//console.log('current url: ' + url);

function updateRate2(url)
{
    fetch(url)
        .then(response => response.json())
        .then(data => {

            console.log('json_parsed: '+JSON.parse(data));

            {{--let el = document.querySelector(".result-exchange-rate");--}}
            {{--el.innerHTML = data['html'];--}}

            {{-- Автоматический подсчет курса по вводу нужного значения --}}
            {{--$('[class^=amount-computed]').on('keyup', function(e) {--}}
            {{--    let parent_tr = $(this).parent().parent();--}}
            {{--    let value = parent_tr.find('.Value').text();--}}
            {{--    let nominal = parent_tr.find('.Nominal').text();--}}
            {{--    let computed = ( (value * 1) / (nominal * 1) ) * ( $(this).val() * 1);--}}
            {{--    parent_tr.find('.exchange-rate-result').val(computed.toFixed(2));--}}
            {{--    //console.log(value + ' : ' + nominal + ' --- ' + computed.toFixed(2));--}}
            {{--});--}}

        });
}

function updateRate(url)
{
    axios.get(url)
        .then(response => {
            //console.log("response", response.data.html)

            let el = document.querySelector(".result-exchange-rate");
            el.innerHTML = response.data.html;

            {{-- Автоматический подсчет курса по вводу нужного значения --}}
            $('[class^=amount-computed]').on('keyup', function(e) {
                let parent_tr = $(this).parent().parent();
                let value = parent_tr.find('.Value').text();
                let nominal = parent_tr.find('.Nominal').text();
                let computed = ( (value * 1) / (nominal * 1) ) * ( $(this).val() * 1);
                parent_tr.find('.exchange-rate-result').val(computed.toFixed(2));
                //console.log(value + ' : ' + nominal + ' --- ' + computed.toFixed(2));
            });
        })
        .catch(error => console.log('updateRate: ' + error));
}

updateRate(url);

let btnUpdateRate = document.getElementById('btnUpdateRate');

btnUpdateRate.addEventListener('click', function() {
    //updateRate2(url);
    updateRate(url);
});

</script>