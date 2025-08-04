<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Subcategory::withTrashed()->with('category')->select('subcategories.*');
            return DataTables::of($data)
                ->addColumn('category', fn($row) => $row->category->name ?? 'N/A')
                ->addColumn('status', fn($row) => $row->deleted_at 
                    ? '<span class="badge bg-secondary">Deleted</span>' 
                    : '<span class="badge bg-success">'.$row->status.'</span>'
                )
                ->addColumn('action', function ($row) {
                    if ($row->deleted_at) {
                        return '
                            <form action="'.route('admin.subcategories.restore', $row->id).'" method="POST" style="display:inline;">
                                '.csrf_field().'
                                <button type="submit" class="btn btn-warning btn-sm">Restore</button>
                            </form>
                            <form action="'.route('admin.subcategories.forceDelete', $row->id).'" method="POST" style="display:inline;">
                                '.csrf_field().method_field('DELETE').'
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        ';
                    }
                    return '
                        <a href="'.route('admin.subcategories.edit', $row->id).'" class="btn btn-primary btn-sm">Edit</a>
                        <form action="'.route('admin.subcategories.destroy', $row->id).'" method="POST" style="display:inline;">
                            '.csrf_field().method_field('DELETE').'
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    ';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('admin.subcategories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.subcategories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:active,inactive',
        ]);

        $slug = Str::slug($request->slug ?? $request->name);
        $originalSlug = $slug;
        $count = 1;
        while (Subcategory::where('slug', $slug)->withTrashed()->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        Subcategory::create([
            'name' => $request->name,
            'slug' => $slug,
            'category_id' => $request->category_id,
            'status' => $request->status,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Subcategory created successfully.',
                'redirect' => route('admin.subcategories.index')
            ]);
        }


        return redirect()->route('admin.subcategories.index')->with('success', 'Subcategory created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subcategory $subcategory)
    {
        $categories = Category::all();
        return view('admin.subcategories.edit', compact('subcategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subcategory $subcategory)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:active,inactive',
        ]);

        $slug = Str::slug($request->slug ?? $request->name);
        $originalSlug = $slug;
        $count = 1;
        while (Subcategory::where('slug', $slug)->where('id', '!=', $subcategory->id)->withTrashed()->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $subcategory->update([
            'name' => $request->name,
            'slug' => $slug,
            'category_id' => $request->category_id,
            'status' => $request->status,
        ]);


        if ($request->ajax()) {
            return response()->json([
                'message' => 'Subcategory updated successfully.',
                'redirect' => route('admin.subcategories.index')
            ]);
        }

        return redirect()->route('admin.subcategories.index')->with('success', 'Subcategory updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subcategory $subcategory)
    {
        $subcategory->delete();
        return redirect()->route('admin.subcategories.index')->with('success', 'Subcategory deleted successfully.');
    }

    /**
     * Remove the Bluk resource from storage.
     */
    public function bulkDelete(Request $request)
    {
        Subcategory::whereIn('id', $request->ids)->delete();
        return response()->json(['success' => 'Selected subcategories deleted successfully.']);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore($id)
    {
        Subcategory::withTrashed()->findOrFail($id)->restore();
        return redirect()->route('admin.subcategories.index')->with('success', 'Subcategory restored successfully.');
    }

     /**
     * Remove the specified resource from storage.
     */
    public function forceDelete($id)
    {
        Subcategory::withTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('admin.subcategories.index')->with('success', 'Subcategory permanently deleted.');
    }
}
