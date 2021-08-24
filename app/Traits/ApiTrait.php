<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

trait ApiTrait
{
    public function scopeIncluded(Builder $query)
    {
        if (empty($this->allowIncluded) || empty(request('included'))) {
            return;
        }

        $relations = explode(',', request('included'));
        $allowIncluded = collect($this->allowIncluded);

        foreach ($relations as $key => $relationship) {
            if (! $allowIncluded->contains($relationship)) {
                unset($relations[$key]);
            }
        }

        $query->with($relations);
    }

    public function scopeFilter(Builder $query)
    {
        if (empty($this->allowFilters) || empty(request('filter'))) {
            return;
        }

        $filters = request('filter');
        $allowFilters = collect($this->allowFilters);

        foreach ($filters as $filter => $value) {
            if ($allowFilters->contains($filter)) {
                $query->where($filter, 'LIKE', "%{$value}%");
            }
        }
    }

    public function scopeSort(Builder $query)
    {
        if (empty($this->allowSorts) || empty(request('sort'))) {
            return;
        }

        $sortFields = explode(',', request('sort'));
        $allowSorts = collect($this->allowSorts);

        foreach ($sortFields as $sortField) {
            $direction = 'asc';

            if (Str::of($sortField)->startsWith('-')) {
                $direction  = 'desc';
                $sortField = Str::of($sortField)->substr(1);
            }

            if ($allowSorts->contains($sortField)) {
                $query->orderBy($sortField, $direction);
            }
        }
    }

    public function scopeGetOrPaginate(Builder $query)
    {
        if (request('perPage')) {
            $perPage = intval(request('perPage'));

            if ($perPage) {
                return $query->paginate($perPage);
            }
        }

        return $query->get();
    }
}
