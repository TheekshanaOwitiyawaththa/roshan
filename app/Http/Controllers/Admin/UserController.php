<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesAdminDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use App\Support\AdminCsvExport;
use App\Support\AdminUserGuard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UserController extends Controller
{
    use HandlesAdminDataTable;

    public function index(Request $request): View|StreamedResponse
    {
        $query = User::query()
            ->search($this->searchTerm($request))
            ->orderBy('name');

        if ($this->wantsCsvExport($request)) {
            return AdminCsvExport::download(
                $query,
                ['Name', 'Email', 'Role', 'Created'],
                fn (User $user) => [
                    $user->name,
                    $user->email,
                    $user->is_admin ? 'Admin' : 'User',
                    $user->created_at?->format('Y-m-d H:i'),
                ],
                'users.csv',
            );
        }

        $perPage = $this->perPage($request);

        return view('admin.users.index', [
            'users' => $query->paginate($perPage)->withQueryString(),
            'search' => $this->searchTerm($request),
            'perPage' => $perPage,
        ]);
    }

    public function create(): View
    {
        return view('admin.users.create');
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        User::query()->create($this->payload($request));

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'User created successfully.');
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', [
            'user' => $user,
        ]);
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        if (! $request->boolean('is_admin') && $user->is_admin) {
            AdminUserGuard::ensureCanRemoveAdminAccess($user);
        }

        $user->update($this->payload($request, $user));

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'User updated successfully.');
    }

    public function destroy(User $user): RedirectResponse
    {
        AdminUserGuard::ensureCanDelete($user);

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'User deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function payload(StoreUserRequest|UpdateUserRequest $request, ?User $user = null): array
    {
        $data = [
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'is_admin' => $user?->id === auth()->id() ? true : $request->boolean('is_admin'),
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->validated('password');
        }

        return $data;
    }
}
