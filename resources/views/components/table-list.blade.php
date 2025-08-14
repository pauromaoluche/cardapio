@props([
    'cols' => [],
    'fields' => [],
    'route' => null,
    'data' => null,
    'hiddenFields' => [],
])

<table class="table table-list">
    <thead>
        <tr>
            <th class="d-none d-sm-table-cell" scope="col">Foto</th>
            @foreach ($cols as $index => $col)
                <th class="{{ in_array($fields[$index], $hiddenFields) ? 'd-none d-md-table-cell' : '' }}" scope="col">
                    {{ $col }}</th>
            @endforeach
            <th scope="col" class="text-center">Ação</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            <tr>
                <td class="d-none d-sm-table-cell">
                    @if ($item->images->count() > 0)
                        <img src="{{ asset('storage/' . $item->images[0]->path) }}" class="img-thumbnail img-table-list">
                    @endif
                </td>
                @foreach ($fields as $field)
                    <td class="{{ in_array($field, $hiddenFields) ? 'd-none d-md-table-cell' : '' }}">
                        {{ Str::limit(data_get($item, $field), 50, '...') }}
                    </td>
                @endforeach
                <td class="text-center">
                    <x-btn-group-list :route="$route" :id="$item->id" />
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
