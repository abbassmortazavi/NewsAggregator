<?php
/**
 * AuthService.php
 * @author Abbass Mortazavi <abbassmortazavi@gmail.com | Abbass Mortazavi>
 * @copyright Copyright &copy; from NewsAggregator
 * @version 1.0.0
 * @date 2024/09/27 20:44
 */


namespace App\Services\Auth;

use App\Repositories\User\UserRepositoryInterface;

class AuthService implements AuthServiceInterface
{
    /**
     * @param UserRepositoryInterface $authRepository
     */
    public function __construct(protected UserRepositoryInterface $authRepository)
    {
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function login(array $attributes): mixed
    {
        return $this->authRepository->login($attributes);
    }

    /**
     * @param array $attributes
     * @return array
     */
    public function register(array $attributes): array
    {
        return $this->authRepository->register($attributes);
    }
}
