<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomMail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MailTest extends TestCase
{
    use RefreshDatabase;

    public function test_send_email()
    {
        Mail::fake();

        $user = User::factory()->create();

        $response = $this->post('/mail/send', [
            'to' => $user->email,
            'subject' => 'Test Email',
            'content' => 'This is a test email content.'
        ]);

        $response->assertStatus(200);
        Mail::assertSent(CustomMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email) &&
                   $mail->subject === 'Test Email' &&
                   $mail->content === 'This is a test email content.';
        });
    }

    public function test_edit_email_content()
    {
        $this->post('/mail/edit', [
            'subject' => 'Updated Subject',
            'content' => 'Updated email content.'
        ]);

        $this->assertDatabaseHas('emails', [
            'subject' => 'Updated Subject',
            'content' => 'Updated email content.'
        ]);
    }
}
