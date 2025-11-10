<?php

namespace App\Modules\Notifications;

/**
 * Notifications Module
 * 
 * This module handles all notification-related functionality including:
 * - Firebase Cloud Messaging integration
 * - Push notifications
 * - Email notifications
 * - SMS notifications
 */
class NotificationsModule
{
    /**
     * Module name
     */
    public const NAME = 'Notifications';

    /**
     * Module version
     */
    public const VERSION = '1.0.0';

    /**
     * Module description
     */
    public const DESCRIPTION = 'Notification management module with Firebase support';

    /**
     * Boot the module
     */
    public function boot(): void
    {
        // Register notification channels and services
    }

    /**
     * Get module configuration
     */
    public function getConfig(): array
    {
        return [
            'name' => self::NAME,
            'version' => self::VERSION,
            'description' => self::DESCRIPTION,
            'enabled' => true,
            'channels' => ['firebase', 'mail', 'database'],
        ];
    }
}
