<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * GET /categories - List all active categories.
     */
    public function index(Request $request)
    {
        $categories = Category::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $items = $categories->map(fn ($cat) => [
            'id'        => $cat->id,
            'code'      => $cat->code,
            'name'      => $cat->name,
            'parent_id' => $cat->parent_id,
        ]);

        return response()->json([
            'items'      => $items,
            'categories' => $items,
        ]);
    }
}
