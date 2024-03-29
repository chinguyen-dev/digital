<?php

namespace App\Services\Impl;


use App\Models\Order;
use App\Services\Abstracts\BaseService;
use App\Services\Interfaces\IOrderService;

class OrderServiceImpl extends BaseService implements IOrderService
{
    public function getModel(): string
    {
        return Order::class;
    }

    public function orderByStatus($type = 'desc')
    {
        return $this->model->with('customer')
            ->orderBy('status', $type)
            ->paginate(15);
    }

    public function updateMany(string $column, array $ids, array $data)
    {
        $this->model->whereIn($column, $ids)->update($data);
    }

    public function findByCustomerIdContaining(array $ids)
    {
        return $this->model
            ->whereIn('customer_id', $ids)
            ->paginate(15);
    }
}
