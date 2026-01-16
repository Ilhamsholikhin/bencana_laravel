<?php

use App\Http\Controllers\Api\DisasterReportController;
use Illuminate\Support\Facades\Route;

Route::get('/health', fn () => response()->json(['ok' => true]));

Route::get('/disaster-types', fn () => response()->json([
    'Gempa Bumi',
    'Banjir',
    'Tanah Longsor',
    'Gunung Meletus',
    'Tsunami',
    'Kebakaran Hutan',
    'Puting Beliung',
    'Kekeringan',
]));

Route::apiResource('disaster-reports', DisasterReportController::class);
