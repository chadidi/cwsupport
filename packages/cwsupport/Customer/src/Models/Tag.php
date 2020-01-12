<?php

namespace cwsupport\Customer\Models;

use Illuminate\Support\Str;
use cwsupport\Customer\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Tag extends Model
{
    use HasSlug;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model'));
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

    protected static function findOrCreateFromString(string $name)
    {
        $slug = Str::slug($name);
        $tag = static::getBySlug($slug);

        if (! $tag) {
            $tag = static::create([
                'name' => $name,
                'slug' => $slug,
            ]);
        }

        return $tag;
    }
}
