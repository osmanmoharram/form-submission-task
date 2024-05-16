<?php

namespace Tests\Feature;

use App\Models\FormSubmit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class FormSubmitControllerTest extends TestCase
{
    public function test_not_permitted_users_cannot_view_form_submits(): void
    {
        /** @var User */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('formSubmits.index'));

        $response->assertForbidden();
    }

    public function test_hr_coordinator_can_view_form_submits(): void
    {
        /** @var User */
        $user = User::factory()->create();
        /** @var Role */
        $role = Role::create(['name' => 'hr_coordinator']);
        /** @var Collection */
        $formSubmits = FormSubmit::factory()->count(3)->create();

        $user->assignRole($role);

        $response = $this->actingAs($user)->get(route('formSubmits.index'));

        $response->assertOk();
        $response->assertViewIs('formSubmits.index');
        $response->assertViewHas('formSubmits', fn (Collection $submits) => $submits->count() == $formSubmits->count());
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
        $response->assertViewIs('formSubmits.index');
        $response->assertViewHas('formSubmits', fn (Collection $submits) => $submits->count() == $formSubmits->count());
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
        $response->assertViewIs('formSubmits.index');
        $response->assertViewHas('formSubmits', fn (Collection $submits) => $submits->isEmpty());
        
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
        $response->assertViewIs('formSubmits.index');
        $response->assertViewHas('formSubmits', fn (Collection $submits) => $submits->isEmpty());
        
    }

    public function test_anonymous_users_can_view_the_create_form_of_form_submits(): void
    {
        $response = $this->get(route('formSubmits.create'));

        $response->assertOk();
        $response->assertViewIs('formSubmits.create');
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
        $response->assertSessionHas('success', 'Your form has been submitted successfully');
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
        $response->assertSessionHas('success', 'The form submit has been approved');
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
        $response->assertSessionHas('success', 'The form submit has been rejected');
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
        $response->assertSessionHas('success', 'The form submit has been approved');
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
        $response->assertSessionHas('success', 'The form submit has been rejected');
        $this->assertDatabaseHas('form_submits', [
            'id' => $formSubmit->id,
            'hr_manager_approval' => 'rejected'
        ]);
    }
}
