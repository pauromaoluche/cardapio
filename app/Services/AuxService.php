<?php

namespace App\Services;

class AuxService
{
    public function calculateTotalPrice(array $item, int $quantity = 1): array
    {
        if ($item['type'] === 'promotion') {
            $item['price'] = 0;
            foreach ($item['products'] as $promotedProduct) {
                $item['price'] += ($promotedProduct['price'] * $promotedProduct['pivot']['quantity']);
            }

            if ($item['discount_type'] === 'percentage') {
                $item['total_price'] = $quantity * ($item['price'] - ($item['price'] * ($item['discount_value'] / 100)));
                $item['final_price'] = $item['price'] - ($item['price'] * ($item['discount_value'] / 100));
            } elseif ($item['discount_type'] === 'fixed') {
                $item['total_price'] = ($item['price'] - $item['discount_value']) * $quantity;
                $item['final_price'] = $item['price'] - $item['discount_value'];
            }
        } else {
            if (isset($item['discount']) && $item['discount']) {
                if ($item['discount']['discount_type'] === 'percentage') {
                    $item['total_price'] = $quantity * ($item['price'] - ($item['price'] * ($item['discount']['discount_value'] / 100)));
                    $item['final_price'] = $item['price'] - ($item['price'] * ($item['discount']['discount_value'] / 100));
                } elseif ($item['discount']['discount_type'] === 'fixed') {
                    $item['total_price'] = ($item['price'] - $item['discount']['discount_value']) * $quantity;
                    $item['final_price'] = $item['price'] - $item['discount']['discount_value'];
                }
            }else{
                $item['total_price'] = $item['price'] * $quantity;
                $item['final_price'] = $item['price'];
            }
        }
        return $item;
    }
}
