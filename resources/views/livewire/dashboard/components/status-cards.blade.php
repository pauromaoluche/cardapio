<div class="row g-4 mb-5">
    @foreach ($data as $item)
        <x-status-card :title="$item['title']" :icon="$item['icon']" :bg="$item['bg']" :value="$item['value']" :statusid="$item['status_id']" />
    @endforeach
</div>
