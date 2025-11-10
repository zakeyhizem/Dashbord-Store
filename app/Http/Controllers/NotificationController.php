<?php

namespace App\Http\Controllers;

use App\Services\FirebaseNotificationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseNotificationService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    /**
     * Send notification to a device
     */
    public function sendToDevice(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'token' => 'required|string',
            'title' => 'required|string',
            'body' => 'required|string',
            'data' => 'nullable|array',
        ]);

        try {
            $this->firebaseService->sendToDevice(
                $validated['token'],
                $validated['title'],
                $validated['body'],
                $validated['data'] ?? []
            );

            return response()->json(['message' => 'Notification sent successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Send notification to multiple devices
     */
    public function sendToMultipleDevices(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'tokens' => 'required|array',
            'tokens.*' => 'string',
            'title' => 'required|string',
            'body' => 'required|string',
            'data' => 'nullable|array',
        ]);

        try {
            $this->firebaseService->sendToMultipleDevices(
                $validated['tokens'],
                $validated['title'],
                $validated['body'],
                $validated['data'] ?? []
            );

            return response()->json(['message' => 'Notifications sent successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Send notification to a topic
     */
    public function sendToTopic(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'topic' => 'required|string',
            'title' => 'required|string',
            'body' => 'required|string',
            'data' => 'nullable|array',
        ]);

        try {
            $this->firebaseService->sendToTopic(
                $validated['topic'],
                $validated['title'],
                $validated['body'],
                $validated['data'] ?? []
            );

            return response()->json(['message' => 'Notification sent to topic successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
