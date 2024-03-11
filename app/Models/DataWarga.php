<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;



class DataWarga extends Model
{
    protected $table = 'data_warga';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $timestamps = true;
    public $incrementing = true;
    protected $guarded = ['id'];

    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }

    public function requestLetters(): HasMany
    {
        return $this->hasMany(RequestLetter::class);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

        public function user()
    {
        return $this->belongsTo(User::class);
    }

   

    

    
}
