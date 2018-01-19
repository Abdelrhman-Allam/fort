<?php

declare(strict_types=1);

namespace Rinvex\Fort\Models;

use Spatie\Sluggable\SlugOptions;
use Rinvex\Support\Traits\HasSlug;
use Rinvex\Fort\Traits\HasAbilities;
use Illuminate\Database\Eloquent\Model;
use Rinvex\Cacheable\CacheableEloquent;
use Rinvex\Fort\Contracts\RoleContract;
use Rinvex\Support\Traits\HasTranslations;
use Rinvex\Support\Traits\ValidatingTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Rinvex\Fort\Models\Role.
 *
 * @property int                                                                    $id
 * @property string                                                                 $slug
 * @property array                                                                  $name
 * @property array                                                                  $description
 * @property \Carbon\Carbon|null                                                    $created_at
 * @property \Carbon\Carbon|null                                                    $updated_at
 * @property \Carbon\Carbon|null                                                    $deleted_at
 * @property \Illuminate\Database\Eloquent\Collection|\Rinvex\Fort\Models\Ability[] $abilities
 * @property \Illuminate\Database\Eloquent\Collection|\Rinvex\Fort\Models\User[]    $users
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Fort\Models\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Fort\Models\Role whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Fort\Models\Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Fort\Models\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Fort\Models\Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Fort\Models\Role whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Fort\Models\Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Role extends Model implements RoleContract
{
    use HasSlug;
    use HasAbilities;
    use ValidatingTrait;
    use HasTranslations;
    use CacheableEloquent;

    /**
     * {@inheritdoc}
     */
    protected $touches = [
        'abilities',
        'users',
    ];

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'slug',
        'name',
        'description',
        'abilities',
        'users',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'slug' => 'string',
        'deleted_at' => 'datetime',
    ];

    /**
     * {@inheritdoc}
     */
    protected $with = [
        'abilities',
    ];

    /**
     * {@inheritdoc}
     */
    protected $observables = [
        'validating',
        'validated',
    ];

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    public $translatable = [
        'name',
        'description',
    ];

    /**
     * The default rules that the model will validate against.
     *
     * @var array
     */
    protected $rules = [];

    /**
     * Whether the model should throw a
     * ValidationException if it fails validation.
     *
     * @var bool
     */
    protected $throwValidationExceptions = true;

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('rinvex.fort.tables.roles'));
        $this->setRules([
            'slug' => 'required|alpha_dash|max:150|unique:'.config('rinvex.fort.tables.roles').',slug',
            'name' => 'required|string|max:150',
            'description' => 'nullable|string|max:10000',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected static function boot()
    {
        parent::boot();

        static::updated(function (self $role) {
            app('rinvex.fort.ability')->forgetCache();
            app('rinvex.fort.user')->forgetCache();
        });

        static::deleted(function (self $role) {
            app('rinvex.fort.ability')->forgetCache();
            app('rinvex.fort.user')->forgetCache();
        });
    }

    /**
     * Get all attached abilities to the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function abilities(): BelongsToMany
    {
        return $this->belongsToMany(config('rinvex.fort.models.ability'), config('rinvex.fort.tables.ability_role'), 'role_id', 'ability_id')
                    ->withTimestamps();
    }

    /**
     * A role may be assigned to various users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        $userModel = config('auth.providers.'.config('auth.guards.'.config('auth.defaults.guard').'.provider').'.model');

        return $this->belongsToMany($userModel, config('rinvex.fort.tables.role_user'), 'role_id', 'user_id')
                    ->withTimestamps();
    }

    /**
     * Get the options for generating the slug.
     *
     * @return \Spatie\Sluggable\SlugOptions
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
                          ->doNotGenerateSlugsOnUpdate()
                          ->generateSlugsFrom('name')
                          ->saveSlugsTo('slug');
    }

    /**
     * Determine if the role is super admin.
     *
     * @return bool
     */
    public function isSuperadmin()
    {
        return $this->abilities->where('action', 'superadmin')->where('resource', 'global')->where('policy', null);
    }

    /**
     * Determine if the role is protected.
     *
     * @return bool
     */
    public function isProtected()
    {
        return in_array($this->getKey(), config('rinvex.fort.protected.roles'));
    }

    /**
     * Attach the role users.
     *
     * @param mixed $users
     *
     * @return void
     */
    public function setUsersAttribute($users): void
    {
        static::saved(function (self $model) use ($users) {
            $model->users()->sync($users);
        });
    }
}
