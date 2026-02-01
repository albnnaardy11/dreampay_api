<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DreamPaySystemTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function full_system_flow_test()
    {
        // 1. Register Santri
        $response = $this->postJson('/api/register', [
            'name' => 'Santri 1',
            'email' => 'santri@pondok.com',
            'password' => 'password123',
            'pin' => '123456',
        ]);
        $response->assertStatus(201);
        $santri = User::where('email', 'santri@pondok.com')->first();
        $this->assertEquals('santri', $santri->role);
        $this->assertTrue(Hash::check('123456', $santri->pin));
        $token = $response->json('access_token');

        // 2. Admin Topup Santri
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        
        $response = $this->postJson('/api/admin/topup', [
            'user_id' => $santri->id,
            'amount' => 100000,
        ]);
        $response->assertStatus(200);
        $this->assertEquals(100000, $santri->fresh()->balance);

        // 3. Merchant Scan and Pay
        $merchant = User::factory()->create(['role' => 'merchant', 'name' => 'Kantin Stand']);
        $this->actingAs($merchant);

        $response = $this->postJson('/api/merchant/scan-pay', [
            'qr_code' => $santri->qr_code,
            'amount' => 5000,
            'description' => 'Beli Es Teh',
        ]);
        $response->assertStatus(200);
        $this->assertEquals(95000, $santri->fresh()->balance);
        $this->assertEquals(5000, $merchant->fresh()->balance);

        // 4. Santri Transfer to another Santri
        $santri2 = User::factory()->create(['name' => 'Santri 2', 'email' => 'santri2@pondok.com']);
        $this->actingAs($santri);

        $response = $this->postJson('/api/transfer', [
            'recipient_email' => 'santri2@pondok.com',
            'amount' => 10000,
            'pin' => '123456',
        ]);
        $response->assertStatus(200);
        $this->assertEquals(85000, $santri->fresh()->balance);
        $this->assertEquals(10000, $santri2->fresh()->balance);
    }

    /** @test */
    public function pin_verification_works_correctly()
    {
        $santri = User::factory()->create([
            'email' => 'test@pondok.com',
            'pin' => '111111',
            'balance' => 50000,
        ]);
        $santri2 = User::factory()->create(['email' => 'target@pondok.com']);

        $this->actingAs($santri);

        // Wrong PIN
        $response = $this->postJson('/api/transfer', [
            'recipient_email' => 'target@pondok.com',
            'amount' => 1000,
            'pin' => '999999',
        ]);
        $response->assertStatus(403);
        $this->assertEquals(50000, $santri->fresh()->balance);

        // Correct PIN
        $response = $this->postJson('/api/transfer', [
            'recipient_email' => 'target@pondok.com',
            'amount' => 1000,
            'pin' => '111111',
        ]);
        $response->assertStatus(200);
        $this->assertEquals(49000, $santri->fresh()->balance);
    }
    /** @test */
    public function split_bill_creation_and_payment_flow()
    {
        $owner = User::factory()->create(['balance' => 0, 'pin' => '111111']);
        $p1 = User::factory()->create(['balance' => 50000, 'pin' => '222222']);
        $p2 = User::factory()->create(['balance' => 50000, 'pin' => '333333']);

        $this->actingAs($owner);

        // 1. Create Split Bill
        $response = $this->postJson('/api/split-bill', [
            'total_amount' => 30000,
            'description' => 'Makan Bareng',
            'participants' => [
                ['user_id' => $p1->id, 'amount' => 15000],
                ['user_id' => $p2->id, 'amount' => 15000],
            ]
        ]);
        $response->assertStatus(201);
        $billId = $response->json('split_bill.id');
        $p1MemberId = $response->json('split_bill.members.0.id');

        // 2. Participant 1 Pays
        $this->actingAs($p1);
        $response = $this->postJson("/api/split-bill/pay/{$p1MemberId}", [
            'pin' => '222222'
        ]);
        $response->assertStatus(200);

        // Check balances
        $this->assertEquals(35000, $p1->fresh()->balance); // 50000 - 15000
        $this->assertEquals(15000, $owner->fresh()->balance); // 0 + 15000
    }
}
