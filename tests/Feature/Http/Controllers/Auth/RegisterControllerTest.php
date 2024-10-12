<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Constants\UserBalanceConstants;
use App\Events\UserRegistered;
use App\Models\User;
use App\Models\UserBalance;
use App\Notifications\BalanceNotification;
use App\Notifications\VerifyEmail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{

    private function getUserData(): array
    {
        /**
         * @var User $user
         */
        $user = User::factory()->makeOne([
            'dob' => Carbon::now()->subYears(19)->format('Y-m-d'),
        ]);

        $userData = $user->toArray();
        $userData['password'] = 'password';
        $userData['password_confirmation'] = 'password';
        return $userData;
    }

    public function test_it_can_store_a_new_user()
    {
        $userData = $this->getUserData();
        $response = $this->post(route('auth.register'), $userData);

        $this->assertDatabaseHas('users', [
            'email' => $userData['email'],
            'dob' => $userData['dob'],
            'firstname' => $userData['firstname'],
            'lastname' => $userData['lastname'],
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'data' => null,
            'message' => trans('auth.account_created_please_verify_your_email'),
        ]);
    }


    public function test_it_should_fire_user_registered_event()
    {
        Event::fake();
        $userData = $this->getUserData();
        $this->post(route('auth.register'), $userData);
        Event::assertDispatched(UserRegistered::class);
    }

    public function test_it_should_notify_verify_email_notification()
    {
        Notification::fake();
        $userData = $this->getUserData();
        $this->post(route('auth.register'), $userData);
        $user = User::where('email', $userData['email'])->first();
        Notification::assertSentTo($user, VerifyEmail::class);
    }

    public function test_it_should_notify_balance_notification()
    {
        Notification::fake();
        $userData = $this->getUserData();
        $this->post(route('auth.register'), $userData);
        $user = User::where('email', $userData['email'])->first();
        Notification::assertSentTo($user, BalanceNotification::class);
    }

    public function test_it_should_create_user_balance()
    {
        $userData = $this->getUserData();
        $this->post(route('auth.register'), $userData);
        $user = User::where('email', $userData['email'])->first();
        $this->assertDatabaseHas('user_balances', [
            'user_id' => $user->id,
            'balance' => UserBalanceConstants::WELCOME_BONUS,
            'currency' => UserBalanceConstants::DEFAULT_CURRENCY,
        ]);
    }
}
