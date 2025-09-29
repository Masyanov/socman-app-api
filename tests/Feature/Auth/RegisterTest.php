<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Team;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест рендеринга страницы регистрации.
     */
    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertViewIs('auth.register'); // или ваш шаблон
    }

    /**
     * Тест успешной регистрации нового пользователя.
     */
    public function test_new_users_can_register()
    {

        $response = $this->post('/register', [
            'name' => 'Иван',
            'second_name' => 'Иванович',
            'last_name' => 'Иванов',
            'role' => 'player',     // обязательное поле
            'team_code' => '777-777', // должен существовать в teams
            'email' => 'ivan@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('home')); // проверьте, что маршрут 'home' у вас определён
        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'email' => 'ivan@example.com',
            'name' => 'Иван',
            'last_name' => 'Иванов',
            'role' => 'player',
            'team_code' => '777-777',
        ]);
    }

    /**
     * Тест регистрации с отсутствующими обязательными полями.
     */
    public function test_registration_fails_with_missing_fields()
    {
        $response = $this->post('/register', [
            'name' => '',           // отсутствует имя
            'last_name' => '',      // отсутствует фамилия
            'role' => '',           // отсутствует роль
            'team_code' => '',      // отсутствует team_code
            'email' => 'invalid',   // некорректный
            'password' => 'pass',
            'password_confirmation' => 'passwrong',
        ]);

        $response->assertSessionHasErrors(['name', 'last_name', 'role', 'team_code', 'email', 'password']);
        $this->assertGuest();
    }
}
