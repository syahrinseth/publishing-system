<?php

namespace App\Models\Filters;

use App\QueryFilter;

class ManuscriptFilters extends QueryFilter
{
    public function excepts($ids = '[]')
    {
        if (!is_array($ids)) {
            $ids = json_decode($ids);
        }
        return $this->builder->whereNotIn('id', $ids);
    }
    
    public function isPublished()
    {
        return $this->builder->whereIn('status', ['Accepted Without Changes', 'Accepted With Minor Changes', 'Accepted With Major Changes', 'Published']);
    }

    public function isInOtherJournals($input)
    {
        if ($input == 'true') {
            return $this->builder->has('journal');
        }
        return $this->builder->doesnthave('journal');
    }

    public function status($level)
    {
        return $this->builder->where('status', $level);
    }

    public function updatedAt($order = 'desc')
    {
        return $this->builder->orderBy('updated_at', $order);
    }

    public function ids($ids = [])
    {
        return $this->builder->whereIn('id', $ids);
    }

    public function search($input = null)
    {
        return $this->builder->where(function($query) use ($input) {
            $query->where('title', 'like', "%{$input}%")
                ->orWhere('manuscript_no', 'like', "%{$input}%")
                ->orWhere('abstract', 'like', "%{$input}%")
                ->orWhere('keywords', 'like', "%{$input}%")
                ->orWhere('status', 'like', "%{$input}%");
        });
    }

    public function field($field)
    {
        if (request()->has(['direction'])) {
            return $this->builder->orderBy($field, request('direction'));
        }
        return $this->builder;
    }
}