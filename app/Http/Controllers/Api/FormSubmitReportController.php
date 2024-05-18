<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FormSubmit;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Spatie\Browsershot\Browsershot;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FormSubmitReportController extends Controller
{
    use AuthorizesRequests;

    public function show()
    {
        $this->authorize('viewReport', FormSubmit::class);

        $formSubmits = FormSubmit::paginate();

        return response()->json(['formSubmit' => $formSubmits]);
    }
    
    public function export(): StreamedResponse
    {
        $this->authorize('viewReport', FormSubmit::class);

        $formSubmits = FormSubmit::paginate();

        $html = view('formSubmits.report', compact('formSubmits'), ['format' => 'A4', 'orientation' => 'portrait'])->render();

        return response()->stream(function () use ($html) {
            echo Browsershot::html($html)
                ->waitUntilNetworkIdle()
                ->setNodeBinary('/home/osman/.nvm/versions/node/v20.12.1/bin/node')
                ->setNpmBinary('/home/osman/.nvm/versions/node/v20.12.1/bin/npm')
                ->margins(5, 5, 5, 5)
                ->showBackground()
                ->setContentUrl(url('/'))
                ->timeout(120)
                ->pdf();
        }, 200, ['Content-Type' => 'application/pdf']);
    }
}
