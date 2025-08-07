<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display a listing of the gallery.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Gallery::withTrashed()->select(['galleries.*']);

            return DataTables::of($data)
                ->addColumn('image', function ($row) {
                    return $row->image; // Only filename
                })
                ->addColumn('status', function ($row) {
                    if ($row->deleted_at) {
                        return '<span class="badge bg-secondary">Deleted</span>';
                    }
                    $badgeClass = $row->status === 'inactive' ? 'bg-danger' : 'bg-success';
                    return '<span class="badge ' . $badgeClass . '">' . ucfirst($row->status) . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $buttons = '';
                    if ($row->deleted_at) {
                        $buttons .= '
                            <form action="' . route('admin.galleries.restore', $row->id) . '" method="POST" style="display:inline;">
                                ' . csrf_field() . '
                                <button type="submit" class="btn btn-sm btn-warning">Restore</button>
                            </form>
                            <form action="' . route('admin.galleries.forceDelete', $row->id) . '" method="POST" style="display:inline;">
                                ' . csrf_field() . method_field('DELETE') . '
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Permanently delete?\')">Delete</button>
                            </form>
                        ';
                    } else {
                        $buttons .= '
                            <a href="' . route('admin.galleries.edit', $row->id) . '" class="btn btn-sm btn-primary">Edit</a>
                            <form action="' . route('admin.galleries.destroy', $row->id) . '" method="POST" style="display:inline;">
                                ' . csrf_field() . method_field('DELETE') . '
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Soft delete this?\')">Delete</button>
                            </form>
                        ';
                    }
                    return $buttons;
                })
                ->rawColumns(['image', 'status', 'action'])
                ->make(true);
        }

        return view('admin.galleries.index');
    }

    /**
     * Show the form for creating a new gallery image.
     */
    public function create()
    {
        return view('admin.galleries.create');
    }

    /**
     * Store a newly created gallery image in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:3|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png',
            'status' => 'required|in:active,inactive',
        ]);

        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $count = 1;

        while (Gallery::where('slug', $slug)->withTrashed()->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $imagePath = $request->file('image')->store('galleries', 'public');

        Gallery::create([
            'title' => $request->title,
            'slug' => $slug,
            'status' => $request->status,
            'image' => $imagePath,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Gallery image added successfully.',
                'redirect' => route('admin.galleries.index')
            ]);
        }

        return redirect()->route('admin.galleries.index')->with('success', 'Gallery image added successfully.');
    }

    /**
     * Show the form for editing the specified gallery image.
     */
    public function edit(Gallery $gallery)
    {
        return view('admin.galleries.edit', compact('gallery'));
    }

    /**
     * Update the specified gallery image in storage.
     */
    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'required|string|min:3|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
            'status' => 'required|in:active,inactive',
        ]);

        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $count = 1;

        while (
            Gallery::where('slug', $slug)
                ->where('id', '!=', $gallery->id)
                ->withTrashed()
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $count++;
        }

        $imagePath = $gallery->image;
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($gallery->image);
            $imagePath = $request->file('image')->store('galleries', 'public');
        }

        $gallery->update([
            'title' => $request->title,
            'slug' => $slug,
            'status' => $request->status,
            'image' => $imagePath,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Gallery updated successfully.',
                'redirect' => route('admin.galleries.index')
            ]);
        }

        return redirect()->route('admin.galleries.index')->with('success', 'Gallery updated successfully.');
    }

    /**
     * Soft delete the specified gallery image.
     */
    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
        return redirect()->route('admin.galleries.index')->with('success', 'Gallery image soft deleted.');
    }

    /**
     * Restore the specified gallery image.
     */
    public function restore($id)
    {
        $gallery = Gallery::onlyTrashed()->findOrFail($id);
        $gallery->restore();

        return redirect()->route('admin.galleries.index')->with('success', 'Gallery image restored successfully.');
    }

    /**
     * Permanently delete the specified gallery image.
     */
    public function forceDelete($id)
    {
        $gallery = Gallery::onlyTrashed()->findOrFail($id);
        Storage::disk('public')->delete($gallery->image);
        $gallery->forceDelete();

        return redirect()->route('admin.galleries.index')->with('success', 'Gallery image permanently deleted.');
    }

    /**
     * Bulk soft delete gallery images.
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        if (empty($ids)) {
            return response()->json(['success' => 'No images selected.']);
        }

        Gallery::whereIn('id', $ids)->delete();

        return response()->json(['success' => 'Selected gallery images have been deleted successfully.']);
    }
}