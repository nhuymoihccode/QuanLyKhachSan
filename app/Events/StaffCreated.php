<?php

namespace App\Events;

use App\Models\Staff;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

class StaffCreated implements ShouldBroadcastNow
{
    use InteractsWithSockets, SerializesModels;

    public $staff;

    public function __construct(Staff $staff)
    {
        $this->staff = $staff;
    }

    public function broadcastOn()
    {
        return new Channel('staff');
    }

    public function broadcastWith()
    {
        return [
            'staff' => [
                'id' => $this->staff->id,
                'hotel_name' => $this->staff->hotel->name ?? 'N/A', // Thêm tên khách sạn
                'name' => $this->staff->name,
                'position' => $this->staff->position,
                'email' => $this->staff->email,
                'phone' => $this->staff->phone,
                'salary' => $this->staff->salary,
                'created_at' => $this->staff->created_at,
                'updated_at' => $this->staff->updated_at,
            ],
        ];
    }
}