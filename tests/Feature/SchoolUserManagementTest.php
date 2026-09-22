<?php

namespace Tests\Feature;

use App\Models\AcademicSession;
use App\Models\Grade;
use App\Models\Role;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\StudentClassEnrollment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SchoolUserManagementTest extends TestCase
{
    use RefreshDatabase;

    private function createSchool(string $code = 'ASP-001'): School
    {
        return School::create([
            'name' => 'Aspirian School',
            'code' => $code,
            'status' => 'active',
        ]);
    }

    private function createGrade(): Grade
    {
        return Grade::create([
            'name' => 'Class 9',
            'code' => 'G9',
            'level' => 9,
            'sort_order' => 9,
            'status' => 'active',
        ]);
    }

    private function createAcademicSession(): AcademicSession
    {
        return AcademicSession::create([
            'name' => '2026-27',
            'start_date' => '2026-04-01',
            'end_date' => '2027-03-31',
            'status' => 'active',
        ]);
    }

    private function createSchoolClass(
        School $school,
        Grade $grade,
        AcademicSession $session,
        string $name = '9-A'
    ): SchoolClass {
        return SchoolClass::create([
            'school_id' => $school->id,
            'grade_id' => $grade->id,
            'academic_session_id' => $session->id,
            'name' => $name,
            'status' => 'active',
        ]);
    }

    private function createRole(
        string $roleName,
        string $displayName,
        string $description = 'Test role.'
    ): Role {
        return Role::firstOrCreate(
            ['name' => $roleName],
            [
                'display_name' => $displayName,
                'description' => $description,
            ]
        );
    }

    private function createSchoolAdmin(): User
    {
        $user = User::factory()->create();

        $role = $this->createRole(
            'SCHOOL_ADMIN',
            'School Admin',
            'School administrator.'
        );

        $user->roles()->syncWithoutDetaching([$role->id]);

        return $user;
    }

    private function createUserWithRole(string $roleName): User
    {
        $user = User::factory()->create();

        $displayName = ucwords(
            strtolower(str_replace('_', ' ', $roleName))
        );

        $role = $this->createRole(
            $roleName,
            $displayName
        );

        $user->roles()->syncWithoutDetaching([$role->id]);

        return $user;
    }

    public function test_school_admin_can_access_school_overview(): void
    {
        $school = $this->createSchool();
        $admin = $this->createSchoolAdmin();

        $response = $this
            ->actingAs($admin)
            ->getJson("/api/school/{$school->id}");

        $response->assertOk()
            ->assertJsonPath('school.id', $school->id)
            ->assertJsonPath('total_classes', 0)
            ->assertJsonPath('total_students', 0);
    }

    public function test_non_school_admin_cannot_access_school_overview(): void
    {
        $school = $this->createSchool();
        $student = $this->createUserWithRole('STUDENT');

        $response = $this
            ->actingAs($student)
            ->getJson("/api/school/{$school->id}");

        $response->assertForbidden();
    }

    public function test_school_admin_can_create_student(): void
    {
        $school = $this->createSchool();
        $admin = $this->createSchoolAdmin();

        $this->createRole(
            'STUDENT',
            'Student',
            'Student platform user.'
        );

        $response = $this
            ->actingAs($admin)
            ->postJson("/api/school/{$school->id}/students", [
                'name' => 'Test Student',
                'email' => 'student@example.com',
                'password' => 'password123',
            ]);

        $response->assertCreated()
            ->assertJsonPath('user.name', 'Test Student')
            ->assertJsonPath('user.email', 'student@example.com');

        $this->assertDatabaseHas('users', [
            'email' => 'student@example.com',
        ]);

        $user = User::where('email', 'student@example.com')->firstOrFail();

        $this->assertTrue(
            $user->roles()->where('name', 'STUDENT')->exists()
        );

        $this->assertDatabaseHas('students', [
            'user_id' => $user->id,
            'status' => 'active',
        ]);
    }

    public function test_school_admin_can_create_student_and_enroll_in_school_class(): void
    {
        $school = $this->createSchool();
        $grade = $this->createGrade();
        $session = $this->createAcademicSession();
        $schoolClass = $this->createSchoolClass(
            $school,
            $grade,
            $session
        );

        $admin = $this->createSchoolAdmin();

        $this->createRole(
            'STUDENT',
            'Student',
            'Student platform user.'
        );

        $response = $this
            ->actingAs($admin)
            ->postJson("/api/school/{$school->id}/students", [
                'name' => 'Enrolled Student',
                'email' => 'enrolled@example.com',
                'password' => 'password123',
                'school_class_id' => $schoolClass->id,
            ]);

        $response->assertCreated();

        $user = User::where('email', 'enrolled@example.com')->firstOrFail();

        $student = Student::where('user_id', $user->id)->firstOrFail();

        $this->assertDatabaseHas('student_class_enrollments', [
            'student_id' => $student->id,
            'school_class_id' => $schoolClass->id,
            'status' => 'active',
        ]);
    }

    public function test_student_cannot_be_enrolled_in_another_schools_class(): void
    {
        $school = $this->createSchool('ASP-001');
        $otherSchool = $this->createSchool('OTH-001');

        $grade = $this->createGrade();
        $session = $this->createAcademicSession();

        $otherSchoolClass = $this->createSchoolClass(
            $otherSchool,
            $grade,
            $session,
            '9-B'
        );

        $admin = $this->createSchoolAdmin();

        $this->createRole(
            'STUDENT',
            'Student',
            'Student platform user.'
        );

        $response = $this
            ->actingAs($admin)
            ->postJson("/api/school/{$school->id}/students", [
                'name' => 'Wrong School Student',
                'email' => 'wrong-school@example.com',
                'password' => 'password123',
                'school_class_id' => $otherSchoolClass->id,
            ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('school_class_id');

        $this->assertDatabaseMissing('users', [
            'email' => 'wrong-school@example.com',
        ]);
    }

    public function test_school_admin_can_create_teacher(): void
    {
        $school = $this->createSchool();
        $admin = $this->createSchoolAdmin();

        $this->createRole(
            'TEACHER',
            'Teacher',
            'Teacher platform user.'
        );

        $response = $this
            ->actingAs($admin)
            ->postJson("/api/school/{$school->id}/teachers", [
                'name' => 'Test Teacher',
                'email' => 'teacher@example.com',
                'password' => 'password123',
            ]);

        $response->assertCreated()
            ->assertJsonPath('name', 'Test Teacher')
            ->assertJsonPath('email', 'teacher@example.com');

        $teacher = User::where('email', 'teacher@example.com')->firstOrFail();

        $this->assertTrue(
            $teacher->roles()->where('name', 'TEACHER')->exists()
        );
    }

    public function test_school_admin_can_update_student_status(): void
    {
        $admin = $this->createSchoolAdmin();

        $studentUser = User::factory()->create();

        $student = Student::create([
            'user_id' => $studentUser->id,
            'status' => 'active',
        ]);

        $response = $this
            ->actingAs($admin)
            ->patchJson("/api/school/students/{$student->id}/status", [
                'status' => 'inactive',
            ]);

        $response->assertOk()
            ->assertJsonPath('status', 'inactive');

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'status' => 'inactive',
        ]);
    }

    public function test_school_admin_can_update_user_status(): void
    {
        $admin = $this->createSchoolAdmin();

        $user = User::factory()->create([
            'status' => 'active',
        ]);

        $response = $this
            ->actingAs($admin)
            ->patchJson("/api/school/users/{$user->id}/status", [
                'status' => 'inactive',
            ]);

        $response->assertOk()
            ->assertJsonPath('status', 'inactive');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'status' => 'inactive',
        ]);
    }

    public function test_school_admin_can_assign_role_to_user(): void
    {
        $admin = $this->createSchoolAdmin();
        $user = User::factory()->create();

        $role = $this->createRole(
            'TEACHER',
            'Teacher',
            'Teacher platform user.'
        );

        $response = $this
            ->actingAs($admin)
            ->postJson("/api/school/users/{$user->id}/roles", [
                'role_id' => $role->id,
            ]);

        $response->assertOk();

        $this->assertDatabaseHas('user_roles', [
            'user_id' => $user->id,
            'role_id' => $role->id,
        ]);
    }

    public function test_duplicate_role_assignment_does_not_create_duplicate(): void
    {
        $admin = $this->createSchoolAdmin();
        $user = User::factory()->create();

        $role = $this->createRole(
            'TEACHER',
            'Teacher',
            'Teacher platform user.'
        );

        $user->roles()->syncWithoutDetaching([$role->id]);

        $response = $this
            ->actingAs($admin)
            ->postJson("/api/school/users/{$user->id}/roles", [
                'role_id' => $role->id,
            ]);

        $response->assertOk();

        $this->assertSame(
            1,
            $user->roles()
                ->where('role_id', $role->id)
                ->count()
        );
    }

    public function test_school_admin_can_remove_role_from_user(): void
    {
        $admin = $this->createSchoolAdmin();
        $user = User::factory()->create();

        $role = $this->createRole(
            'TEACHER',
            'Teacher',
            'Teacher platform user.'
        );

        $user->roles()->syncWithoutDetaching([$role->id]);

        $response = $this
            ->actingAs($admin)
            ->deleteJson("/api/school/users/{$user->id}/roles/{$role->id}");

        $response->assertOk();

        $this->assertDatabaseMissing('user_roles', [
            'user_id' => $user->id,
            'role_id' => $role->id,
        ]);
    }
}