<?php

class TransactionRepository
{
    public function getPost($id)
    {
        $data = json_decode($response, true);
        return Post::make($data)->resolve();
    }
}
