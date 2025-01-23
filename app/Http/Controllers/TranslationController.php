<?php

namespace App\Http\Controllers;

use App\Models\Translation;
use App\Services\TranslationService;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Exception;

class TranslationController extends Controller
{
    private TranslationService $translationService;

    public function __construct(TranslationService $translationService)
    {
        $this->translationService = $translationService;
    }

    /**
     * List translations with optional filtering.
     */
    public function index(Request $request)
    {
        try {
            $translations = $this->translationService->getTranslations($request->all());
            return response()->json($translations, 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Create a new translation entry.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'key' => 'required|string|max:255',
                'content' => 'required|string',
                'locale' => 'required|string|max:5',
                'tag' => 'nullable|string|in:mobile,desktop,web',
            ]);

            $translation = $this->translationService->createTranslation($validated);
            return response()->json($translation, 201);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Database query error: ' . $e->getMessage()], 500);
        } catch (Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Retrieve a specific translation.
     */
    public function show($id)
    {
        try {
            $translation = $this->translationService->findTranslationById($id);
            return response()->json($translation, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Translation not found'], 404);
        }
    }

    /**
     * Update a translation.
     */
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'content' => 'required|string',
            ]);

            $translation = $this->translationService->updateTranslation($id, $validated['content']);
            return response()->json($translation, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Translation not found'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Delete a translation.
     */
    public function destroy($id)
    {
        try {
            $this->translationService->deleteTranslation($id);
            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Translation not found'], 404);
        }
    }

    /**
     * Export all translations.
     */
    public function export()
    {
        try {
            $translations = $this->translationService->exportTranslations();
            return response()->json($translations, 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred: ' . $e->getMessage()], 500);
        }
    }
}
