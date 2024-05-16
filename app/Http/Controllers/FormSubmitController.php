<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormSubmitRequest;
use App\Http\Requests\FormSubmitStoreRequest;
use App\Models\FormSubmit;
use App\Models\Nationality;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FormSubmitController extends Controller
{
    use AuthorizesRequests;

    // api
    // tests
    // phpstan

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $this->authorize('viewAny', FormSubmit::class);

        /** @var User */
        $user = auth()->user();

        /** @var Collection<int, FormSubmit|null>  */
        $formSubmits = $user->hasRole('hr_coordinator')
            ? FormSubmit::query()->forHRCoordinator()->paginate() 
            : ($user->hasRole('hr_manager') ? FormSubmit::query()->forHRManager()->paginate() : collect());

        return view('formSubmits.index', compact('formSubmits'));
    }

    /**
     * Shows resource create form.
     */
    public function create(): View
    {
        $this->authorize('create', FormSubmit::class);

        $nationalities = Nationality::all();

        return view('formSubmits.create', compact('nationalities'));
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param FormSubmitRequest $request
     */
    public function store(FormSubmitRequest $request): RedirectResponse
    {
        $this->authorize('create', FormSubmit::class);

        FormSubmit::create($request->safe()->merge([
            'cv' => $request->file('cv')->store('public')
        ])->toArray());

        return back()->with('success', 'Your form has been submitted successfully');
    }

    /**
     * Update an existing resource in storage.
     * 
     * @param Request $request
     * @param FormSubmit $formSubmit
     */
    public function update(Request $request, FormSubmit $formSubmit): RedirectResponse
    {
        $this->authorize('update', $formSubmit);

        $request->validate(['approval' => 'required|in:approved,rejected']);

        /** @var User */
        $user = auth()->user();

        /** @var string|null */
        $approval = $user->hasRole('hr_coordinator')
            ? 'hr_coordinator_approval'
            : ($user->hasRole('hr_manager') ? 'hr_manager_approval' : null);

        if (is_string($approval)) {
            $formSubmit->update([$approval => $request->approval]);

            return back()->with('success', 'The form submit has been ' . $request->approval);
        }

        return back()->with('error', 'There was an error! please if all data is correct and try again');
    }

    /**
     * Download the stored file
     * 
     * @param FormSubmit $formSubmit
     */
    public function download(FormSubmit $formSubmit): BinaryFileResponse
    {
        try {
            return response()->download(Storage::path($formSubmit->cv));
        } catch (\Exception $e) {
            return back()->with('Sorry, the cv could not be downloaded');
        }
    }
}
