<?php

namespace App\Filament\Resources\CampaignOwnerResource\Pages;

use App\Filament\Resources\CampaignOwnerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCampaignOwners extends ListRecords
{
    protected static string $resource = CampaignOwnerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
