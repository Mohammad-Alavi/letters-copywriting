<?php

namespace Denora\Letterwriting\Models;

class OrderRepository {

    /**
     * @param int $id
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    function find(int $id){
        return Order::find($id);
    }

    /**
     * @return Order[]|\Illuminate\Database\Eloquent\Collection
     */
    function all() {
        return Order::all();
    }

    /**
     *
     * @param int    $customerId
     * @param string $description
     * @param string $language
     * @param float  $price
     * @param bool   $isRush
     *
     * @return Order|\Illuminate\Database\Eloquent\Model
     */
    function create(int $customerId, string $description, string $language, float $price, bool $isRush = false) {
        return Order::create([
            'customer_id' => $customerId,
            'description' => $description,
            'is_rush'     => $isRush,
            'language'    => $language,
            'price'       => $price
        ]);
    }


}
