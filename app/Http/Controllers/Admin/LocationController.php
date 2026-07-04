<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesAdminDataTable;
use App\Http\Controllers\Admin\Concerns\HandlesUploadedImages;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLocationRequest;
use App\Http\Requests\Admin\UpdateLocationRequest;
use App\Models\Location;
use App\Support\AdminCsvExport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LocationController extends Controller
{
    use HandlesAdminDataTable;
    use HandlesUploadedImages;

    public function index(Request $request): View|StreamedResponse
    {
        $query = Location::query()
            ->ordered()
            ->search($this->searchTerm($request));

        if ($this->wantsCsvExport($request)) {
            return AdminCsvExport::download(
                $query,
                ['Order', 'Name', 'Address', 'Status', 'Map URL'],
                fn (Location $location) => [
                    $location->sort_order,
                    $location->name,
                    $location->address,
                    $location->is_active ? 'Active' : 'Hidden',
                    $location->map_url,
                ],
                'locations.csv',
            );
        }

        $perPage = $this->perPage($request);

        return view('admin.locations.index', [
            'locations' => $query->paginate($perPage)->withQueryString(),
            'search' => $this->searchTerm($request),
            'perPage' => $perPage,
        ]);
    }

    public function create(): View
    {
        return view('admin.locations.create');
    }

    public function store(StoreLocationRequest $request): RedirectResponse
    {
        Location::query()->create($this->payload($request));

        return redirect()
            ->route('admin.locations.index')
            ->with('status', 'Location created successfully.');
    }

    public function edit(Location $location): View
    {
        return view('admin.locations.edit', [
            'location' => $location,
        ]);
    }

    public function update(UpdateLocationRequest $request, Location $location): RedirectResponse
    {
        $location->update($this->payload($request, $location));

        return redirect()
            ->route('admin.locations.index')
            ->with('status', 'Location updated successfully.');
    }

    public function destroy(Location $location): RedirectResponse
    {
        $location->delete();

        return redirect()
            ->route('admin.locations.index')
            ->with('status', 'Location deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function payload(StoreLocationRequest|UpdateLocationRequest $request, ?Location $location = null): array
    {
        $payload = [
            ...$request->safe()->except('image'),
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $request->integer('sort_order', 0),
        ];

        return $this->mergeUploadedImage(
            $request,
            $payload,
            'locations',
            $location?->getRawOriginal('image_path'),
        );
    }
}
