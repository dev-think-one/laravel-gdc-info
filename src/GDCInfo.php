<?php

namespace GDCInfo;

use Carbon\Carbon;
use GDCInfo\Exceptions\GDCInfoException;
use Illuminate\Support\Arr;

class GDCInfo
{
    protected int $gdc;
    protected ?string $firstName = null;
    protected ?string $lastName = null;
    protected ?string $status = null;
    protected ?string $registrantType = null;
    protected ?Carbon $firstRegisteredOn = null;
    protected ?Carbon $currentPeriodFrom = null;
    protected ?Carbon $currentPeriodUntil = null;
    protected ?string $qualifications = null;
    protected array $additionalInfo = [];

    public function gdc(): int
    {
        return $this->gdc;
    }

    public function firstName(): ?string
    {
        return $this->firstName;
    }

    public function lastName(): ?string
    {
        return $this->lastName;
    }

    public function status(): ?string
    {
        return $this->status;
    }

    public function registrantType(): ?string
    {
        return $this->registrantType;
    }

    public function firstRegisteredOn(): ?Carbon
    {
        return $this->firstRegisteredOn;
    }

    public function currentPeriodFrom(): ?Carbon
    {
        return $this->currentPeriodFrom;
    }

    public function currentPeriodUntil(): ?Carbon
    {
        return $this->currentPeriodUntil;
    }

    public function qualifications(): ?string
    {
        return $this->qualifications;
    }

    public function additionalInfo(): array
    {
        return $this->additionalInfo;
    }

    public static function fromArray(array $data): static
    {
        $info = new static();

        if (!isset($data['registration_number']) || !is_numeric($data['registration_number'])) {
            throw new GDCInfoException('Incorrect registration_number.');
        }

        $info->gdc = $data['registration_number'];

        if (!empty($data['first_name'])) {
            $info->firstName = $data['first_name'];
        }

        if (!empty($data['last_name'])) {
            $info->lastName = $data['last_name'];
        }

        if (!empty($data['status'])) {
            $info->status = $data['status'];
        }
        if (!empty($data['registrant_type'])) {
            $info->registrantType = $data['registrant_type'];
        }
        if (!empty($data['qualifications'])) {
            $info->qualifications = $data['qualifications'];
        }
        if (!empty($data['first_registered_on']) && ($data['first_registered_on'] instanceof Carbon)) {
            $info->firstRegisteredOn = $data['first_registered_on'];
        }
        if (
            !empty($data['current_period_from']) &&
            !empty($data['current_period_until']) &&
            ($data['current_period_from'] instanceof Carbon) &&
            ($data['current_period_until'] instanceof Carbon)
        ) {
            $info->currentPeriodFrom = $data['current_period_from'];
            $info->currentPeriodUntil = $data['current_period_until'];
        }

        $info->additionalInfo = Arr::except($data, [
            'registration_number',
            'first_name',
            'last_name',
            'status',
            'registrant_type',
            'qualifications',
            'first_registered_on',
            'current_period_from',
            'current_period_until',
        ]);

        return $info;
    }

    public function toArray(): array
    {
        return array_filter([
            'registration_number' => $this->gdc(),
            'first_name' => $this->firstName(),
            'last_name' => $this->lastName(),
            'status' => $this->status(),
            'registrant_type' => $this->registrantType(),
            'qualifications' => $this->qualifications(),
            'first_registered_on' => $this->firstRegisteredOn(),
            'current_period_from' => $this->currentPeriodFrom(),
            'current_period_until' => $this->currentPeriodUntil(),
            ...$this->additionalInfo(),
        ]);
    }
}
