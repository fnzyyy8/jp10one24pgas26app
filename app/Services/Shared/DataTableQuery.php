<?php

namespace App\Services\Shared;

use Illuminate\Database\Eloquent\Builder;

class DataTableQuery
{
    public function __construct(
        protected Builder $query,
    )
    {
    }

    public function search(
        ?string $search,
        array   $columns,
    ): static
    {
        if (blank($search)) {
            return $this;
        }

        $this->query->where(function (Builder $query) use ($columns, $search) {
            foreach ($columns as $column) {
                $query->orWhere($column, 'LIKE', "%" . $search . "%");
            }
        });
        return $this;
    }

    public function sort(
        ?string $sortBy,
        string  $sortDirection,
        array   $allowedColumns,
        string  $defaultColumn = 'created_at',
        string  $defaultDirection = 'desc'
    ): static
    {
        $column = in_array(
            $sortBy,
            $allowedColumns,
            true
        ) ? $sortBy : $defaultColumn;

        $direction = in_array(
            $sortDirection,
            ['asc', 'desc'],
            true
        ) ? $sortDirection : $defaultDirection;

        $this->query->orderBy($column, $direction);

        return $this;
    }

    public function paginate(
        int $perPage = 10,
        int $page = 1,
    )
    {
        return $this->query->paginate($perPage, $page);
    }

    public function getQuery(): Builder
    {
        return $this->query;
    }
}
