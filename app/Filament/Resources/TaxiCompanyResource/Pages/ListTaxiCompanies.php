<?php

namespace App\Filament\Resources\TaxiCompanyResource\Pages;

use App\Filament\Resources\TaxiCompanyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTaxiCompanies extends ListRecords
{
    protected static string $resource = TaxiCompanyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
