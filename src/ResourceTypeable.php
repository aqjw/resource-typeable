<?php

namespace Aqjw\ResourceTypeable;

trait ResourceTypeable
{
    /**
     * Resource type
     * 
     * @var string
     */
    protected static $resource_type = 'tiny';

    /**
     * Set resourse type and create a new resource instance.
     * 
     * @param  string $type
     * @param  mixed  ...$parameters
     * @return static
     */
    public static function makeType(string $type, ...$parameters)
    {
        self::$resource_type = $type;

        return new static(...$parameters);
    }

    /**
     * Set resourse type and create a new anonymous resource collection.
     * 
     * @param  string $type
     * @param  mixed  $resource
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public static function collectionType(string $type, $resource)
    {
        self::$resource_type = $type;

        return self::collection($resource);
    }

    /**
     * Call resource type method or parent one
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if (method_exists($this, self::$resource_type)) {
            return call_user_func([$this, self::$resource_type], $request);
        }

        return parent::toArray($request);
    }
}