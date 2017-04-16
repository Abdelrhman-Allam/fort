<?php

declare(strict_types=1);

namespace Rinvex\Fort\Contracts;

interface EmailVerificationTokenRepositoryContract
{
    /**
     * Create a new verification token.
     *
     * @param \Rinvex\Fort\Contracts\CanVerifyEmailContract $user
     *
     * @return string
     */
    public function create(CanVerifyEmailContract $user);

    /**
     * Determine if a verification token record exists and is valid.
     *
     * @param \Rinvex\Fort\Contracts\CanVerifyEmailContract $user
     * @param string                                        $token
     *
     * @return bool
     */
    public function exists(CanVerifyEmailContract $user, $token);

    /**
     * Delete tokens of the given user.
     *
     * @param \Rinvex\Fort\Contracts\CanVerifyEmailContract $user
     *
     * @return void
     */
    public function delete(CanVerifyEmailContract $user);

    /**
     * Delete expired verification tokens.
     *
     * @return void
     */
    public function deleteExpired();

    /**
     * Get the token expiration in minutes.
     *
     * @return int
     */
    public function getExpiration();

    /**
     * Get email verification token data.
     *
     * @param \Rinvex\Fort\Contracts\CanVerifyEmailContract $user
     *
     * @return array
     */
    public function getData(CanVerifyEmailContract $user);
}
