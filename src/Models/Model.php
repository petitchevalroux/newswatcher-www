<?php

namespace NwWebsite\Models;

use NwWebsite\Di;

abstract class Model
{
    public $id = null;

    /**
     * Protected to avoid external use.
     */
    protected function __construct()
    {
    }

    /**
     * Return an entity.
     *
     * @param mixed $id if null a new model instance is created
     *
     * @return static
     */
    public static function get($id = null)
    {
        if (is_null($id)) {
            return static::getNewInstance();
        } else {
            return self::fetch($id);
        }
    }

    private static function getNewInstance()
    {
        $class = get_called_class();

        return new $class();
    }

    protected function setId($id)
    {
        $this->id = $id;
    }

    protected function getId()
    {
        return $this->id;
    }

    /**
     * Fetch object from storage.
     *
     * @param string $id
     */
    protected static function fetch($id)
    {
        $instance = self::getNewInstance();
        $instance->setId($id);
        $di = Di::getInstance();
        $resource = $di->api->getResource($instance->getResourcePath());
        $instance->mergeResource($resource);

        return $instance;
    }

    /**
     * Save the object to the storage.
     */
    public function save()
    {
        if (is_null($this->id)) {
            $this->create();
        } else {
            $this->update();
        }
    }

    /**
     * Object creation.
     */
    protected function create()
    {
        $di = Di::getInstance();
        $resourcePath = $this->getResourcePath();
        $resource = $di->api->createResource($resourcePath, $this->toResource());
        $this->mergeResource($resource);
    }

    /**
     * Object update.
     */
    protected function update()
    {
        $di = Di::getInstance();
        $resourcePath = $this->getResourcePath();
        $resource = $di->api->updateResource($resourcePath, $this->toResource());
        $this->mergeResource($resource);
    }

    /**
     * Return object's properties as keys and values.
     *
     * @return array
     */
    protected function getSerializableProperties()
    {
        return get_object_vars($this);
    }

    /**
     * merger resource property to current object.
     *
     * @param array $resource
     */
    protected function mergeResource($resource)
    {
        foreach ($resource as $property => $value) {
            $this->{$property} = $value;
        }
    }

    /**
     * Convert model instance to resource.
     *
     * @return array
     */
    protected function toResource()
    {
        $object = [];
        foreach ($this->getSerializableProperties() as $property => $value) {
            $object[$property] = $value;
        }
        unset($object['id']);

        return $object;
    }

    /**
     * Return resource path on api.
     *
     * @return string
     */
    public function getResourcePath()
    {
        $class = get_class($this);
        $finalClass = substr($class, mb_strlen('NwWebsite\\Models\\'));
        $path = '/'.mb_strtolower(str_replace('\\', '_', $finalClass));
        $id = $this->getId();
        if (!is_null($id)) {
            $path .= '/'.$id;
        }

        return $path;
    }

    /**
     * Associate $object to current model instance.
     *
     * @param \NwWebsite\Models\Model $object
     */
    public function associate(Model $object)
    {
        $resourcePath = $this->getResourcePath().$object->getResourcePath();
        $di = Di::getInstance();
        $di->api->createResource($resourcePath, null);
    }
}
