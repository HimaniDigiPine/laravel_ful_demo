<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) 
        {
            $data = Category::withTrashed()->select(['id', 'name', 'slug', 'status', 'deleted_at']);

            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $buttons = '';
                    if ($row->deleted_at) {
                        // Restore and Force Delete buttons for trashed categories
                        $buttons .= '
                            <form action="'.route('admin.categories.restore', $row->id).'" method="POST" style="display:inline;">
                                '.csrf_field().'
                                <button type="submit" class="btn btn-sm btn-warning">Restore</button>
                            </form>
                            <form action="'.route('admin.categories.forceDelete', $row->id).'" method="POST" style="display:inline;">
                                '.csrf_field().method_field('DELETE').'
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Permanently delete?\')">Delete</button>
                            </form>
                        ';
                    } else {
                        // Edit and Soft Delete buttons for active categories
                        $buttons .= '
                            <a href="'.route('admin.categories.edit', $row->id).'" class="btn btn-sm btn-primary">Edit</a>
                            <form action="'.route('admin.categories.destroy', $row->id).'" method="POST" style="display:inline;">
                                '.csrf_field().method_field('DELETE').'
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Soft delete this?\')">Delete</button>
                            </form>
                        ';
                    }
                    return $buttons;
                })
                ->addColumn('status', function ($row) {
                    return $row->deleted_at
                        ? '<span class="badge bg-secondary">Deleted</span>'
                        : '<span class="badge bg-success">'.ucfirst($row->status).'</span>';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('admin.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
        'name' => 'required|string|min:3|max:255',
        'status' => 'required|in:active,inactive',
        ]);

        $slug = Str::slug($request->slug ?? $request->name);
        $originalSlug = $slug;
        $count = 1;

        // Ensure unique slug
        while (Category::where('slug', $slug)->withTrashed()->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        Category::create([
            'name' => $request->name,
            'slug' => $slug,
            'status' => $request->status,
        ]);


        if ($request->ajax()) {
            return response()->json([
                'message' => 'Category created successfully.',
                'redirect' => route('admin.categories.index')
            ]);
        }

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        // Generate slug
        $slug = Str::slug($request->slug ?? $request->name);
        $originalSlug = $slug;
        $count = 1;

        // Ensure unique slug (ignore current category ID)
        while (
            Category::where('slug', $slug)
                ->where('id', '!=', $category->id)
                ->withTrashed()
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $count++;
        }

        // Update category with generated slug
        $category->update([
            'name' => $request->name,
            'slug' => $slug,
            'status' => $request->status,
        ]);


        if ($request->ajax()) {
            return response()->json([
                'message' => 'Category updated successfully.',
                'redirect' => route('admin.categories.index')
            ]);
        }

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category soft deleted.');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('admin.categories.index')->with('success', 'Category restored successfully.');
    }

    
    /**
     * Remove the specified resource from storage.
     */
    public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();

        return redirect()->route('admin.categories.index')->with('success', 'Category permanently deleted.');
    }

     /**
     * Remove the Bluk resource from storage.
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        if (empty($ids)) {
            return response()->json(['success' => 'No categories selected.']);
        }

        // Soft delete multiple categories
        Category::whereIn('id', $ids)->delete();

        return response()->json(['success' => 'Selected categories have been deleted successfully.']);
    }
}
