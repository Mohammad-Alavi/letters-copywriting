<?php

namespace Denora\Letterwriting\Models;

class CommentRepository {

    /**
     * @param int $id
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|Comment
     */
    function find(int $id){
        return Comment::find($id);
    }

    /**
     * @param int $orderId
     *
     * @return Order[]|\Illuminate\Database\Eloquent\Collection
     */
    function all(int $orderId) {
        return Comment::query()->where(['order_id' => $orderId])->get();
    }

    /**
     * @param int    $senderId
     * @param int    $orderId
     * @param string $text
     *
     * @return Comment
     */
    function create(int $senderId, int $orderId, string $text) {

        $comment = new Comment();
        $comment->sender_id = $senderId;
        $comment->order_id = $orderId;
        $comment->text = $text;

        $comment->save();

        return $comment;
    }

}
