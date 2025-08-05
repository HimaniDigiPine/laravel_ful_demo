<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) 
        {
            $data = Product::withTrashed()
                ->with(['category', 'subcategory'])
                ->select(['products.*']);

            return DataTables::of($data)
                ->addColumn('category', fn($row) => $row->category->name ?? 'N/A')
                ->addColumn('subcategory', fn($row) => $row->subcategory->name ?? 'N/A')
                ->addColumn('price', fn($row) => '$'.$row->price)
                ->addColumn('status', function ($row) {
                    if ($row->deleted_at) {
                        return '<span class="badge bg-secondary">Deleted</span>';
                    }

                    $badgeClass = $row->status === 'inactive' ? 'bg-danger' : 'bg-success';
                    return '<span class="badge '.$badgeClass.'">'.ucfirst($row->status).'</span>';
                })
                ->addColumn('action', function ($row) {
                    $buttons = '';
                    if ($row->deleted_at) {
                        $buttons .= '
                            <form action="'.route('admin.products.restore', $row->id).'" method="POST" style="display:inline;">
                                '.csrf_field().'
                                <button type="submit" class="btn btn-sm btn-warning">Restore</button>
                            </form>
                            <form action="'.route('admin.products.forceDelete', $row->id).'" method="POST" style="display:inline;">
                                '.csrf_field().method_field('DELETE').'
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Permanently delete?\')">Delete</button>
                            </form>
                        ';
                    } else {
                        $buttons .= '
                            <a href="'.route('admin.products.edit', $row->id).'" class="btn btn-sm btn-primary">Edit</a>
                            <form action="'.route('admin.products.destroy', $row->id).'" method="POST" style="display:inline;">
                                '.csrf_field().method_field('DELETE').'
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Soft delete this?\')">Delete</button>
                            </form>
                        ';
                    }
                    return $buttons;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('admin.products.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('admin.products.create', compact('categories', 'subcategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:subcategories,id',
            'price' => 'required|numeric',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpg,jpeg,png'
        ]);

        $slug = Str::slug($request->slug ?? $request->name);
        $originalSlug = $slug;
        $count = 1;

        while (Product::where('slug', $slug)->withTrashed()->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $imagePath = $request->file('image')?->store('products', 'public');

        Product::create([
            'name' => $request->name,
            'slug' => $slug,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'description' => $request->description,
            'price' => $request->price,
            'status' => $request->status,
            'image' => $imagePath,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Product created successfully.',
                'redirect' => route('admin.products.index')
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('admin.products.edit', compact('product', 'categories', 'subcategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:subcategories,id',
            'price' => 'required|numeric',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpg,jpeg,png'
        ]);

        $slug = Str::slug($request->slug ?? $request->name);
        $originalSlug = $slug;
        $count = 1;

        while (
            Product::where('slug', $slug)
                ->where('id', '!=', $product->id)
                ->withTrashed()
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $count++;
        }

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name' => $request->name,
            'slug' => $slug,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'description' => $request->description,
            'price' => $request->price,
            'status' => $request->status,
            'image' => $imagePath,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Product updated successfully.',
                'redirect' => route('admin.products.index')
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Soft delete the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product soft deleted.');
    }

    /**
     * Restore the specified resource.
     */
    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->route('admin.products.index')->with('success', 'Product restored successfully.');
    }

    /**
     * Permanently delete the specified resource.
     */
    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->forceDelete();

        return redirect()->route('admin.products.index')->with('success', 'Product permanently deleted.');
    }

    /**
     * Bulk soft delete products.
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        if (empty($ids)) {
            return response()->json(['success' => 'No products selected.']);
        }

        Product::whereIn('id', $ids)->delete();

        return response()->json(['success' => 'Selected products have been deleted successfully.']);
    }

    /**
     * Get Subcategories for Category
     */
    public function getSubcategories($categoryId)
    {
        $subcategories = Subcategory::where('category_id', $categoryId)
            ->where('status', 'active')
            ->get();

        return response()->json($subcategories);
    }
}