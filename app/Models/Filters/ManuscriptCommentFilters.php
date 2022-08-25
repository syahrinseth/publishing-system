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

    public function from($input)
    {
        return $this->builder->orWhere(function($query) use ($input) {
            $query->where('from', 'like', "%{$input}%");
        });
    }

    public function user_id($input)
    {
        return $this->builder->orWhere(function($query) use ($input) {
            $query->where('user_id', 'like', "%{$input}%");
        });
    }

    public function to($input)
    {
        return $this->builder->orWhere(function($query) use ($input) {
            $query->where('to', 'like', "%{$input}%");
        });
    }
}