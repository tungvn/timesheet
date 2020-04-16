<?php

namespace App\Timesheets;

class Task
{
    /** @var string */
    protected $task_id;

    /** @var string */
    protected $content;

    /** @var string */
    protected $spend_time;

    /**
     * @param string $property
     * @return bool
     */
    protected function hasProperty(string $property)
    {
        return in_array($property, [
            'task_id',
            'content',
            'spend_time',
        ]);
    }

    /**
     * @param string $property
     * @return mixed|null
     */
    public function __get(string $property)
    {
        if (!$this->hasProperty($property)) {
            return null;
        }

        return $this->{$property};
    }

    /**
     * @param string $property
     * @param mixed  $value
     */
    public function __set(string $property, $value)
    {
        if (!$this->hasProperty($property)) {
            return;
        }

        $this->{$property} = $value;
    }

    /**
     * Quick update by array input
     *
     * @param array $data
     */
    public function update(array $data)
    {
        if (empty($data)) {
            return;
        }

        collect($data)->each(function ($value, $key) {
            $this->{$key} = $value;
        });
    }
}
