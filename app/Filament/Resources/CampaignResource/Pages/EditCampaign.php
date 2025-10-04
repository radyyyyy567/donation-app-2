<?php

namespace App\Filament\Resources\CampaignResource\Pages;

use App\Filament\Resources\CampaignResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCampaign extends EditRecord
{

    protected $organization;
    protected function mutateDataBeforeFill(array $data): array
    {
        $data['organization_id'] = $this->record->campaign_owner->organization_id ?? null;
        return $data;
    }

    protected function mutateDataBeforeSave(array $data): array
    {
        $this->organization = $data['organization_id'];
        unset($data['organization_id']);

        return $data;
    }

    protected function afterSave(): void
    {
       $this->record->campaign_owner()->updateOrCreate(
            [],
            [
                'organization_id' => $this->organization,
            ]
        );
    }
    protected static string $resource = CampaignResource::class;

   
}
