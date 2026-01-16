<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DisasterReport;
use Illuminate\Http\Request;

class DisasterReportController extends Controller
{
    public function index(Request $request)
    {
        $q = DisasterReport::query()
            ->when($request->string('type')->toString() !== '', fn ($query) =>
                $query->where('type', $request->string('type')->toString())
            )
            ->when($request->string('search')->toString() !== '', function ($query) use ($request) {
                $s = $request->string('search')->toString();
                $query->where(function ($sub) use ($s) {
                    $sub->where('title', 'like', "%{$s}%")
                        ->orWhere('location', 'like', "%{$s}%")
                        ->orWhere('description', 'like', "%{$s}%");
                });
            })
            ->orderByDesc('occurred_at')
            ->orderByDesc('id');

        return response()->json($q->paginate(20));
    }

    public function store(Request $request)
    {
        $data = $this->validatePayload($request);
        $report = DisasterReport::create($data);
        return response()->json($report, 201);
    }

    public function show(DisasterReport $disasterReport)
    {
        return response()->json($disasterReport);
    }

    public function update(Request $request, DisasterReport $disasterReport)
    {
        $data = $this->validatePayload($request);
        $disasterReport->fill($data)->save();
        return response()->json($disasterReport);
    }

    public function destroy(DisasterReport $disasterReport)
    {
        $disasterReport->delete();
        return response()->json(['deleted' => true]);
    }

    private function validatePayload(Request $request): array
    {
        // rapihin input optional biar user bisa isi "www.google.com"
        $request->merge([
            'source_url' => $this->normalizeUrl($request->input('source_url')),
            'casualties' => $this->normalizeInt($request->input('casualties')),
        ]);

        return $request->validate([
            'title'       => ['required', 'string', 'max:120'],
            'type'        => ['required', 'string', 'max:50'],
            'location'    => ['required', 'string', 'max:120'],
            'occurred_at' => ['required', 'date'],
            'severity'    => ['required', 'integer', 'min:1', 'max:5'],
            'status'      => ['required', 'string', 'max:30'],
            'description' => ['nullable', 'string'],
            'casualties'  => ['nullable', 'integer', 'min:0'],
            'source_url'  => ['nullable', 'url', 'max:255'],
        ]);
    }

    private function normalizeUrl($url): ?string
    {
        $url = trim((string) $url);
        if ($url === '') return null;

        // kalau user nulis tanpa http/https → tambahin https://
        if (!preg_match('#^https?://#i', $url)) {
            $url = 'https://' . $url;
        }
        return $url;
    }

    private function normalizeInt($v): ?int
    {
        if ($v === null) return null;
        $s = trim((string) $v);
        if ($s === '') return null;

        // kalau bukan angka, jadikan null biar tidak bikin validasi gagal
        if (!ctype_digit($s)) return null;

        return (int) $s;
    }
}
