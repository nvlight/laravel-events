@php
    // получение УРЛ-а для запроса - тут пока что http, потом переделать!
    //dump($_SERVER);
    $url = 'https://' . $_SERVER['HTTP_HOST'] . '/' . 'exchange-rate-update';
@endphp

<script>

fetch('<?=$url?>')
    .then(response => response.json())
    .then(data => {
        let el = document.querySelector(".result-exchange-rate");
        el.innerHTML = data['html'];

        {{-- Автоматический подсчет курса по вводу нужного значения --}}
        $('[class^=amount-computed]').on('keyup', function(e) {
            let parent_tr = $(this).parent().parent();
            let value = parent_tr.find('.Value').text();
            let nominal = parent_tr.find('.Nominal').text();
            let computed = ( (value * 1) / (nominal * 1) ) * ( $(this).val() * 1);
            parent_tr.find('.exchange-rate-result').val(computed.toFixed(2));
            //console.log(value + ' : ' + nominal + ' --- ' + computed.toFixed(2));
        });
    });

</script>