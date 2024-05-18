<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\InvalidRoleException;
use App\Http\Controllers\Controller;
use App\Http\Requests\FormSubmitRequest;
use App\Models\FormSubmit;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;
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

        /** @var LengthAwarePaginator|Collection<int|string FormSubmit> */
        $formSubmits = $user->tokenCan('coordinate')
            ? FormSubmit::query()->forHrCoordinator()->paginate()
            : ($user->tokenCan('manage') ? FormSubmit::query()->forHrManager()->paginate() : new InvalidRoleException('You do not have a valid role'));

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

        $request->validate(['status' => 'required|in:approved,rejected']);

        /** @var User */
        $user = auth()->user();
        
        /** @var string|null */
        $status = $user->tokenCan('coordinate')
            ? 'hr_coordinator_status'
            : ($user->tokenCan('manage') ? 'hr_manager_status' : new InvalidRoleException('You do not have a valid role'));

        if (is_string($status)) {
            $formSubmit->update([$status => $request->status]);

            return response()->json(['success' => 'The form submit has been ' . $request->status . ' successfully'], 200);
        }

        return response()->json(['error' => 'The form submit is not ' . $request->status]);
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
