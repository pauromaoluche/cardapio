<div class="row g-4">


    @foreach ($orders as $order)
        <x-recent-order-card
            :number="$order->id"
            :time="$order->created_at->format('H:i')"
            :status="$order->status->name"
            :statusClass="$statusMap[$order->status_id]"
            :clientName="$order->client_name"
            :clientPhone="$order->client_phone"
            :clientAddress="$order->address"
            :products="$order->products"
            :promotions="$order->promotions"
            :totalValue="$order->total_value"
            :deliveryFee="$order->delivery_fee"
            :colClass="$colClass"
            :h="$h"
            :iconStep="$iconStepMap[$order->status_id]"
            :timeAgo="$order->created_at->diffForHumans()" />
    @endforeach
</div>
