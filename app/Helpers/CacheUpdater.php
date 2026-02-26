<?php

namespace App\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CacheUpdater
{
    /**
     * Update a cached collection based on an action using stale-while-revalidate.
     *
     * @param string $cacheKey The cache key for the collection
     * @param Model $model The model instance to add, update, or remove
     * @param string $action The action ('add', 'update', 'remove')
     * @param array $fields Fields to select from the database
     * @param int $staleTtl Time-to-live for stale data in minutes (default: 60)
     * @param int $freshTtl Time-to-live for fresh data in minutes (default: 120)
     * @param string|null $modelClass The fully qualified model class name
     * @return void
     */
    public static function updateCache(
        string $cacheKey,
        Model $model,
        string $action,
        array $fields,
        int $staleTtl = 15,
        int $freshTtl = 30,
        string $modelClass = null
    ): void {
        try {
            Cache::lock($cacheKey . '_lock', 10)->block(5, function () use (
                $cacheKey, $model, $action, $fields, $staleTtl, $freshTtl, $modelClass
            ) {
                // Use Cache::flexible for stale-while-revalidate
                $collection = Cache::flexible($cacheKey, [$staleTtl * 60, $freshTtl * 60], function () use (
                    $modelClass, $fields
                ) {
                    if (!$modelClass) {
                        throw new \InvalidArgumentException('Model class must be provided for initial cache population.');
                    }
                    if (count($fields) === 1 && $fields[0] === '*') {
                        return $modelClass::all();
                    }
                    return $modelClass::select($fields)->get();
                });

                // Perform the requested action
                switch ($action) {
                    case 'add':
                        $collection->push($model);
                        break;
                    case 'update':
                        $collection = $collection->map(fn($item) => $item->id === $model->id ? $model : $item);
                        break;
                    case 'remove':
                        $collection = $collection->reject(fn($item) => $item->id === $model->id);
                        break;
                    default:
                        throw new \InvalidArgumentException("Unsupported action: $action");
                }

                // Store the updated collection with fresh TTL
                Cache::put($cacheKey, $collection, now()->addMinutes($freshTtl));
            });
        } catch (\Exception $e) {
            Log::error("Failed to update cache for {$cacheKey}: {$e->getMessage()}");
        }
    }

    /**
     * Clear the cache for a given key.
     *
     * @param string $cacheKey The cache key to clear
     * @return void
     */
    public static function clearCache(string $cacheKey): void
    {
        Cache::forget($cacheKey);
    }
}
