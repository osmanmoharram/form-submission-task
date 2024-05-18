<?php

namespace Tests\Feature\Api;

use App\Models\FormSubmit;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Database\Events\DatabaseRefreshed;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class FormSubmitControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_not_permitted_users_cannot_view_form_submits(): void
    {
        /** @var User */
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->get(route('formSubmits.index'));

        $response->assertForbidden();
    }

    public function test_hr_coordinator_can_view_form_submits(): void
    {
        /** @var User */
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['hr_coordinator']);

        /** @var Role */
        $role = Role::create([
            'name' => 'hr_coordinator',
            'guard_name' => 'sanctum'
        ]);

        /** @var Collection */
        $formSubmits = FormSubmit::factory()->count(3)->create();

        $user->assignRole($role);

        $response = $this->get(route('formSubmits.index'));

        $response->assertOk();
    }

    public function test_hr_manager_can_view_form_submits(): void
    {
        /** @var User */
        $user = User::factory()->create();
        /** @var Role */
        $role = Role::create(['name' => 'hr_manager']);
        /** @var Collection */
        $formSubmits = FormSubmit::factory()->count(3)->create([
            'hr_coordinator_approval' => 'approved'
        ]);

        $user->assignRole($role);

        $response = $this->actingAs($user)->get(route('formSubmits.index'));

        $response->assertOk();
    }

    public function test_hr_coordinator_approved_form_submits_are_not_retrieved(): void
    {
        /** @var User */
        $user = User::factory()->create();
        /** @var Role */
        $role = Role::create(['name' => 'hr_coordinator']);
        /** @var Collection */
        $formSubmits = FormSubmit::factory()->count(3)->create([
            'hr_coordinator_approval' => 'approved'
        ]);

        $user->assignRole($role);

        $response = $this->actingAs($user)->get(route('formSubmits.index'));

        $response->assertOk();
        
    }

    public function test_hr_manager_approved_form_submits_are_not_retrieved(): void
    {
        /** @var User */
        $user = User::factory()->create();
        /** @var Role */
        $role = Role::create(['name' => 'hr_manager']);
        /** @var Collection */
        $formSubmits = FormSubmit::factory()->count(3)->create([
            'hr_coordinator_approval' => 'approved'
        ]);

        $user->assignRole($role);

        $response = $this->actingAs($user)->get(route('formSubmits.index'));

        $response->assertOk();
        
    }

    public function test_anonymous_users_can_create_form_submits(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('testCV.pdf', 2048);       // 2Mb

        $response = $this->post(route('formSubmits.store'), [
            'name' => 'John Doe',
            'dob' => now()->subYears(20)->toDateString(),
            'gender' => 'male',
            'nationality' => 'Egyption',
            'cv' => $file
        ]);

        Storage::disk('public')->assertExists('/' . $file->hashName());
        $response->assertRedirect();
        $this->assertDatabaseCount('form_submits', 1);
    }

    public function test_not_permitted_user_cannot_update_a_form_submit(): void
    {
        $user = User::factory()->create();
        $formSubmit = FormSubmit::factory()->create();

        $response = $this->actingAs($user)->put(route('formSubmits.update', $formSubmit), [
            'approval' => 'approved'
        ]);

        $response->assertForbidden();
    }

    public function test_hr_cooridinator_can_approve_a_form_submit(): void
    {
        /** @var User */
        $user = User::factory()->create();
        /** @var Role */
        $role = Role::create(['name' => 'hr_coordinator']);
        /** @var FormSubmit */
        $formSubmit = FormSubmit::factory()->create();

        $user->assignRole($role);

        $response = $this->actingAs($user)->put(route('formSubmits.update', $formSubmit), [
            'approval' => 'approved'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('form_submits', [
            'id' => $formSubmit->id,
            'hr_coordinator_approval' => 'approved'
        ]);
    }

    public function test_hr_cooridinator_can_reject_a_form_submit(): void
    {
        /** @var User */
        $user = User::factory()->create();
        /** @var Role */
        $role = Role::create(['name' => 'hr_coordinator']);
        /** @var FormSubmit */
        $formSubmit = FormSubmit::factory()->create();

        $user->assignRole($role);

        $response = $this->actingAs($user)->put(route('formSubmits.update', $formSubmit), [
            'approval' => 'rejected'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('form_submits', [
            'id' => $formSubmit->id,
            'hr_coordinator_approval' => 'rejected'
        ]);
    }

    public function test_hr_manager_can_approve_a_form_submit(): void
    {
        /** @var User */
        $user = User::factory()->create();
        /** @var Role */
        $role = Role::create(['name' => 'hr_manager']);
        /** @var FormSubmit */
        $formSubmit = FormSubmit::factory()->create([
            'hr_coordinator_approval' => 'approved'
        ]);

        $user->assignRole($role);

        $response = $this->actingAs($user)->put(route('formSubmits.update', $formSubmit), [
            'approval' => 'approved'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('form_submits', [
            'id' => $formSubmit->id,
            'hr_manager_approval' => 'approved'
        ]);
    }

    public function test_hr_manager_can_reject_a_form_submit(): void
    {
        /** @var User */
        $user = User::factory()->create();
        /** @var Role */
        $role = Role::create(['name' => 'hr_manager']);
        /** @var FormSubmit */
        $formSubmit = FormSubmit::factory()->create([
            'hr_coordinator_approval' => 'approved'
        ]);

        $user->assignRole($role);

        $response = $this->actingAs($user)->put(route('formSubmits.update', $formSubmit), [
            'approval' => 'rejected'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('form_submits', [
            'id' => $formSubmit->id,
            'hr_manager_approval' => 'rejected'
        ]);
    }
}
