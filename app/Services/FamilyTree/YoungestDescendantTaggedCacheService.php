<?php

namespace App\Services\FamilyTree;

use App\Contracts\FamilyTree\YoungestDescendantCache;
use App\Enums\CacheKeys;
use App\Models\Person;
use Illuminate\Cache\Repository as CacheRepository;

class YoungestDescendantTaggedCacheService implements YoungestDescendantCache
{
    const CACHE_TAG = self::class;
    const CACHE_TTL = 10;

    public function __construct(
        private readonly CacheRepository $cache
    ) {}

    public function get(Person $person): Person|null
    {
        $key = $this->getCacheKey($person);

        return $this->cache->tags(self::CACHE_TAG)->get($key);
    }

    public function exists(Person $person): bool
    {
        $key = $this->getCacheKey($person);

        return $this->cache->tags(self::CACHE_TAG)->has($key);
    }

    public function add(Person $person, ?Person $target): void
    {
        $key = $this->getCacheKey($person);

        $this->cache->tags(self::CACHE_TAG)->add($key, $target, now()->addMinutes(self::CACHE_TTL));
    }

    public function flushAll(): void
    {
        $this->cache->tags(self::CACHE_TAG)->flush();
    }

    private function getCacheKey(Person $person): string
    {
        return CacheKeys::GET_YOUNGEST_DESCENDANT->name . '_' . $person->id;
    }
}
