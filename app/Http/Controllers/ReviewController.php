<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Deal;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create(Request $request)
    {
        $dealId = $request->get('deal_id');
        $deal = null;

        if ($dealId) {
            $deal = Deal::with(['car', 'client', 'renter'])->findOrFail($dealId);
        }

        return view('reviews.create', compact('deal'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'deal_id' => 'required|exists:deals,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        // TODO: Получить авторизованного клиента
        $clientId = 1; // Временно

        $deal = Deal::findOrFail($validated['deal_id']);

        // Проверяем, что клиент участвовал в сделке
        if ($deal->client_id != $clientId && $deal->renter_id != $clientId) {
            abort(403);
        }

        // Определяем, кто кого оценивает
        $reviewerId = $clientId;
        $reviewedId = ($deal->client_id == $clientId) ? $deal->renter_id : $deal->client_id;

        $review = Review::create([
            'deal_id' => $validated['deal_id'],
            'reviewer_id' => $reviewerId,
            'reviewed_id' => $reviewedId,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return redirect()->route('profile.index')
            ->with('success', 'Отзыв успешно добавлен');
    }
}
