<?php

namespace Tests\Unit;

use App\Models\Conversation;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ConversationMethodTest extends TestCase
{
    use RefreshDatabase;

    public function test_mark_as_read_method_exists_and_works()
    {
        // Setup users
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        Auth::login($user1);

        // Create conversation
        $conversation = Conversation::create([
            'is_group' => false,
            'last_message_at' => now(),
        ]);

        $conversation->users()->attach([$user1->id, $user2->id]);

        // This method should now exist and not throw an exception
        try {
            $conversation->markAsReadForUser($user1->id);
            $this->assertTrue(true, "Method markAsReadForUser exists and executed successfully.");
        } catch (\BadMethodCallException $e) {
            $this->fail("Method markAsReadForUser does not exist: " . $e->getMessage());
        } catch (\Error $e) {
            $this->fail("Error calling markAsReadForUser: " . $e->getMessage());
        }

        // Verify that the pivot table was updated
        $this->assertDatabaseHas('conversation_user', [
            'conversation_id' => $conversation->id,
            'user_id' => $user1->id,
        ]);

        // Fetch fresh pivot data
        $pivot = $conversation->users()->where('user_id', $user1->id)->first()->pivot;
        $this->assertNotNull($pivot->last_read_at);
    }
}
