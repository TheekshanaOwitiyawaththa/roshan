<?php

namespace App\Http\Controllers\Admin\Concerns;

use App\Support\AdminCsvExport;
use Illuminate\Http\Request;

trait HandlesAdminDataTable
{
    protected function searchTerm(Request $request): string
    {
        return $request->string('q')->toString();
    }

    protected function perPage(Request $request, int $default = 10): int
    {
        return AdminCsvExport::perPage($request->integer('per_page', $default), $default);
    }

    protected function wantsCsvExport(Request $request): bool
    {
        return $request->string('export')->toString() === 'csv';
    }
}
