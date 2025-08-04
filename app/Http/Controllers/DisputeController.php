<?php

namespace App\Http\Controllers;

use App\Models\Dispute;
use App\Models\Deal;
use Illuminate\Http\Request;

class DisputeController extends Controller
{
    public function index()
    {
        // TODO: Получить авторизованного клиента
        $clientId = 1; // Временно

        $disputes = Dispute::where(function ($query) use ($clientId) {
            $query->where('initiator_id', $clientId)
                ->orWhere('respondent_id', $clientId);
        })
            ->with(['deal.car', 'deal.client', 'deal.renter'])
            ->latest()
            ->paginate(10);

        return view('disputes.index', compact('disputes'));
    }

    public function create(Request $request)
    {
        $dealId = $request->get('deal_id');
        $deal = null;

        if ($dealId) {
            $deal = Deal::with(['car', 'client', 'renter'])->findOrFail($dealId);
        }

        return view('disputes.create', compact('deal'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'deal_id' => 'required|exists:deals,id',
            'reason' => 'required|string|max:1000',
            'description' => 'required|string|max:1000',
            'evidence.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // TODO: Получить авторизованного клиента
        $clientId = 1; // Временно

        // Получаем сделку для определения ответчика
        $deal = Deal::findOrFail($validated['deal_id']);

        $dispute = Dispute::create([
            'deal_id' => $validated['deal_id'],
            'initiator_id' => $clientId,
            'respondent_id' => $deal->client_id, // Предполагаем, что инициатор - арендатор
            'type' => $validated['reason'],
            'description' => $validated['description'],
            'status' => 'open',
        ]);

        // Загрузка доказательств
        if ($request->hasFile('evidence')) {
            $evidencePaths = [];
            foreach ($request->file('evidence') as $file) {
                $path = $file->store('disputes', 'public');
                $evidencePaths[] = $path;
            }
            $dispute->update(['metadata' => ['evidence' => $evidencePaths]]);
        }

        // TODO: Отправить уведомление администратору и участникам сделки

        return redirect()->route('disputes.show', $dispute)
            ->with('success', 'Спор создан и отправлен на рассмотрение');
    }

    public function show(Dispute $dispute)
    {
        // TODO: Проверить права доступа к спору
        $clientId = 1; // Временно

        if ($dispute->initiator_id != $clientId && $dispute->respondent_id != $clientId) {
            abort(403);
        }

        $dispute->load(['deal.car', 'deal.client', 'deal.renter']);

        return view('disputes.show', compact('dispute'));
    }

    public function edit(Dispute $dispute)
    {
        // TODO: Проверить права доступа к спору
        $clientId = 1; // Временно

        if ($dispute->initiator_id != $clientId && $dispute->respondent_id != $clientId) {
            abort(403);
        }

        if ($dispute->status !== 'open') {
            abort(403, 'Только открытые споры можно редактировать');
        }

        $dispute->load(['deal.car', 'deal.client', 'deal.renter']);

        return view('disputes.edit', compact('dispute'));
    }

    public function update(Request $request, Dispute $dispute)
    {
        // TODO: Проверить права доступа к спору
        $clientId = 1; // Временно

        if ($dispute->initiator_id != $clientId && $dispute->respondent_id != $clientId) {
            abort(403);
        }

        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'evidence.*' => 'nullable|file|mimes:jpeg,png,jpg,pdf,doc,docx|max:2048',
        ]);

        $dispute->update([
            'type' => $validated['type'],
            'description' => $validated['description'],
        ]);

        // Добавление новых доказательств
        if ($request->hasFile('evidence')) {
            $existingEvidence = $dispute->metadata['evidence'] ?? [];
            foreach ($request->file('evidence') as $file) {
                $path = $file->store('disputes', 'public');
                $existingEvidence[] = $path;
            }
            $dispute->update(['metadata' => ['evidence' => $existingEvidence]]);
        }

        return redirect()->route('disputes.show', $dispute)
            ->with('success', 'Спор обновлен');
    }
}
