<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;

class ServiceFilter
{
    public function filter(array $filter, Builder $builder): Builder // возвращаемый тип данных
    {
        foreach ($filter as $item) {
            if(!array_key_exists('column', $item)) {
                throw new \RuntimeException('не указан столбец');
            }
            $column = $item['column'];
            if(!array_key_exists('value', $item)) {
                throw new \RuntimeException('не указанно значение');
            }
            $value = $item['value'];
            $operator = $item['operator'] ?? "=";
            $boolean = $item['boolean'] ?? "and";
            if (is_array($value)) {
                $builder = $builder->whereIn($column, $value, $boolean);
            } else {
                $builder = $builder
                    ->where($column, $operator, $value, $boolean);
            }
        }
        return $builder;
    }
}
