<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesAdminDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCoachingProgramRequest;
use App\Http\Requests\Admin\UpdateCoachingProgramRequest;
use App\Models\CoachingProgram;
use App\Support\AdminCsvExport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CoachingProgramController extends Controller
{
    use HandlesAdminDataTable;

    public function index(Request $request): View|StreamedResponse
    {
        $query = CoachingProgram::query()
            ->ordered()
            ->search($this->searchTerm($request));

        if ($this->wantsCsvExport($request)) {
            return AdminCsvExport::download(
                $query,
                ['Order', 'Title', 'Icon', 'Status', 'Description'],
                fn (CoachingProgram $program) => [
                    $program->sort_order,
                    $program->title,
                    $program->icon,
                    $program->is_active ? 'Active' : 'Hidden',
                    $program->description,
                ],
                'coaching-programs.csv',
            );
        }

        $perPage = $this->perPage($request);

        return view('admin.coaching-programs.index', [
            'programs' => $query->paginate($perPage)->withQueryString(),
            'search' => $this->searchTerm($request),
            'perPage' => $perPage,
        ]);
    }

    public function create(): View
    {
        return view('admin.coaching-programs.create');
    }

    public function store(StoreCoachingProgramRequest $request): RedirectResponse
    {
        CoachingProgram::query()->create($this->payload($request));

        return redirect()
            ->route('admin.coaching-programs.index')
            ->with('status', 'Coaching program created successfully.');
    }

    public function edit(CoachingProgram $coachingProgram): View
    {
        return view('admin.coaching-programs.edit', [
            'program' => $coachingProgram,
        ]);
    }

    public function update(UpdateCoachingProgramRequest $request, CoachingProgram $coachingProgram): RedirectResponse
    {
        $coachingProgram->update($this->payload($request));

        return redirect()
            ->route('admin.coaching-programs.index')
            ->with('status', 'Coaching program updated successfully.');
    }

    public function destroy(CoachingProgram $coachingProgram): RedirectResponse
    {
        $coachingProgram->delete();

        return redirect()
            ->route('admin.coaching-programs.index')
            ->with('status', 'Coaching program deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function payload(StoreCoachingProgramRequest|UpdateCoachingProgramRequest $request): array
    {
        return [
            ...$request->validated(),
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $request->integer('sort_order', 0),
        ];
    }
}
