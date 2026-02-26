<?php

namespace App\Helpers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

class ArrayPaginator
{
    public static function paginate(
        array|Collection $items,
        int $perPage = 10,
        ?int $page = null,
        array $options = [],
        ?Request $request = null,
        string $pageName = 'page'
    ): LengthAwarePaginator {
        try {
            $request = $request ?: request();
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
            $items = is_array($items) ? collect($items) : $items;

            $offset = ($page - 1) * $perPage;

            return new LengthAwarePaginator(
                $items->slice($offset, $perPage)->values(),
                $items->count(),
                $perPage,
                $page,
                array_merge([
                    'path' => $request->url(),
                    'query' => $request->query(),
                    'pageName' => $pageName,
                ], $options)
            );
        } catch (\Throwable $th) {
            logger()->error($th);
            return new LengthAwarePaginator(collect(), 0, $perPage, 1, $options);
        }
    }

    public static function paginateWithSort(
        array|Collection $items,
        int $perPage = 10,
        string $sortBy = 'id',
        string $sortDirection = 'asc',
        ?int $page = null,
        array $options = [],
        string $pageName = 'page'
    ): LengthAwarePaginator {
        $items = is_array($items) ? collect($items) : $items;

        try {
            $sorted = $sortDirection === 'asc'
                ? $items->sortBy($sortBy)
                : $items->sortByDesc($sortBy);

            return self::paginate($sorted->values(), $perPage, $page, $options, null, $pageName);
        } catch (\Throwable $th) {
            logger()->error($th);
            return new LengthAwarePaginator(collect(), 0, $perPage, 1, $options);
        }
    }

    public static function paginateWithFilter(
        array|Collection $items,
        callable $filter,
        int $perPage = 10,
        ?int $page = null,
        array $options = [],
        string $pageName = 'page'
    ): LengthAwarePaginator {
        $items = is_array($items) ? collect($items) : $items;

        try {
            $filtered = $items->filter($filter);
            return self::paginate($filtered->values(), $perPage, $page, $options, null, $pageName);
        } catch (\Throwable $th) {
            logger()->error($th);
            return new LengthAwarePaginator(collect(), 0, $perPage, 1, $options);
        }
    }

    public static function paginateWithSearchAndFilter(
        array|Collection $items,
        ?string $searchTerm = null,
        ?callable $searchCallback = null,
        ?callable $filterCallback = null,
        int $perPage = 10,
        ?int $page = null,
        array $options = [],
        string $pageName = 'page'
    ): LengthAwarePaginator {
        $items = is_array($items) ? collect($items) : $items;

        try {
            if ($filterCallback) {
                $items = $items->filter($filterCallback);
            }

            if ($searchTerm && $searchCallback) {
                $items = $items->filter(fn($item) => $searchCallback($item, $searchTerm));
            }

            return self::paginate($items->values(), $perPage, $page, $options, null, $pageName);
        } catch (\Throwable $th) {
            logger()->error($th);
            return new LengthAwarePaginator(collect(), 0, $perPage, 1, $options);
        }
    }
}
