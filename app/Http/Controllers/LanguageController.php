<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class LanguageController extends Controller
{
    public function setLocale(string $locale): RedirectResponse
    {
        session()->put('locale', $locale);
        return redirect()->back();
    }
}
