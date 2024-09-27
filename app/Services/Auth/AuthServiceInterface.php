<?php
/**
 * AuthServiceInterface.php
 * @author Abbass Mortazavi <abbassmortazavi@gmail.com | Abbass Mortazavi>
 * @copyright Copyright &copy; from NewsAggregator
 * @version 1.0.0
 * @date 2024/09/27 20:44
 */

namespace App\Services\Auth;

interface AuthServiceInterface
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function login(array $attributes): mixed;

    /**
     * @param array $attributes
     * @return mixed
     */
    public function register(array $attributes): mixed;

    public function sendResetCode(array $attributes): mixed;

}
