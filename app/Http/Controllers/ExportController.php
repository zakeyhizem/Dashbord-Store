<?php

namespace App\Http\Controllers;

use App\Services\ExportService;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ExportController extends Controller
{
    protected $exportService;

    public function __construct(ExportService $exportService)
    {
        $this->exportService = $exportService;
    }

    /**
     * Export orders to Excel
     */
    public function exportOrdersToExcel(): JsonResponse
    {
        try {
            $orders = Order::with(['user', 'products'])->get()->toArray();
            $filename = 'orders_' . date('Y-m-d_His') . '.xlsx';
            
            $this->exportService->exportToExcel($orders, $filename);

            return response()->json([
                'message' => 'Orders exported successfully',
                'filename' => $filename,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Export products to Excel
     */
    public function exportProductsToExcel(): JsonResponse
    {
        try {
            $products = Product::with('category')->get()->toArray();
            $filename = 'products_' . date('Y-m-d_His') . '.xlsx';
            
            $this->exportService->exportToExcel($products, $filename);

            return response()->json([
                'message' => 'Products exported successfully',
                'filename' => $filename,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Export orders to PDF
     */
    public function exportOrdersToPdf(): JsonResponse
    {
        try {
            $orders = Order::with(['user', 'products'])->get()->toArray();
            $filename = 'orders_' . date('Y-m-d_His') . '.pdf';
            
            $this->exportService->exportToPdf($orders, $filename, 'exports.orders');

            return response()->json([
                'message' => 'Orders exported to PDF successfully',
                'filename' => $filename,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Upload file to S3
     */
    public function uploadToS3(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'file' => 'required|file',
            'path' => 'string',
        ]);

        try {
            $file = $request->file('file');
            $path = $validated['path'] ?? 'uploads';
            $filename = $path . '/' . $file->getClientOriginalName();
            
            $url = $this->exportService->uploadToS3($filename, file_get_contents($file));

            return response()->json([
                'message' => 'File uploaded successfully',
                'url' => $url,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
