<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FormSubmitRequest;
use App\Models\FormSubmit;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FormSubmitController extends Controller
{
    use AuthorizesRequests;
    
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $this->authorize('viewAny', FormSubmit::class);

        /** @var User */
        $user = auth()->user();

        /** @var Collection<int, FormSubmit|null>  */
        $formSubmits = $user->hasRole('hr_coordinator')
            ? FormSubmit::query()->forHRCoordinator()->paginate() 
            : ($user->hasRole('hr_manager') ? FormSubmit::query()->forHRManager()->paginate() : collect());

        return response()->json(['formSubmits' => $formSubmits]);
    }

   /**
     * Store a newly created resource in storage.
     */
    public function store(FormSubmitRequest $request): JsonResponse
    {
        $this->authorize('create', FormSubmit::class);

        FormSubmit::create($request->safe()->merge([
            'cv' => $request->file('cv')->store('local')
        ])->toArray());

        return response()->json(['success' => 'Your form has been submitted successfully'], 200);
    }

    /**
     * Update an existing resource in storage.
     */
    public function update(Request $request, FormSubmit $formSubmit): JsonResponse
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

            return response()->json(['success' => 'The form submit has been ' . $request->approval . ' successfully'], 200);
        }

        return response()->json(['error' => 'The form submit is not ' . $request->approval]);
    }

    /**
     * Download the stored file
     * 
     * @param FormSubmit $formSubmit
     */
    public function download(FormSubmit $formSubmit): BinaryFileResponse|JsonResponse
    {
        try {
            return response()->download(Storage::path($formSubmit->cv));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Sorry! the cv could not be downloaded']);
        }
    }
}
