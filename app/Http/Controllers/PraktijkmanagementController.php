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
            'users' => User::spGetAllUsers(),
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
    public function edit(User $user): View
    {
        abort_if(auth()->id() === $user->id, 403, 'Je kunt je eigen rol hier niet wijzigen.');

        $selectedUser = User::spGetUserById($user->id);

        abort_if($selectedUser === null, 404);

        return view('Praktijkmanagement.edit', [
            'title' => 'Gebruikersrol wijzigen',
            'user' => $selectedUser,
            'roles' => User::spGetAllUserroles(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        return $this->updateRole($request, $user);
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

        User::spUpdateUserRole($user->id, $validated['rolename']);

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

        User::spDeleteUser($user->id);

        return redirect()
            ->route('praktijkmanagement.index')
            ->with('status', 'Gebruiker verwijderd.');
    }
}
