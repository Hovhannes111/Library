<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'author_id', 'isbn', 'published_at', 'status'];

    protected $dates = ['published_at'];

    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('status', 'available');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function borrowedBook(): HasOne
    {
        return $this->hasOne(BorrowedBook::class);
    }

    public function borrowedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'borrowed_books')->withTimestamps()->withPivot('borrowed_at', 'returned_at');
    }
}
