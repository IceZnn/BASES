<?php

namespace App\Http\Controllers;

use App\Services\UploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('profile.edit', ['user' => $request->user()->load('profile')]);
    }

    public function update(Request $request, UploadService $uploads)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$request->user()->id],
            'phone' => ['nullable', 'string', 'max:30'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'bio' => ['nullable', 'string', 'max:2000'],
            'address' => ['nullable', 'string', 'max:255'],
        ], [
            'name.required' => 'Informe seu nome.',
            'email.email' => 'Informe um e-mail válido.',
            'photo.image' => 'O arquivo deve ser uma imagem.',
        ]);

        $user = $request->user();
        if ($request->hasFile('photo')) {
            $data['photo'] = $uploads->replace($request->file('photo'), $user->photo, 'users');
        }
        $user->update(collect($data)->only(['name', 'email', 'phone', 'photo'])->all());
        $user->profile()->updateOrCreate([], collect($data)->only(['bio', 'address'])->all());

        return back()->with('success', 'Perfil atualizado com sucesso.');
    }

    public function updatePassword(Request $request)
    {
        $data = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.current_password' => 'A senha atual não confere.',
            'password.min' => 'A nova senha deve ter pelo menos 8 caracteres.',
            'password.confirmed' => 'A confirmação da senha não confere.',
        ]);

        $request->user()->update(['password' => Hash::make($data['password'])]);

        return back()->with('success', 'Senha alterada com sucesso.');
    }
}
