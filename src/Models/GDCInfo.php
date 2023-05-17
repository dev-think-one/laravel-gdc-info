<?php

namespace GDCInfo\Models;

use Carbon\Carbon;
use GDCInfo\Exceptions\GDCInfoException;
use GDCInfo\Facades\GDCInfoManager;
use Illuminate\Database\Eloquent\Model;

class GDCInfo extends Model
{
    protected $primaryKey = 'gdc';
    public $incrementing = false;

    protected $guarded = [];

    protected $casts = [
        'first_registered_on' => 'date',
        'current_period_from' => 'date',
        'current_period_until' => 'date',
        'last_fetched_at' => 'datetime',
        'data' => 'array',
    ];

    public function getTable(): string
    {
        return config('gdc-info.tables.gdc_info');
    }


    public function infoFromData(): \GDCInfo\GDCInfo
    {
        return \GDCInfo\GDCInfo::fromArray($this->data);
    }

    public static function findOrFetch(int $gdc): ?static
    {
        return static::find($gdc) ?? static::fetch($gdc);
    }

    public static function fetch(int $gdc): ?static
    {
        try {
            /** @var \GDCInfo\GDCInfo $gdcInfo */
            $gdcInfo = GDCInfoManager::infoByGdcNumber($gdc);
        } catch (GDCInfoException $e) {
            // nothing.
            return null;
        }

        $model = static::query()->find($gdcInfo->gdc());
        if (!$model) {
            $model = new static([
                (new static)->getKeyName() => $gdcInfo->gdc(),
            ]);
        }

        $model->first_name = $gdcInfo->firstName();
        $model->last_name = $gdcInfo->lastName();
        $model->status = $gdcInfo->status();
        $model->registrant_type = $gdcInfo->registrantType();
        $model->qualifications = $gdcInfo->qualifications();
        $model->first_registered_on = $gdcInfo->firstRegisteredOn();
        $model->current_period_from = $gdcInfo->currentPeriodFrom();
        $model->current_period_until = $gdcInfo->currentPeriodUntil();
        $model->data = $gdcInfo->toArray();
        $model->last_fetched_at = Carbon::now();
        $model->save();

        return $model;
    }
}
