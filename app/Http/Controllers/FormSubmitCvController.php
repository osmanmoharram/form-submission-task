<?php

namespace App\Http\Controllers;

use App\Exceptions\MissingCvException;
use App\Models\FormSubmit;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FormSubmitCvController extends Controller
{
    use AuthorizesRequests;

    public function __invoke(FormSubmit $formSubmit): BinaryFileResponse
    {
        $this->authorize('viewAny', FormSubmit::class);

        if (! Storage::fileExists($formSubmit->cv)) {
            new MissingCvException('The submit has no cv');
        }

        return response()->file(Storage::path($formSubmit->cv));
    }
}
