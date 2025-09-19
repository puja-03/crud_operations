<?php

namespace Tests\Feature;

use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NoteTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_notes_page(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->get('/notes');
        
        $response->assertStatus(200);
    }

    public function test_user_can_create_note(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->post('/notes', [
            'title' => 'Test Note',
            'content' => 'This is a test note'
        ]);
        
        $response->assertRedirect('/notes');
        $this->assertDatabaseHas('notes', [
            'title' => 'Test Note',
            'content' => 'This is a test note',
            'user_id' => $user->id
        ]);
    }

    public function test_user_can_update_note(): void
    {
        $user = User::factory()->create();
        $note = Note::factory()->create(['user_id' => $user->id]);
        
        $response = $this->actingAs($user)->put("/notes/{$note->id}", [
            'title' => 'Updated Title',
            'content' => 'Updated content'
        ]);
        
        $response->assertRedirect('/notes');
        $this->assertDatabaseHas('notes', [
            'id' => $note->id,
            'title' => 'Updated Title',
            'content' => 'Updated content'
        ]);
    }

    public function test_user_can_delete_note(): void
    {
        $user = User::factory()->create();
        $note = Note::factory()->create(['user_id' => $user->id]);
        
        $response = $this->actingAs($user)->delete("/notes/{$note->id}");
        
        $response->assertRedirect('/notes');
        $this->assertDatabaseMissing('notes', ['id' => $note->id]);
    }

    public function test_user_cannot_update_others_note(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $note = Note::factory()->create(['user_id' => $user2->id]);
        
        $response = $this->actingAs($user1)->put("/notes/{$note->id}", [
            'title' => 'Updated Title',
            'content' => 'Updated content'
        ]);
        
        $response->assertStatus(403);
    }
}
