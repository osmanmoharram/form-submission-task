<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormSubmitRequest;
use App\Http\Requests\FormSubmitStoreRequest;
use App\Models\FormSubmit;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class FormSubmitController extends Controller
{
    use AuthorizesRequests;

    // authentication
    // api
    // tests
    // phpstan
    // views

    public function __construct()
    {
        $this->authorizeResource(FormSubmit::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        if (auth()->user()->hasRole('hr_coordinator')) {
            /** @var string */
            $status = 'hr_coordinator_status';
        } elseif (auth()->user()->hasRole('hr_manager')) {
            /** @var string */
            $status = 'hr_manager_status';
        }

        /** @var Collection<int, FormSubmit>  */
        $submits = FormSubmit::whereIn($status, [null, 'rejected']);

        return view('submits.index', compact('submits'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FormSubmitRequest $request): RedirectResponse
    {
        FormSubmit::create($request->validated());

        return back()->with('success', 'Your form has been submitted successfully');
    }

    /**
     * Update an existing resource in storage.
     */
    public function update(Request $request, FormSubmit $formSubmit): RedirectResponse
    {
        if (auth()->user()->hasRole('hr_coordinator')) {
            /** @var string */
            $status = 'hr_coordinator_status';
        } elseif (auth()->user()->hasRole('hr_manager')) {
            /** @var string */
            $status = 'hr_manager_status';
        }

        $request->validate([$status => 'required|in:accepted,rejected']);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FormSubmit $formSubmit): RedirectResponse
    {
        $formSubmit->delete();

        return back()->with('success', 'The form submit has been deleted successfully');
    }
}
