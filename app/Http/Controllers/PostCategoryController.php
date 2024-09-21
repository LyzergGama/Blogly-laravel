<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostCategoryController extends Controller
{
    /**
     * Create a new post category.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return $this->sendErrorResponse('Validation error', 400, $validator->errors());
        }

        try {
            $category = PostCategory::create([
                'name' => $request->input('name'),
            ]);

            return $this->sendSuccessResponse('Category created successfully', $category);
        } catch (\Exception $e) {
            return $this->sendErrorResponse('An error occurred while creating the category', 500);
        }
    }

    /**
     * Update an existing post category.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return $this->sendErrorResponse('Validation error', 400, $validator->errors());
        }

        try {
            $category = PostCategory::findOrFail($id);
            $category->name = $request->input('name');
            $category->save();

            return $this->sendSuccessResponse('Category updated successfully', $category);
        } catch (\Exception $e) {
            return $this->sendErrorResponse('Category not found or could not be updated', 404);
        }
    }

    /**
     * Delete a post category.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        try {
            $category = PostCategory::findOrFail($id);
            $category->delete();

            return $this->sendSuccessResponse('Category deleted successfully');
        } catch (\Exception $e) {
            return $this->sendErrorResponse('Category not found or could not be deleted', 404);
        }
    }

    /**
     * List all post categories.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $categories = PostCategory::all();
        return $this->sendSuccessResponse('Categories retrieved successfully', $categories);
    }

    /**
     * Helper function to send a success response.
     */
    protected function sendSuccessResponse($message, $data = null)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ]);
    }

    /**
     * Helper function to send an error response.
     */
    protected function sendErrorResponse($message, $statusCode, $errors = null)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $statusCode);
    }
}
