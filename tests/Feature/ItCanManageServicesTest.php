<?php

namespace Tests\Feature;

use Exception;
use PHPUnit\Framework\TestCase;
use Nbj\Service\ServiceContainer;
use Nbj\Service\Exceptions\ServiceWasNotFound;
use Nbj\Service\Exceptions\ServiceHasAlreadyBeenRegistered;

class ItCanManageServicesTest extends TestCase
{
    /** @test */
    public function the_service_container_takes_exception_to_resolving_unregistered_services()
    {
        $service = null;

        try {
            $service = ServiceContainer::resolve('some-unregistered-service');
        } catch (Exception $exception) {
            $this->assertEquals('No service was found with the key [some-unregistered-service]', $exception->getMessage());
            $this->assertInstanceOf(ServiceWasNotFound::class, $exception);
        }

        $this->assertNull($service);
    }

    /** @test */
    public function the_service_container_takes_exception_to_registering_an_already_existing_service()
    {
        ServiceContainer::register('some-service', 'this-should-be-an-instance-of-some-service');

        $checkFlag = false;

        try {
            ServiceContainer::register('some-service', 'this-should-also-be-an-instance-of-some-service');

            $checkFlag = true;
        } catch (Exception $exception) {
            $this->assertEquals('A service with the key [some-service] has already been registered', $exception->getMessage());
            $this->assertInstanceOf(ServiceHasAlreadyBeenRegistered::class, $exception);
        }

        $this->assertFalse($checkFlag);
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function services_can_be_registered_and_resolved()
    {
        ServiceContainer::register('some-service', 'this-should-be-an-instance-of-some-service');

        $service = ServiceContainer::resolve('some-service');

        $this->assertEquals($service, 'this-should-be-an-instance-of-some-service');
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function services_can_be_forgotten()
    {
        ServiceContainer::register('some-service', 'this-should-be-an-instance-of-some-service');

        $this->assertTrue(ServiceContainer::has('some-service'));

        ServiceContainer::forget('some-service');

        $this->assertFalse(ServiceContainer::has('some-service'));
    }
}
