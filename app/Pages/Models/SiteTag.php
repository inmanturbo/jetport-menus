<?php

namespace App\Pages\Models;

use App\Support\Concerns\HasUuid;
use Database\Factories\SiteTagFactory;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\SortableTrait;

class SiteTag extends Model
{
    use CascadeSoftDeletes,
        HasFactory,
        HasUuid,
        SoftDeletes,
        SortableTrait;

    protected $cascadeDeletes = ['sitePages'];

    protected $cascadeDeactivates = ['sitePages'];

    protected $cascadeReactivates = ['sitePages'];

    protected $casts = ['active' => 'boolean'];


    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return SiteTagFactory::new();
    }

    public function taggedSitePages()
    {
        return $this->morphedByMany(SitePage::class, 'site_taggable')->ordered();
    }

    public function sitePages()
    {
        return $this->hasMany(SitePage::class)->ordered();
    }

    public function activate(): void
    {
        $this->update(['active' => 1]);

        foreach ($this->cascadeReactivates as $relationship) {
            $this->cascadeReactivate($relationship);
        }
    }

    public function deactivate(): void
    {
        $this->update(['active' => 0]);

        foreach ($this->cascadeDeactivates as $relationship) {
            $this->cascadeDeactivate($relationship);
        }
    }

    /**
     * Cascade deactivate the given relationship on the given mode.
     *
     * @param string  $relationship
     *
     * @return void
     */
    protected function cascadeDeactivate($relationship): void
    {
        foreach ($this->{$relationship}()->get() as $model) {
            $model->pivot ? $model->pivot->deactivate() : $model->deactivate();
        }
    }

    /**
     * Cascade deactivate the given relationship on the given mode.
     *
     * @param string  $relationship
     *
     * @return void
     */
    protected function cascadeReactivate($relationship): void
    {
        foreach ($this->{$relationship}()->get() as $model) {
            $model->pivot ? $model->pivot->activate() : $model->activate();
        }
    }
}