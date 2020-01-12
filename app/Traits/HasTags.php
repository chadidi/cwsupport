<?php

namespace App\Traits;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasTags
{
    protected $queuedTags = [];

    public static function getTagClassName(): string
    {
        return Tag::class;
    }

    public static function bootHasTags()
    {
        static::saved(function (Model $taggableModel) {
            if (count($taggableModel->queuedTags) > 0) {
                $taggableModel->syncTags($taggableModel->queuedTags);

                $taggableModel->queuedTags = [];
            }
        });
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(self::getTagClassName(), 'taggable');
    }

    /**
     * @param string|array|\ArrayAccess|Tag $tags
     */
    public function setTagsAttribute($tags)
    {
        if (! $this->exists) {
            $this->queuedTags = $tags;

            return;
        }

        $this->syncTags($tags);
    }

    /**
     * @param array|\ArrayAccess $tags
     *
     * @return $this
     */
    public function syncTags($tags)
    {
        $className = static::getTagClassName();

        $tags = collect($className::findOrCreate($tags));

        $this->tags()->sync($tags->pluck('id')->toArray());

        return $this;
    }
}
