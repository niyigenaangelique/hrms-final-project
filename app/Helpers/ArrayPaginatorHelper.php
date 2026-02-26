<?php

namespace App\Helpers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Request;

class ArrayPaginatorHelper
{
    /**
     * Paginate an array of items.
     *
     * @param array $items The array to paginate
     * @param int $perPage Number of items per page
     * @param int|null $page Current page number (optional, defaults to query string)
     * @param array $options Additional pagination options
     * @return LengthAwarePaginator
     */
    public static function paginate(array $items, int $perPage = 10, ?int $page = null, array $options = []): LengthAwarePaginator
    {
        // Ensure perPage is positive
        $perPage = max(1, $perPage);

        // Get current page from query string if not provided
        $pageName = $options['pageName'] ?? 'page';
        $page = $page ?? Request::input($pageName, 1);
        $page = max(1, (int) $page); // Ensure page is at least 1

        // Calculate total items
        $total = count($items);

        // Slice the array for the current page
        $offset = ($page - 1) * $perPage;
        $paginatedItems = array_slice($items, $offset, $perPage);

        // Default options
        $defaultOptions = [
            'path' => Request::url(),
            'query' => Request::query(),
            'fragment' => null,
            'pageName' => 'page'
        ];

        // Merge provided options with defaults
        $options = array_merge($defaultOptions, $options);

        // Create and return LengthAwarePaginator instance
        return new LengthAwarePaginator(
            $paginatedItems,
            $total,
            $perPage,
            $page,
            $options
        );
    }
}
