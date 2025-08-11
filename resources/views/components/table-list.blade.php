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
                        <img src="{{ asset('storage/' . $item->images[0]->path) }}"
                            class="img-thumbnail img-table-list">
                    @endif
                </td>
                @foreach ($fields as $field)
                    <td>{{ data_get($item, $field) }}</td>
                @endforeach
                <td class="text-center">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="{{ route($route, ['id' => $item->id]) }}"
                            class="btn btn-success">Editar</a>
                        <button type="button" class="btn btn-danger">Remover</button>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
