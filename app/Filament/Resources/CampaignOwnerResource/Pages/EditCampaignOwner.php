<?php

namespace App\Filament\Resources\CampaignOwnerResource\Pages;

use App\Filament\Resources\CampaignOwnerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCampaignOwner extends EditRecord
{
    protected static string $resource = CampaignOwnerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
