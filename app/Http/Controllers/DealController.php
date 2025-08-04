<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use Illuminate\Http\Request;

class DealController extends Controller
{
    public function show(Deal $deal)
    {
        // TODO: Проверить права доступа к сделке
        $clientId = 1; // Временно

        if ($deal->client_id != $clientId && $deal->renter_id != $clientId) {
            abort(403);
        }

        $deal->load(['car', 'client', 'renter', 'chat.messages']);

        return view('deals.show', compact('deal'));
    }
}
