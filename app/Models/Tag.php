<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function issues() : MorphToMany
    {
        return $this->morphedByMany(Issue::class, 'taggable');
    }

    /**
     * @param string|array|\ArrayAccess $values
     * @param string|null $type
     * @param string|null $locale
     *
     * @return Tag|static
     */
    public static function findOrCreate($values)
    {
        $tags = collect($values)->map(function ($value) {
            if ($value instanceof self) {
                return $value;
            }

            return static::findOrCreateFromString($value);
        });

        return is_string($values) ? $tags->first() : $tags;
    }

    public static function findFromSlug(string $slug)
    {
        return static::query()
            ->where('slug', $slug)
            ->first();
    }
    
    protected static function findOrCreateFromString(string $name)
    {
        $slug = Str::slug($name);
        $tag = static::findFromSlug($slug);

        if (! $tag) {
            $tag = static::create([
                'name' => $name,
                'slug' => $slug,
            ]);
        }

        return $tag;
    }
}
