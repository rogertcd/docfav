<?php

namespace Tests\Unit;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
//use PHPUnit\Framework\TestCase;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Request;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_fail_validation_when_creating_a_user_without_name()
    {
        $request = new StoreUserRequest();

        $validator = Validator::make([
            'last_name' => 'Something',
            'email' => 'test@test.com',
            'password' => '1234',
            'birth_date' => '2000-01-01',
            'gender' => 'M',
        ], $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertContains('name', $validator->errors()->keys());
    }

    public function test_should_fail_validation_when_creating_a_user_without_last_name()
    {
        $request = new StoreUserRequest();

        $validator = Validator::make([
            'name' => 'Something',
            'email' => 'test@test.com',
            'password' => '1234',
            'birth_date' => '2000-01-01',
            'gender' => 'M',
        ], $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertContains('last_name', $validator->errors()->keys());
    }

    public function test_should_fail_validation_when_creating_a_user_with_invalid_email()
    {
        $request = new StoreUserRequest();

        $validator = Validator::make([
            'name' => 'Something',
            'last_name' => 'Something',
            'email' => 'test',
            'password' => '1234',
            'birth_date' => '2000-01-01',
            'gender' => 'M',
        ], $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertContains('email', $validator->errors()->keys());
    }

    public function test_should_fail_validation_when_creating_a_user_without_password()
    {
        $request = new StoreUserRequest();

        $validator = Validator::make([
            'name' => 'Something',
            'last_name' => 'Something',
            'email' => 'test',
            'birth_date' => '2000-01-01',
            'gender' => 'M',
        ], $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertContains('password', $validator->errors()->keys());
    }

    public function test_the_bith_date_field_does_not_have_yyyy_mm_dd_format()
    {
        $request = new StoreUserRequest();

        $validator = Validator::make([
            'name' => 'Something',
            'last_name' => 'Something',
            'email' => 'test@test.com',
            'password' => '1234',
            'birth_date' => '01/01/2000',
            'gender' => 'M',
        ], $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertContains('birth_date', $validator->errors()->keys());
    }

    public function test_the_gender_field_only_accept_m_or_f()
    {
        $request = new StoreUserRequest();

        $validator = Validator::make([
            'name' => 'Something',
            'last_name' => 'Something',
            'email' => 'test@test.com',
            'password' => '1234',
            'birth_date' => '2000-01-01',
            'gender' => 'A',
        ], $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertContains('gender', $validator->errors()->keys());
    }

    public function test_should_contain_all_the_expected_validation_rules()
    {
        $request = new StoreUserRequest();

        $this->assertEquals([
            'name' => 'required|min:2|max:50',
            'last_name' => 'required|min:2|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'birth_date' => 'required|date_format:Y-m-d|before:2015-12-31',
            'gender' => 'required|min:1|max:1|in:M,F,m,f',
        ], $request->rules());
    }

    public function test_should_create_a_user_successfully()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->json('POST', '/api/users/store', [
                'name' => 'Test',
                'last_name' => 'Test',
                'email' => 'test@test.com',
                'password' => '1234',
                'birth_date' => '2000-01-01',
                'gender' => 'M',
            ]);

        $response->assertCreated();

        $this->assertDatabaseHas('users', [
            'name' => 'Test',
            'last_name' => 'Test',
            'email' => 'test@test.com',
            'birth_date' => '2000-01-01',
            'gender' => 'M',
        ]);
    }

    public function test_the_email_must_be_unique()
    {
        User::factory()->create(
            [
                'name' => 'Test',
                'last_name' => 'Test',
                'email' => 'test@test.com',
                'password' => '1234',
                'birth_date' => '2000-01-01',
                'gender' => 'M',
            ]
        );

        $this->assertDatabaseCount('users', 1);

        $this->expectException(QueryException::class);

        User::factory()->create(
            [
                'name' => 'Test',
                'last_name' => 'Test',
                'email' => 'test@test.com',
                'password' => '1234',
                'birth_date' => '2000-01-01',
                'gender' => 'M',
            ]
        );
        $this->assertDatabaseCount('users', 1);
    }

    public function test_delete_option_should_softdelete_in_database()
    {
        $user = User::factory()->create();

        $user->delete();
        $this->assertSoftDeleted($user);
    }
}
