<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;

class LanguageController extends Controller
{
    public function setLocale(User $user, string $locale): JsonResponse
    {
        session()->put('locale', $locale);
        $user->update([
            'language' => $locale,
        ]);

        return response()->json(['language' => $locale]);
    }

    public function setLocaleGuest(string $locale): JsonResponse
    {
        session()->put('locale', $locale);

        return response()->json(['language' => $locale]);
    }
}
