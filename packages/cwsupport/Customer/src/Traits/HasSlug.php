<?php

namespace cwsupport\Customer\Traits;

use Exception;
use Illuminate\Support\Str;

trait HasSlug
{
    public static function bootHasSlug()
    {
        static::creating(function ($item) {
            if ($item->shouldSlug()) {
                $item->setSlug();
            }
        });
    }

    public function setSlug()
    {
        $slugColumnName = $this->determineSlugOnRequest();
        $slugFromColumn = $this->generateSlugFromColumn();
        $slug = $this->slugColumnName();

        $this->$slug = $this->createSlug(request()->$slugColumnName ?? $this->$slugFromColumn);
    }

    protected function slugColumnName(): string
    {
        return $this->slugable['slug_column_name'] ?? 'slug';
    }

    protected function determineSlugOnRequest()
    {
        return $this->slugable['slug_on_request'] ?? null;
    }

    protected function generateSlugFromColumn(): string
    {
        return $this->slugable['slug_from_column'] ?? 'name';
    }

    protected function shouldSlug(): bool
    {
        return $this->slugable['slug_when_created'] ?? true;
    }
    /**
     * @param $title
     * @param int $id
     * @return string
     * @throws \Exception
     */
    public function createSlug($title, $id = 0)
    {
        // Normalize the title
        $slug = Str::slug($title);
        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = $this->getRelatedSlugs($slug, $id);
        // If we haven't used it before then we are all good.
        if (! $allSlugs->contains('slug', $slug)) {
            return $slug;
        }
        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 100; $i++) {
            $newSlug = $slug.'-'.$i;
            if (! $allSlugs->contains('slug', $newSlug)) {
                return $newSlug;
            }
        }
        throw new Exception('Can not create a unique slug');
    }

    public function getRelatedSlugs($slug, $id = 0)
    {
        return self::select('slug')
            ->where('slug', 'like', $slug.'%')
            ->where('id', '<>', $id)
            ->get();
    }

    public static function getBySlug($slug)
    {
        return self::where('slug', $slug)->first();
    }
}
