<div class="row g-4">
    @foreach ($orders as $order)
        <x-recent-order-card
        :order="$order"
        :statusClass="$statusMap[$order->status_id]"
        :colClass="$colClass"
        :h="$h"
        :iconStep="$iconStepMap[$order->status_id]"/>
    @endforeach
</div>
