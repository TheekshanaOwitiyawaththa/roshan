<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminCsvExport
{
    public const PER_PAGE_OPTIONS = [5, 10, 15, 25, 50];

    /**
     * @param  Builder<Model>  $query
     * @param  list<string>  $headers
     * @param  callable(Model): list<scalar|null>  $rowMapper
     */
    public static function download(Builder $query, array $headers, callable $rowMapper, string $filename): StreamedResponse
    {
        return response()->streamDownload(function () use ($query, $headers, $rowMapper): void {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, $headers);

            foreach ($query->cursor() as $model) {
                fputcsv($handle, $rowMapper($model));
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public static function perPage(int $requested, int $default = 10): int
    {
        return in_array($requested, self::PER_PAGE_OPTIONS, true) ? $requested : $default;
    }
}
