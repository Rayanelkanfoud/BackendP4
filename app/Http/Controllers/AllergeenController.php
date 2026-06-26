<?php

namespace App\Http\Controllers;

use App\Models\AllergeenModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AllergeenController extends Controller
{
    public function index(): View
    {
        return view('allergenen.index', [
            'title' => 'Allergenen',
            'allergenen' => AllergeenModel::spGetAllAllergenen(),
        ]);
    }

    public function create(): View
    {
        return view('allergenen.create', [
            'title' => 'Nieuw allergeen',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'Naam' => ['required', 'string', 'max:50'],
            'Omschrijving' => ['nullable', 'string', 'max:255'],
        ]);

        $id = AllergeenModel::spCreateAllergeen(
            $validated['Naam'],
            $validated['Omschrijving'] ?? null
        );

        return redirect()
            ->route('allergenen.index')
            ->with('success', 'Allergeen is succesvol toegevoegd met Id '.$id.'.');
    }

    public function edit(AllergeenModel $allergeen): View
    {
        $selectedAllergeen = AllergeenModel::spGetAllergeenById($allergeen->Id);

        abort_if($selectedAllergeen === null, 404);

        return view('allergenen.edit', [
            'title' => 'Allergeen wijzigen',
            'allergeen' => $selectedAllergeen,
        ]);
    }

    public function update(Request $request, AllergeenModel $allergeen): RedirectResponse
    {
        $validated = $request->validate([
            'Naam' => ['required', 'string', 'max:50'],
            'Omschrijving' => ['nullable', 'string', 'max:255'],
        ]);

        $result = AllergeenModel::spUpdateAllergeen(
            $allergeen->Id,
            $validated['Naam'],
            $validated['Omschrijving'] ?? null
        );

        if ($result !== 1) {
            return back()
                ->withInput()
                ->with('error', 'Allergeen is niet gewijzigd.');
        }

        return redirect()
            ->route('allergenen.index')
            ->with('success', 'Allergeen is succesvol gewijzigd.');
    }

    public function destroy(AllergeenModel $allergeen): RedirectResponse
    {
        $result = AllergeenModel::spDeleteAllergeen($allergeen->Id);

        if ($result !== 1) {
            return redirect()
                ->route('allergenen.index')
                ->with('error', 'Allergeen is niet verwijderd.');
        }

        return redirect()
            ->route('allergenen.index')
            ->with('success', 'Allergeen is succesvol verwijderd.');
    }
}
