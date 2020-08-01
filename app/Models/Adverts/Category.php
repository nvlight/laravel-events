<?php

namespace App\Models\Adverts;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use App\Models\Adverts\Attribute;

/**
 * App\Models\Adverts\Category
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int|null $parent_id
 * @property int $depth
 * @property Category $parent
 * @property Category[] $children
 * @property Attribute[] $attributes
 * @property int $_lft
 * @property int $_rgt
 * @property-read int|null $attributes_count
 * @property-read int|null $children_count
 * @method static \Kalnoy\Nestedset\Collection|static[] all($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Adverts\Category d()
 * @method static \Kalnoy\Nestedset\Collection|static[] get($columns = ['*'])
 * @method static \Kalnoy\Nestedset\QueryBuilder|\App\Models\Adverts\Category newModelQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|\App\Models\Adverts\Category newQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|\App\Models\Adverts\Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Adverts\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Adverts\Category whereLft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Adverts\Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Adverts\Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Adverts\Category whereRgt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Adverts\Category whereSlug($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    use NodeTrait;

    protected $table = 'advert_categories';

    public $timestamps = false;

    protected $fillable = ['name', 'slug', 'parent_id'];

    public function parentAttributes(): array
    {
        return $this->parent ? $this->parent->allAttributes() : [];
    }

    public function getPath(): string
    {
        return implode('/', array_merge($this->ancestors()->defaultOrder()->pluck('slug')->toArray(), [$this->slug]));
    }

    /**
     * @return Attribute[]
     */
    public function allAttributes(): array
    {
        return array_merge($this->parentAttributes(), $this->attributes()->orderBy('sort')->getModels());
    }

    public function attributes()
    {
        return $this->hasMany(Attribute::class, 'category_id', 'id');
    }
}
