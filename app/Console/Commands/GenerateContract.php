<?php

namespace App\Console\Commands;

use App\Models\Deal;
use App\Services\ContractGeneratorService;
use Illuminate\Console\Command;

class GenerateContract extends Command
{
    protected $signature = 'contract:generate {deal_id}';
    protected $description = 'Generate PDF contract for a deal';

    public function handle(ContractGeneratorService $contractService)
    {
        $dealId = $this->argument('deal_id');

        $deal = Deal::with(['car', 'client', 'renter'])->find($dealId);

        if (!$deal) {
            $this->error("Deal with ID {$dealId} not found!");
            return 1;
        }

        try {
            $contractPath = $contractService->generateContract($deal);

            $deal->update(['contract_path' => $contractPath]);

            $this->info("Contract generated successfully!");
            $this->info("Path: {$contractPath}");
        } catch (\Exception $e) {
            $this->error("Failed to generate contract: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
