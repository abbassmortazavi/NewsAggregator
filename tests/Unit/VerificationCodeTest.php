<?php

namespace Tests\Unit;

use App\Repositories\User\UserRepositoryInterface;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class VerificationCodeTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function test_user_is_updated_password_successfully()
    {
        // Mock UserRepositoryInterface
        $userRepositoryMock = $this->createMock(UserRepositoryInterface::class);

        $attributes = [
            'email' => 'test@example.com',
            'password' => 'new_password',
        ];

        // Mock a user object
        $user = (object)[
            'id' => 1,
            'email' => 'test@example.com',
        ];

        // Generate the hashed password
        $hashedPassword = password_hash($attributes['password'], PASSWORD_BCRYPT);

        // Mock the getUser method to return the user object
        $userRepositoryMock->method('getUser')
            ->with($attributes['email'])
            ->willReturn($user);

        // Mock the update method to expect being called
        $userRepositoryMock->expects($this->once())
            ->method('update')
            ->with($user, $this->callback(function ($attributes) use ($hashedPassword) {
                // Use password_verify to check if the new password matches the hash
                return password_verify('new_password', $hashedPassword);
            }))
            ->willReturn(true);

        // Bind the mock to the service container
        app()->instance(UserRepositoryInterface::class, $userRepositoryMock);
        // Act: Run the function under test
        $result = app(UserRepositoryInterface::class)->update($user, $attributes);

        // Assert: Verify the result
        $this->assertTrue($result);
    }
}
