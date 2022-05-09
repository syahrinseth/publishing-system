<?php

namespace App\Models\Filters;

use App\QueryFilter;

class UserFilters extends QueryFilter
{
    
    public function role($role)
    {
        return $this->builder->whereHas(
            'roles', function($q) use ($role){
                $q->where('name', $role);
            });
    }

    public function updatedAt($order = 'desc')
    {
        return $this->builder->orderBy('updated_at', $order);
    }

    public function search($input = null)
    {
        return $this->builder->where(function($query) use ($input) {
            $query->where('name', 'like', "%{$input}%")
                ->orWhere('email', 'like', "%{$input}%");
        });
    }
}