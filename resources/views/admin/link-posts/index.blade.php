@extends('layouts.admin')

@section('title', 'Life on the Links')

@section('content')
    <x-admin.data-table
        title="Life on the Links"
        description="Manage Instagram-style gallery images shown on the public homepage."
        :paginator="$linkPosts"
        :search="$search"
        :per-page="$perPage"
        :form-action="route('admin.link-posts.index')"
        :create-href="route('admin.link-posts.create')"
        create-label="Add image"
        min-width="880px"
    >
        <x-slot:head>
            <tr>
                <th class="px-6 py-3 font-medium">#</th>
                <th class="px-6 py-3 font-medium">Preview</th>
                <th class="px-6 py-3 font-medium">Alt text</th>
                <th class="px-6 py-3 font-medium">Status</th>
                <th class="px-6 py-3 text-right font-medium">Actions</th>
            </tr>
        </x-slot:head>

        @forelse ($linkPosts as $post)
            <tr class="transition-colors hover:bg-slate-50/80">
                <td class="px-6 py-4 text-slate-500">{{ ($linkPosts->firstItem() ?? 0) + $loop->index }}</td>
                <td class="px-6 py-4">
                    <img
                        src="{{ $post->image_url }}"
                        alt="{{ $post->image_alt }}"
                        class="size-14 rounded-admin-control border border-slate-200 object-cover"
                        loading="lazy"
                    >
                </td>
                <td class="max-w-xs px-6 py-4">
                    <p class="font-semibold text-slate-900">{{ $post->image_alt }}</p>
                    @if ($post->instagram_url)
                        <a href="{{ $post->instagram_url }}" target="_blank" rel="noopener" class="mt-1 block truncate text-xs text-primary hover:underline">Instagram link</a>
                    @endif
                </td>
                <td class="px-6 py-4">
                    @if ($post->is_active)
                        <span class="inline-flex rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">Active</span>
                    @else
                        <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-500">Hidden</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <x-admin.data-table-actions
                        :edit-href="route('admin.link-posts.edit', $post)"
                        :delete-action="route('admin.link-posts.destroy', $post)"
                        delete-confirm="Delete this gallery image?"
                    />
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="px-6 py-12 text-center text-slate-500">No gallery images match your search.</td>
            </tr>
        @endforelse
    </x-admin.data-table>
@endsection
