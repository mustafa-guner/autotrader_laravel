<?php

namespace App\Console\Commands;

use App\Events\NotificationCreated;
use App\Models\NotificationUser;
use App\Models\Ticker;
use App\Models\UserShare;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class StockTransactionDemo extends Command
{
    protected $signature = 'stock:demo {user_id}';
    protected $description = 'Demonstrate stock buying and selling transactions.';

    public function handle(): void
    {
        // Retrieve the user ID from the command arguments
        $userId = $this->argument('user_id');

        // Fetch the user by ID
        $user = User::find($userId);

        // Check if the user exists
        if (!$user) {
            $this->error("No user found with ID: $userId.");
            return;
        }

        $companies = Ticker::pluck('name')->toArray();

        // Simulate buying stocks
        foreach ($companies as $company) {
            $this->info("Buying stocks for: $company");
            $this->buyStocks($user, $company, rand(1, 10), rand(50, 200));

            // Introduce a 3-second delay to simulate AI behavior
            sleep(3);
        }

        // Simulate selling stocks
        foreach ($companies as $company) {
            $this->info("Selling stocks for: $company");
            $this->sellStocks($user, $company, rand(1, 10));

            // Introduce a 3-second delay to simulate AI behavior
            sleep(3);
        }
    }

    private function buyStocks(User $user, string $company, int $quantity, float $price): void
    {
        DB::beginTransaction();
        try {
            // Ensure user has a balance before proceeding
            if (!$user->userBalance) {
                $user->userBalance()->create(['balance' => 0, 'currency' => 'USD']); // Ensure currency is set
                $user->refresh(); // Reload the relationship after creation
            }

            $totalCost = $quantity * $price;

            // Now update the balance
            $user->userBalance->update(['balance' => $user->userBalance->balance - $totalCost]);

            // Find or create the user's shares for the company
            $userShare = UserShare::where('name', $company)->where('user_id', $user->id)->first();

            if ($userShare) {
                $userShare->increment('quantity', $quantity);
            } else {
                $ai_user = User::where('is_virtual_account', 1)->first(); // Fetch AI user
                if (!$ai_user) {
                    throw new \Exception("AI user not found.");
                }
                UserShare::create([
                    'user_id' => $user->id,
                    'name' => $company,
                    'exchange' => 'NYSE',
                    'quantity' => $quantity,
                    'bought_by' => $ai_user->id,
                    'symbol' => strtoupper(substr($company, 0, 3)),
                    'price' => $price
                ]);
            }

            // Create notification and fire the event
            $notification = NotificationUser::create([
                'user_id' => $user->id,
                'message' => "Bought $quantity shares of $company.",
                'is_read' => false
            ]);

            // Dispatch the notification event
            NotificationCreated::dispatch($notification, [
                'balance' => $user->userBalance->balance
            ]);


            DB::commit();
            $this->info("Successfully bought $quantity shares of $company.");
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("Failed to buy shares of $company: " . $e->getMessage());
        }
    }


    private function sellStocks(User $user, string $company, int $quantity): void
    {
        DB::beginTransaction();
        try {
            $ai_user = User::where('is_virtual_account', 1)->first(); // Fetch AI user
            if (!$ai_user) {
                throw new \Exception("AI user not found.");
            }
            $userShare = UserShare::where('name', $company)->where('user_id', $user->id)->first();

            if (!$userShare || $userShare->quantity < $quantity) {
                $this->error("Insufficient shares to sell for $company.");
                return;
            }

            $userShare->update(['sold_by' => $ai_user->id]);
            $userShare->decrement('quantity', $quantity);
            $user->userBalance->update([
                'balance' => $user->userBalance->balance + ($quantity * $userShare->price)
            ]);

            // Create notification and fire the event
            $notification = NotificationUser::create([
                'user_id' => $user->id,
                'message' => "Sold $quantity shares of $company.",
                'is_read' => false
            ]);

            // Dispatch the notification event
            NotificationCreated::dispatch($notification, [
                'balance' => $user->userBalance->balance
            ]);


            DB::commit();
            $this->info("Successfully sold $quantity shares of $company.");
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("Failed to sell shares of $company: " . $e->getMessage());
        }
    }
}
