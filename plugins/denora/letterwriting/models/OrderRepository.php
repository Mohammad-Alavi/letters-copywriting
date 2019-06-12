<?php

namespace Denora\Letterwriting\Models;

use Illuminate\Database\Eloquent\Builder;

class OrderRepository {

    /**
     * @param int $id
     *
     * @return Builder|Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    function find(int $id) {
        return Order::find($id);
    }

    /**
     * @param string $status
     * @param int    $perPage
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    function paginate(string $status, int $perPage = 20) {
        if ($status === 'all') return Order::query()->paginate($perPage);

        return Order::query()->where(['status' => $status])->paginate($perPage);
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

        $order->setStatusCreated();

        return $order;

    }

    /**
     * @param int    $orderId
     * @param string $newStatusLabel
     */
    function changeStatus(int $orderId, string $newStatusLabel) {
        $order = $this->find($orderId);
        $order->status = $newStatusLabel;
        $order->save();
    }


}
