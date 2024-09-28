<?php
/**
 * UserRepository.php
 * @author Abbass Mortazavi <abbassmortazavi@gmail.com | Abbass Mortazavi>
 * @copyright Copyright &copy; from NewsAggregator
 * @version 1.0.0
 * @date 2024/09/27 20:45
 */


namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @param User $user
     */
    public function __construct(protected User $user)
    {
    }

    /**
     * @throws Throwable
     */
    public function login(array $attributes): array
    {
        throw_if(!Auth::attempt($attributes), new \Exception('The provided credentials are incorrect.', Response::HTTP_INTERNAL_SERVER_ERROR));
        $user = $this->getUser($attributes['email']);
        if (count($user->tokens) > 0) {
            $user->tokens()->delete();
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        $data['access_token'] = $token;
        $data['token_type'] = 'Bearer';
        $data['user'] = $user;

        return $data;
    }

    /**
     * @param array $attributes
     * @return array
     */
    public function register(array $attributes)
    {
        $user = $this->user->query()->create([
            'name' => $attributes['name'],
            'email' => $attributes['email'],
            'password' => Hash::make($attributes['password']),
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;
        $data['access_token'] = $token;
        $data['token_type'] = 'Bearer';
        $data['user'] = $user;

        return $data;
    }

    /**
     * @param string $email
     * @return User|Model
     */
    public function getUser(string $email): Model|User
    {
        return $this->user->query()->where('email', $email)->firstOrFail();
    }

    /**
     * @param object $user
     * @param array $attributes
     * @return bool
     */
    public function update(object $user, array $attributes): bool
    {
        return $this->user->query()->where('email', $user->email)->update($attributes);
    }
}
