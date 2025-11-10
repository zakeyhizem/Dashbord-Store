<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FirebaseNotificationService
{
    protected $messaging;

    public function __construct()
    {
        if (config('firebase.credentials')) {
            $factory = (new Factory)->withServiceAccount(config('firebase.credentials'));
            $this->messaging = $factory->createMessaging();
        }
    }

    /**
     * Send notification to a device token
     *
     * @param string $token
     * @param string $title
     * @param string $body
     * @param array $data
     * @return void
     */
    public function sendToDevice(string $token, string $title, string $body, array $data = []): void
    {
        if (!$this->messaging) {
            return;
        }

        $notification = Notification::create($title, $body);

        $message = CloudMessage::withTarget('token', $token)
            ->withNotification($notification)
            ->withData($data);

        $this->messaging->send($message);
    }

    /**
     * Send notification to multiple devices
     *
     * @param array $tokens
     * @param string $title
     * @param string $body
     * @param array $data
     * @return void
     */
    public function sendToMultipleDevices(array $tokens, string $title, string $body, array $data = []): void
    {
        if (!$this->messaging) {
            return;
        }

        $notification = Notification::create($title, $body);

        foreach ($tokens as $token) {
            $message = CloudMessage::withTarget('token', $token)
                ->withNotification($notification)
                ->withData($data);

            $this->messaging->send($message);
        }
    }

    /**
     * Send notification to a topic
     *
     * @param string $topic
     * @param string $title
     * @param string $body
     * @param array $data
     * @return void
     */
    public function sendToTopic(string $topic, string $title, string $body, array $data = []): void
    {
        if (!$this->messaging) {
            return;
        }

        $notification = Notification::create($title, $body);

        $message = CloudMessage::withTarget('topic', $topic)
            ->withNotification($notification)
            ->withData($data);

        $this->messaging->send($message);
    }
}
