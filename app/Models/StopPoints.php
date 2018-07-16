<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StopPoints extends Model
{
    /**
     * Indicates if the model should be timestamped.
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass readable.
     * @var array
     */
    protected $readable = [
        'external_id',
        'name',
    ];

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'external_id',
        'name',
    ];

    /**
     * Get all of the models from the database.
     *
     * @param  array|mixed  $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function all($columns = null)
    {
        $instance = new static;
        $columns = $columns ?? $instance->getReadableFields();

        return $instance->newQuery()->get(
            is_array($columns) ? $columns : func_get_args()
        );
    }

    /**
     * Ger readable attributes.
     * @return array
     */
    public function getReadableFields(): array
    {
        return ! empty($this->readable) && is_array($this->readable) ? $this->readable : ['*'];
    }
}
