<?php

namespace App\Filament\Resources\CampaignResource\Pages;

use App\Filament\Resources\CampaignResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCampaign extends CreateRecord
{
       protected $organization;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->organization = $data['organization_id'];
        unset($data['organization_id']);

        return $data;
    }

    protected function afterCreate(): void
    {
       $this->record->campaign_owner()->create([
            'organization_id' => $this->organization,
        ]);
    }
    protected static string $resource = CampaignResource::class;
}
