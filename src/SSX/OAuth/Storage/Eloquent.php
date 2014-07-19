<?php

namespace SSX\OAuth\Storage;

use OAuth\Common\Token\TokenInterface;
use OAuth\Common\Storage\Exception\TokenNotFoundException;
use OAuth\Common\Storage\Exception\AuthorizationStateNotFoundException;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Eloquent implements \OAuth\Common\Storage\TokenStorageInterface
{
    private $session;
    private $sessionVariableName;
    private $stateVariableName;

    private $model;
    private $user_id;

    /**
     * @param SessionInterface $session
     * @param bool $startSession
     * @param string $sessionVariableName
     * @param string $stateVariableName
     */
    public function __construct(
        $model,
        $user_id
    ) {
        $this->model = $model;
        $this->user_id = $user_id;
    }

    /**
     * {@inheritDoc}
     */
    public function retrieveAccessToken($service)
    {
        // Set our model as a local variable
        $model = $this->model;

        if ($this->hasAccessToken($service)) {
            // We know that we can safely do a firstOrFail here, because the above check has returned true
            $user = $model::where("user_id", "=", $this->user_id)->where("service", "=", $service)->firstOrFail();

            // Unserialize the token object
            $token = unserialize($user->token);

            // Return it
            return $token;
        }

        throw new TokenNotFoundException('Token not found in session, are you sure you stored it?');
    }

    /**
     * {@inheritDoc}
     */
    public function storeAccessToken($service, TokenInterface $token)
    {
        // Set our model as a local variable
        $model = $this->model;

        // Test to see if we have a record
        $userRecord = $model::where("user_id", "=", $this->user_id)->where("service", "=", $service);

        if ($userRecord->count() > 0) {
            // We already have a record for this service, use it
            $user = $userRecord->firstOrFail();
            $user->token = serialize($token);
        } else
        {
            // We need to add a record for this service
            $user = new $this->model;
            $user->user_id = $this->user_id;
            $user->service = $service;
            $user->token = serialize($token);
        }

        // Save the model
        $user->save();

        // allow chaining
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function hasAccessToken($service)
    {
        // Set our model as a local variable
        $model = $this->model;

        // Test to see if we have a record
        $userRecord = $model::where("user_id", "=", $this->user_id)->where("service", "=", $service);

        // Test to see if a record was found
        if ($userRecord->count() > 0) {
            $user = $userRecord->firstOrFail();

            $unserializedToken = unserialize($user->token);
            if ($unserializedToken instanceof TokenInterface)
            {
                return true;
            } else
            {
                return false;
            }
        } else
        {
            return false;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function clearToken($service)
    {

        // Set our model as a local variable
        $model = $this->model;

        // Delete any records where our user_id is set
        $model::where("user_id", "=", $this->user_id)->where("service", "=", $service)->delete();

        // allow chaining
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function clearAllTokens()
    {
        // Set our model as a local variable
        $model = $this->model;

        // Delete any records where our user_id is set
        $model::where("user_id", "=", $this->user_id)->delete();

        // allow chaining
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function retrieveAuthorizationState($service)
    {

    }

    /**
     * {@inheritDoc}
     */
    public function storeAuthorizationState($service, $state)
    {
        // allow chaining
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function hasAuthorizationState($service)
    {

    }

    /**
     * {@inheritDoc}
     */
    public function clearAuthorizationState($service)
    {
        // allow chaining
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function clearAllAuthorizationStates()
    {
        // allow chaining
        return $this;
    }
}
