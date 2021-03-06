<?php

namespace Denora\Letterwriting\Models;

class StatusRepository {

    /**
     * @param int $id
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|Status
     */
    function find(int $id){
        return Status::find($id);
    }

    /**
     * @param int $orderId
     *
     * @return Order[]|\Illuminate\Database\Eloquent\Collection
     */
    function all(int $orderId) {
        return Status::query()->where(['order_id' => $orderId])->get();
    }

    /**
     *
     * @param int    $doerId
     * @param int    $orderId
     * @param string $label
     * @param string $description
     *
     * @return Status
     */
    function create(int $doerId, int $orderId, string $label, string $description) {

        $status = new Status();
        $status->doer_id = $doerId;
        $status->order_id = $orderId;
        $status->label = $label;
        $status->description = $description;

        $status->save();

        return $status;

    }

}
