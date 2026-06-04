<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PraktijkmanagementController extends Controller
{
    private const ROLES = [
        'tandarts',
        'mondhygienist',
        'assistent',
        'praktijkmanagement',
        'patient',
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('Praktijkmanagement.index', [
            'title' => 'Praktijkmanagement Home',
            'users' => User::orderBy('name')->get(),
            'roles' => self::ROLES,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function updateRole(Request $request, User $user): RedirectResponse
    {
        if (auth()->id() === $user->id) {
            return redirect()
                ->route('praktijkmanagement.index')
                ->with('status', 'Je kunt je eigen rol hier niet wijzigen.');
        }

        $validated = $request->validate([
            'rolename' => ['required', 'string', 'in:'.implode(',', self::ROLES)],
        ]);

        $user->update([
            'rolename' => $validated['rolename'],
        ]);

        return redirect()
            ->route('praktijkmanagement.index')
            ->with('status', 'Gebruikersrol gewijzigd.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        if (auth()->id() === $user->id) {
            return redirect()
                ->route('praktijkmanagement.index')
                ->with('status', 'Je kunt je eigen account niet verwijderen.');
        }

        $user->delete();

        return redirect()
            ->route('praktijkmanagement.index')
            ->with('status', 'Gebruiker verwijderd.');
    }
}
