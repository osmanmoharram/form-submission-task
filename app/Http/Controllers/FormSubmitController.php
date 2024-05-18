<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRoleException;
use App\Http\Requests\FormSubmitRequest;
use App\Http\Requests\FormSubmitStoreRequest;
use App\Models\FormSubmit;
use App\Models\Nationality;
use App\Models\Scopes\ForRole;
use App\Models\Scopes\ForRoleScope;
use App\Models\User;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View as FacadesView;
use Spatie\Browsershot\Browsershot;
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

        /** @var LengthAwarePaginator|Collection<int|string FormSubmit> */
        $formSubmits = $user->hasRole('hr_coordinator')
            ? FormSubmit::query()->forHrCoordinator()->paginate()
            : ($user->hasRole('hr_manager') ? FormSubmit::query()->forHrManager()->paginate() : new InvalidRoleException('You do not have a valid role'));

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
            'cv' => $request->file('cv')->store('local')
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

        $request->validate(['status' => 'required|in:approved,rejected']);

        /** @var User */
        $user = auth()->user();

        /** @var string|null */
        $status = $user->hasRole('hr_coordinator')
            ? 'hr_coordinator_status'
            : ($user->hasRole('hr_manager') ? 'hr_manager_status' : new InvalidRoleException('You do not have a valid role'));

        if (is_string($status)) {
            $formSubmit->update([$status => $request->status]);

            return back()->with('success', 'The form submit has been ' . $request->status . ' successfully');
        }

        return back()->with('error', 'The form submit is not ' . $request->status);
    }
}
