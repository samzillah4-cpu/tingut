<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'location',
        'password',
        'phone',
        'date_of_birth',
        'gender',
        'bio',
        'address',
        'city',
        'country',
        'profile_picture',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'linkedin_url',
        'bankid_uuid',
        'bankid_status',
        'bankid_verified_at',
        'national_id_number',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'bankid_verified_at' => 'datetime',
        ];
    }

    /**
     * Get the products for the user.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the exchanges proposed by the user.
     */
    public function proposedExchanges()
    {
        return $this->hasMany(Exchange::class, 'proposer_id');
    }

    /**
     * Get the exchanges received by the user.
     */
    public function receivedExchanges()
    {
        return $this->hasMany(Exchange::class, 'receiver_id');
    }

    /**
     * Get the rentals made by the user.
     */
    public function rentals()
    {
        return $this->hasMany(Rental::class, 'renter_id');
    }

    /**
     * Get all exchanges for the user (both proposed and received).
     */
    public function exchanges()
    {
        return Exchange::where(function ($query) {
            $query->where('proposer_id', $this->id)
                ->orWhere('receiver_id', $this->id);
        });
    }

    /**
     * Get the comments made by the user.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the subscriptions for the user.
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function activeSubscription()
    {
        return $this->subscriptions()
            ->where('status', 'active')
            ->where('end_date', '>', now())
            ->first();
    }

    public function hasActiveSubscription()
    {
        return $this->activeSubscription() !== null;
    }

    public function getSubscriptionPlan()
    {
        $subscription = $this->activeSubscription();

        return $subscription ? $subscription->plan : null;
    }

    /**
     * Check if user has active subscription for a specific category.
     */
    public function hasActiveSubscriptionForCategory(Category $category)
    {
        return $this->subscriptions()
            ->where('status', 'active')
            ->where('end_date', '>', now())
            ->whereHas('plan', function ($query) use ($category) {
                $query->where('category_id', $category->id)
                    ->orWhereNull('category_id'); // General plans might cover all
            })
            ->exists();
    }

    /**
     * Get the messages sent by the user.
     */
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Get the messages received by the user.
     */
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    /**
     * Get the chats initiated by the user.
     */
    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    /**
     * Get chats where user is the related user (customer/admin in seller's chat).
     */
    public function relatedChats()
    {
        return $this->hasMany(Chat::class, 'related_user_id');
    }

    /**
     * Get all chats for the user (both initiated and related).
     */
    public function allChats()
    {
        return Chat::where(function ($query) {
            $query->where('user_id', $this->id)
                ->orWhere('related_user_id', $this->id);
        });
    }

    /**
     * Get unread chat messages count.
     */
    public function getUnreadChatMessagesCountAttribute(): int
    {
        return ChatMessage::whereHas('chat', function ($query) {
            $query->where(function ($q) {
                $q->where('user_id', $this->id)
                    ->orWhere('related_user_id', $this->id);
            });
        })->where('user_id', '!=', $this->id)
            ->whereNull('read_at')
            ->count();
    }

    /**
     * Check if user has verified their identity with BankID.
     */
    public function isBankIdVerified(): bool
    {
        return $this->bankid_status === 'verified' && $this->bankid_verified_at !== null;
    }

    /**
     * Mark user as BankID verified.
     */
    public function markAsBankIdVerified(string $bankidUuid, ?string $nationalIdNumber = null): void
    {
        $this->update([
            'bankid_uuid' => $bankidUuid,
            'bankid_status' => 'verified',
            'bankid_verified_at' => now(),
            'national_id_number' => $nationalIdNumber,
        ]);
    }

    /**
     * Get BankID verification status label.
     */
    public function getBankIdStatusLabelAttribute(): string
    {
        return match ($this->bankid_status) {
            'verified' => 'Verified',
            'pending' => 'Pending',
            'failed' => 'Failed',
            default => 'Not Verified',
        };
    }
}
