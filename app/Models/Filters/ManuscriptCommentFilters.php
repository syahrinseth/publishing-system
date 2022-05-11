<?php

namespace App\Models\Filters;

use App\QueryFilter;

class ManuscriptCommentFilters extends QueryFilter
{

    public function updatedAt($order = 'desc')
    {
        return $this->builder->orderBy('updated_at', $order);
    }

    public function createdAt($order = 'desc')
    {
        return $this->builder->orderBy('updated_at', $order);
    }

    public function search($input = null)
    {
        return $this->builder->where(function($query) use ($input) {
            $query->where('text', 'like', "%{$input}%");
        });
    }
}