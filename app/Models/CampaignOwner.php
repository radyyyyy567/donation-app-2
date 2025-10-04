<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignOwner extends Model
{
    use HasFactory;

    protected $guarded = [];

    function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
