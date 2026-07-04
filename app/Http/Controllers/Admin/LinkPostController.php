<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesAdminDataTable;
use App\Http\Controllers\Admin\Concerns\HandlesUploadedImages;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLinkPostRequest;
use App\Http\Requests\Admin\UpdateLinkPostRequest;
use App\Models\LinkPost;
use App\Support\AdminCsvExport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LinkPostController extends Controller
{
    use HandlesAdminDataTable;
    use HandlesUploadedImages;

    public function index(Request $request): View|StreamedResponse
    {
        $query = LinkPost::query()
            ->ordered()
            ->search($this->searchTerm($request));

        if ($this->wantsCsvExport($request)) {
            return AdminCsvExport::download(
                $query,
                ['Order', 'Image alt', 'Image', 'Instagram URL', 'Status'],
                fn (LinkPost $post) => [
                    $post->sort_order,
                    $post->image_alt,
                    $post->image_url,
                    $post->instagram_url,
                    $post->is_active ? 'Active' : 'Hidden',
                ],
                'life-on-the-links.csv',
            );
        }

        $perPage = $this->perPage($request);

        return view('admin.link-posts.index', [
            'linkPosts' => $query->paginate($perPage)->withQueryString(),
            'search' => $this->searchTerm($request),
            'perPage' => $perPage,
        ]);
    }

    public function create(): View
    {
        return view('admin.link-posts.create');
    }

    public function store(StoreLinkPostRequest $request): RedirectResponse
    {
        LinkPost::query()->create($this->payload($request));

        return redirect()
            ->route('admin.link-posts.index')
            ->with('status', 'Life on the Links post created successfully.');
    }

    public function edit(LinkPost $linkPost): View
    {
        return view('admin.link-posts.edit', [
            'linkPost' => $linkPost,
        ]);
    }

    public function update(UpdateLinkPostRequest $request, LinkPost $linkPost): RedirectResponse
    {
        $linkPost->update($this->payload($request, $linkPost));

        return redirect()
            ->route('admin.link-posts.index')
            ->with('status', 'Life on the Links post updated successfully.');
    }

    public function destroy(LinkPost $linkPost): RedirectResponse
    {
        $linkPost->delete();

        return redirect()
            ->route('admin.link-posts.index')
            ->with('status', 'Life on the Links post deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function payload(StoreLinkPostRequest|UpdateLinkPostRequest $request, ?LinkPost $linkPost = null): array
    {
        $payload = [
            ...$request->safe()->except('image'),
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $request->integer('sort_order', 0),
        ];

        return $this->mergeUploadedImage(
            $request,
            $payload,
            'link-posts',
            $linkPost?->getRawOriginal('image_path'),
        );
    }
}
