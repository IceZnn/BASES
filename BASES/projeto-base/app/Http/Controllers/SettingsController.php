<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function edit(Request $request)
    {
        return view('settings.edit', [
            'preferences' => $request->user()->profile?->preferences ?? [],
        ]);
    }

    public function update(Request $request)
    {
        $preferences = $request->validate([
            'language' => ['required', 'in:pt_BR,en'],
            'theme' => ['required', 'in:light,dark'],
        ], [
            'language.required' => 'Selecione um idioma.',
            'language.in' => 'O idioma selecionado não é válido.',
            'theme.required' => 'Selecione um tema.',
            'theme.in' => 'O tema selecionado não é válido.',
        ]);

        $request->user()->profile()->updateOrCreate([], ['preferences' => $preferences]);

        return back()->with('success', 'Preferências salvas com sucesso.');
    }
}
