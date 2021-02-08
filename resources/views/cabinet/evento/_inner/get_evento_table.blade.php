<table class="table table-bordered table-striped">
    @foreach($evento->attributesToArray() as $k => $v)
        <tr>
            <th>{{ $k  }}</th>
            <td>{{ $v }}</td>
        </tr>
    @endforeach
</table>