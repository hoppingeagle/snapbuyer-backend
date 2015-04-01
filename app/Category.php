<?php namespace Snapbuyer;

use Illuminate\Database\Eloquent\Model;

/**
 * Snapbuyer\Category
 *
 * @property integer $id 
 * @property integer $category_id 
 * @property integer $weight 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @method static \Illuminate\Database\Query\Builder|\Snapbuyer\Category whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Snapbuyer\Category whereCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\Snapbuyer\Category whereWeight($value)
 * @method static \Illuminate\Database\Query\Builder|\Snapbuyer\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Snapbuyer\Category whereUpdatedAt($value)
 */
class Category extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['category_id', 'weight'];

}
