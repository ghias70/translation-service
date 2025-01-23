<?php

namespace App\Services;

use App\Models\Translation;
use Illuminate\Support\Facades\Cache;

class TranslationService
{
    /**
     * Retrieve filtered translations.
     */
    public function getTranslations(array $filters)
    {
        return Translation::select(['id', 'key', 'content', 'locale', 'tag'])
            ->when(isset($filters['tag']), fn($query) => $query->where('tag', $filters['tag']))
            ->when(isset($filters['key']), fn($query) => $query->where('key', 'like', "%{$filters['key']}%"))
            ->when(isset($filters['content']), fn($query) => $query->where('content', 'like', "%{$filters['content']}%"))
            ->paginate(50);
    }

    /**
     * Create a new translation.
     */
    public function createTranslation(array $data)
    {
        return Translation::create($data);
    }

    /**
     * Find a translation by ID.
     */
    public function findTranslationById(int $id)
    {
        return Translation::findOrFail($id);
    }

    /**
     * Update a translation by ID.
     */
    public function updateTranslation(int $id, string $content)
    {
        $translation = $this->findTranslationById($id);
        $translation->update(['content' => $content]);
        return $translation;
    }

    /**
     * Delete a translation by ID.
     */
    public function deleteTranslation(int $id)
    {
        $translation = $this->findTranslationById($id);
        $translation->delete();
    }

    /**
     * Export all translations.
     */
    public function exportTranslations()
    {
        return Cache::remember('translations_export', 3600, function () {
            return Translation::select(['key', 'locale', 'content'])->get();
        });
    }
}
