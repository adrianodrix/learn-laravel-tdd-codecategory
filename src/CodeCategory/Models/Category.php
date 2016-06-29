<?php

namespace CodePress\CodeCategory\Models;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Object_;

class Category extends Model implements SluggableInterface
{
    use SluggableTrait;

    /**
     * @var Validator
     */
    protected $validator;

    protected $table = "codepress_categories";

    protected $sluggable = array(
        'build_from' => 'name',
        'save_to' => 'slug',
        'unique' => true
    );

    protected $fillable = array(
        'name',
        'slug',
        'active',
        'parent_id'
    );

    public function categorizable()
    {
        return $this->morphTo();
    }

    public function parent()
    {
        return $this->belongsTo(Category::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * @return Validator
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * @param $validator
     * @return $this
     */
    public function setValidator($validator)
    {
        $this->validator = $validator;
        return $this;
    }

    public function isValid()
    {
        $this->validator->setRules(array(
            'name' => 'required|max:255',
            'active' => 'boolean'
        ));

        $this->validator->setData($this->getAttributes());

        if ($this->validator->fails()) {
            $this->errors = $this->validator->errors();
            return false;
        }

        return true;
    }
}