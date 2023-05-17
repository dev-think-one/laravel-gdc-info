<?php

namespace GDCInfo;

class GDCChecker
{
    protected static string $model = \GDCInfo\Models\GDCInfo::class;

    public static function useModel(string $modelClass): static
    {
        if (!is_subclass_of($modelClass, \GDCInfo\Models\GDCInfo::class)) {
            throw new \Exception("Class should be a model [{$modelClass}]");
        }

        static::$model = $modelClass;

        return new static();
    }

    /**
     * @return class-string \GDCInfo\Models\GDCInfo
     */
    public static function modelClass(): string
    {
        return static::$model;
    }

    public static function model(array $attributes = []): \GDCInfo\Models\GDCInfo
    {
        $modelClass = static::$model;

        /** @var \GDCInfo\Models\GDCInfo $model */
        $model = new $modelClass($attributes);

        return $model;
    }
}
