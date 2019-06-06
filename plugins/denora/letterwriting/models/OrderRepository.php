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
     * @return Order
     */
    function create(int $customerId, string $description, string $language, float $price, bool $isRush = false) {

        $order = new Order();
        $order->customer_id = $customerId;
        $order->description = $description;
        $order->is_rush = $isRush;
        $order->language = $language;
        $order->price = $price;

        $order->save();

        $order->setNewStatus(Status::$CREATED);

        return $order;

    }


}
