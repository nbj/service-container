<?php

namespace Nbj\Service;

class ServiceContainer
{
    /**
     * Holds the list of registered service
     *
     * @var array $services
     */
    public static $services = [];

    /**
     * Registers a service to a key
     *
     * @param string $key
     * @param mixed $service
     *
     * @throws Exceptions\ServiceHasAlreadyBeenRegistered
     */
    public static function register($key, $service)
    {
        if (self::has($key)) {
            throw new Exceptions\ServiceHasAlreadyBeenRegistered($key);
        }

        self::$services[$key] = $service;
    }

    /**
     * Resolves a service from the container by its key
     *
     * @param string $key
     *
     * @return mixed
     *
     * @throws Exceptions\ServiceWasNotFound
     */
    public static function resolve($key)
    {
        if (self::doesNotHave($key)) {
            throw new Exceptions\ServiceWasNotFound($key);
        }

        return self::$services[$key];
    }

    /**
     * Checks if a service exists within the container
     *
     * @param string $key
     *
     * @return bool
     */
    public static function has($key)
    {
        return array_key_exists($key, self::$services);
    }

    /**
     * Syntactic sugar for negating has() - Checks if the container does NOT have a specific service
     *
     * @param string $key
     *
     * @return bool
     */
    public static function doesNotHave($key)
    {
        return ! self::has($key);
    }

    /**
     * Forgets a service
     *
     * @param string $key
     *
     * @return bool
     */
    public static function forget($key)
    {
        if (self::has($key)) {
            unset(self::$services[$key]);
        }

        return true;
    }
}
