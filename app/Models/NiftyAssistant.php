<?php

namespace App\Models;

use App\Enums\AppointmentStatus;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\HasApiTokens;

/**
 * Class NiftyAssistant
 *
 * @mixin Eloquent
 * @property int    id
 * @property string first_name
 * @property string last_name
 * @property mixed rank
 * @property mixed services
 * @property mixed specialities
 * @property mixed rooms
 */
class NiftyAssistant extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'gender'            => 'integer',
        'status'            => 'integer',
    ];

    protected $appends = [
        'is_online', 'full_name', 'review_string', 'specialism',
        'is_online', 'join_date', 'reviews', 'total_rating',
    ];

    public function getJoinDateAttribute(): string
    {
        return Carbon::parse($this->created_at)->toFormattedDateString();
    }

    public function getTotalRatingAttribute(): string
    {
        $ratings = [];
        foreach ($this->allTasks() as $task) {
            $review = $task->review;
            if ($review) {
                $ratings[] = $review->rating;
            }
        }
        if (count($ratings) > 0) {
            return array_sum($ratings) / count($ratings);
        }
        return 5;
    }

    public function isOnline(): bool
    {
        return Cache::has('user-is-online-' . $this->id);
    }

    public function getIsOnlineAttribute(): bool
    {
        return Cache::has('user-is-online-' . $this->id);
    }

    public function getAvatarAttribute($value): string
    {
        if (!$value) {
            $avatar = '/assets/frontend/assets/media/avatars/avatar12.jpg';
        } else {
            $avatar = Storage::url($value);
        }
        return config('app.url').$avatar;
    }

    public function agreement(): HasOne
    {
        return $this->hasOne(NiftyAgreement::class);
    }

    public function getName(): string
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function availability(): HasMany
    {
        return $this->hasMany(NiftyAvailability::class);
    }

    public function calendars(): HasMany
    {
        return $this->HasMany(NiftyCalendar::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(NiftyService::class);
    }

    public function interview(): HasOne
    {
        return $this->hasOne(NiftyInterview::class);
    }

    public function other_tasks(): HasMany
    {
        return $this->hasMany(OtherTask::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany('App\Models\NiftyDocument');
    }

    public function allTasks(): Collection
    {
        $allTasks = collect();
        foreach ($this->services as $service) {
            foreach ($service->tasks as $task) {
                $allTasks->push($task);
            }
        }
        return $allTasks;
    }

    public function pendingTasks(): Collection
    {
        return $this->allTasks()->where('status', AppointmentStatus::PENDING);
    }

    public function completedTasks(): Collection
    {
        return $this->allTasks()->where('status', AppointmentStatus::COMPLETED);
    }

    public function emirates(): HasMany
    {
        return $this->hasMany('App\Models\NiftyEmirate');
    }

    public function private(): HasOne
    {
        return $this->hasOne(NiftyPrivate::class);
    }

    public function specialities(): HasMany
    {
        return $this->hasMany('App\Models\NiftySpeciality');
    }

    public function resources(): HasMany
    {
        return $this->hasMany('App\Models\NiftyResource');
    }

    public function gig(): HasMany
    {
        return $this->hasMany(NiftyGig::class);
    }

    public function token(): hasOne
    {
        return $this->hasOne(Token::class);
    }

    public function getAssistantTypesAttribute(): Collection
    {
        $assistant_types = collect();
        foreach ($this->specialities as $speciality) {
            $assistant_type = $speciality->task->assistant_type;
            if (!$assistant_types->contains($assistant_type)) {
                $assistant_types->push($assistant_type);
            }
        }
        return $assistant_types;
    }

    public function specialities_array(): array
    {
        $array = [];
        foreach ($this->specialities as $speciality) {
            if ($speciality->task) {
                if ($speciality->task->assistant_type) {
                    $id = $speciality->task->assistant_type->id;
                    if (!in_array($id, $array, true)) {
                        $array[] = $id;
                    }
                }
            }
        }
        return $array;
    }

    public function getSpecialismAttribute(): string
    {
        $array = [];
        if ($this->specialities) {
            foreach ($this->specialities as $speciality) {
                $name = $speciality->task->assistant_type->name;
                if (!in_array($name, $array, true)) {
                    $array[] = $name;
                }
            }
        }
        return implode(', ', $array);
    }

    public function rank(): BelongsTo
    {
        return $this->belongsTo('App\Models\NiftyRank', 'nifty_rank_id');
    }

    public function getRevenue(): int
    {
        $total = 0;
        foreach ($this->allTasks() as $task) {
            $payment = $task->payment;
            if ($payment) {
                $total += ($payment->total * $this->rank->commision) / 100;
            }
        }
        return $total;
    }

    public function cheapestService($assistant_type_id)
    {
        $chosen_service = null;
        $services = $this->services;
        if ($services) {
            $chosen_service = $services->first();
            foreach ($services->where('assistant_type_id', $assistant_type_id) as $service) {
                if ($service->cost < $chosen_service->cost) {
                    $chosen_service = $service;
                }
            }
        }
        return $chosen_service;
    }

    public function getReviewsAttribute(): Collection
    {
        $data = collect();
        foreach ($this->allTasks() as $task) {
            if ($task->review) {
                $review = $task->review;
                $review['user'] = $task->user;
                $review['published_date'] = Carbon::parse($review->created_at)->diffForHumans();
                $data->push($review);
            }
        }
        return $data;
    }

    public function getReviewStringAttribute(): string
    {
        $tasks = $this->allTasks();
        if ($tasks->count() > 0) {
            $total_reviews = 0;
            foreach ($tasks as $task) {
                if ($task->review) {
                    if ($task->review->positive()) {
                        $total_reviews += 1;
                    }
                }
            }
            $percent = round(($total_reviews / $tasks->count()) * 100, 2);
            return $percent.'% Positive Reviews';
        }
        return '100% Positive Reviews!';
    }

    public function rooms(): hasMany
    {
        return $this->hasMany(ChatRoom::class);
    }

    public function signature(): HasOne
    {
        return $this->hasOne(NiftyAgreement::class);
    }

    public function canJoinRoom($room_id): bool
    {
        foreach ($this->rooms as $room) {
            if ($room->id == $room_id) {
                return true;
            }
        }
        return false;
    }
}
