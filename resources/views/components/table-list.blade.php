@props([
    'cols' => [],
    'fields' => [],
    'route' => null,
    'data' => null,
])

<table class="table table-list">
    <thead>
        <tr>
            <th scope="col">Foto</th>
            @foreach ($cols as $col)
                <th scope="col">{{ $col }}</th>
            @endforeach
            <th scope="col" class="text-center">Ação</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            <tr>
                <td>
                    @if ($item->images->count() > 0)
                        <img src="{{ asset('storage/' . $item->images[0]->path) }}" class="img-thumbnail img-table-list">
                    @endif
                </td>
                @foreach ($fields as $field)
                    <td>{{ data_get($item, $field) }}</td>
                @endforeach
                <td class="text-center">
                    <x-btn-group-list :route="$route" :id="$item->id" />
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
