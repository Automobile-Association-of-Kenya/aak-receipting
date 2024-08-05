<?php

namespace App\Http\Controllers;
use App\Models\trans_references;
use Illuminate\Http\Request;

class NewTransReferencesController extends Controller
{
    //
    public function getTransDetails(Request $request)
{
    $query = $request->get('q', ''); // Search query
    $limit = $request->get('limit', 500); // Number of records per page
    $page = $request->get('page', 1); // Current page number

    // Define pagination parameters
    $limitPerPage = $limit;
    $offset = ($page - 1) * $limitPerPage;

    // Query to fetch transactions based on search query and sort by latest
    $transDetails = trans_references::where(function($queryBuilder) use ($query) {
            $queryBuilder->where('TransID', 'LIKE', "%{$query}%")
                         ->orWhere('TransAmount', 'LIKE', "%{$query}%");
        })
        ->orderBy('updated_at', 'desc') // Assuming 'updated_at' is the column to determine the latest updates
        ->orderBy('TransID', 'desc')
        ->offset($offset) // Skip records based on pagination
        ->limit($limitPerPage) // Limit number of records per page
        ->get(['TransID', 'TransAmount']); // Retrieve only necessary fields

    // Return paginated results in a format that Select2 expects
    return response()->json([
        'results' => $transDetails,
        'pagination' => [
            'more' => trans_references::where(function($queryBuilder) use ($query) {
                            $queryBuilder->where('TransID', 'LIKE', "%{$query}%")
                                         ->orWhere('TransAmount', 'LIKE', "%{$query}%");
                        })
                        ->orderBy('updated_at', 'desc')
                        ->orderBy('TransID', 'desc')
                        ->offset($offset + $limitPerPage) // Check if there are more records beyond the current page
                        ->exists()
        ]
    ]);
}

}
