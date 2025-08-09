<?php

namespace App\Filament\Resources\TaxiCompanyResource\Pages;

use App\Filament\Resources\TaxiCompanyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTaxiCompany extends EditRecord
{
    protected static string $resource = TaxiCompanyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
