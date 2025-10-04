<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $guarded = [];

    // public function campaign_owner()
    // {
    //     return $this->hasMany(CampaignOwner::class);
    // }
}
