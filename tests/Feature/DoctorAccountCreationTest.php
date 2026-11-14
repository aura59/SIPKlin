<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DoctorAccountCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_form_lists_only_unlinked_doctor_accounts(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $department = $this->createDepartment();
        $availableUser = User::factory()->create(['role' => 'dokter']);
        $linkedUser = User::factory()->create(['role' => 'dokter']);
        Doctor::create([
            'user_id' => $linkedUser->id,
            'nama' => 'Dokter Terhubung',
            'department_id' => $department->id,
            'spesialis' => 'Umum',
            'no_telepon' => '081234567890',
        ]);
        User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('doctors.create'));

        $response->assertOk()
            ->assertSee($availableUser->email)
            ->assertSee($linkedUser->email . ' (sudah terhubung)')
            ->assertSee('value="' . $linkedUser->id . '" disabled', false)
            ->assertSee('Pilih Akun yang Sudah Terdaftar')
            ->assertSee('Buat Akun Dokter Baru');
    }

    public function test_admin_can_link_an_existing_doctor_account_once(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $department = $this->createDepartment();
        $doctorUser = User::factory()->create(['role' => 'dokter']);
        $doctorData = [
            'account_type' => 'existing',
            'user_id' => $doctorUser->id,
            'nama' => 'Dokter Contoh',
            'department_id' => $department->id,
            'spesialis' => 'Umum',
            'no_telepon' => '081234567890',
        ];

        $this->actingAs($admin)
            ->post(route('doctors.store'), $doctorData)
            ->assertRedirect(route('doctors.index'));

        $this->assertDatabaseHas('doctors', [
            'user_id' => $doctorUser->id,
            'nama' => 'Dokter Contoh',
        ]);

        $this->post(route('doctors.store'), $doctorData)
            ->assertSessionHasErrors('user_id');

        $this->assertDatabaseCount('doctors', 1);
    }

    public function test_admin_can_create_a_doctor_account_and_use_it_to_log_in(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $department = $this->createDepartment();

        $this->actingAs($admin)
            ->post(route('doctors.store'), [
                'account_type' => 'new',
                'email' => 'dokter.baru@example.test',
                'password' => 'password123',
                'nama' => 'Dokter Baru',
                'department_id' => $department->id,
                'spesialis' => 'Anak',
                'no_telepon' => '081234567890',
            ])
            ->assertRedirect(route('doctors.index'));

        $doctorUser = User::where('email', 'dokter.baru@example.test')->firstOrFail();
        $this->assertSame('dokter', $doctorUser->role);
        $this->assertTrue(Hash::check('password123', $doctorUser->password));
        $this->assertDatabaseHas('doctors', [
            'user_id' => $doctorUser->id,
            'nama' => 'Dokter Baru',
        ]);

        $this->post(route('logout'));

        $this->post(route('login.process'), [
            'email' => 'dokter.baru@example.test',
            'password' => 'password123',
            'role' => 'dokter',
        ])->assertRedirect(route('doctor.dashboard'));

        $this->assertAuthenticatedAs($doctorUser);
    }

    public function test_new_doctor_account_rejects_duplicate_email_and_short_password(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $existingUser = User::factory()->create(['email' => 'existing@example.test']);
        $department = $this->createDepartment();
        $doctorData = [
            'account_type' => 'new',
            'email' => $existingUser->email,
            'password' => 'short',
            'nama' => 'Dokter Tidak Jadi',
            'department_id' => $department->id,
            'spesialis' => 'Umum',
            'no_telepon' => '081234567890',
        ];

        $this->actingAs($admin)
            ->post(route('doctors.store'), $doctorData)
            ->assertSessionHasErrors(['email', 'password']);

        $this->assertDatabaseCount('doctors', 0);
    }

    private function createDepartment(): Department
    {
        return Department::create([
            'name' => 'Poli Umum',
            'kode_poli' => 'A',
        ]);
    }
}
