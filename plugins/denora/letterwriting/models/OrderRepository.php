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
     * @param string $category
     * @param string $userRole
     * @param string $userId
     * @param int    $perPage
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    function paginate(string $status, string $category, string $userRole, string $userId, int $perPage = 20) {
        $query = Order::query();

        if ($status != 'all') $query->where(['status' => $status]);
        if ($category != 'all') $query->where(['category' => $category]);

        switch ($userRole){
            case 'author':{
                $query->where(['author_id' => $userId]);
                break;
            }
            case 'customer':{
                $query->where(['customer_id' => $userId]);
                break;
            }
        }

        return $query->paginate($perPage);
    }

    /**
     *
     * @param int    $customerId
     * @param string $description
     * @param string $language
     * @param string $category
     * @param float  $price
     * @param bool   $isRush
     *
     * @return Order
     */
    function create(int $customerId, string $description, string $language, string $category, $price, bool $isRush = false) {

        $order = new Order();
        $order->customer_id = $customerId;
        $order->description = $description;
        $order->is_rush = $isRush;
        $order->language = $language;
        $order->category = $category;
        $order->price = $price;

        $order->save();

        $order->setStatusCreated($customerId);
        if ($price != null) $order->setStatusPriced($customerId, $price);

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

    /**
     * @param int   $orderId
     * @param float $price
     */
    function changePrice(int $orderId, $price) {
        $order = $this->find($orderId);
        $order->price = $price;
        $order->save();
    }

    /**
     * @param int $orderId
     * @param int $authorId
     */
    function assignAuthor(int $orderId, int $authorId) {
        $order = $this->find($orderId);
        $order->author_id = $authorId;
        $order->save();
    }

}
