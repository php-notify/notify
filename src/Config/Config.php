<?php

namespace Notify\Config;

final class Config implements ConfigInterface
{
    /**
     * @var array<string, mixed>
     */
    private $config;

    public function __construct(array $config = array())
    {
        $this->config = $config;
    }

    /**
     * @inheritDoc
     */
    public function get($key, $default = null)
    {
        $data = $this->config;

        foreach (explode('.', $key) as $segment) {
            if (!isset($data[$segment])) {
                return $default;
            }

            $data = $data[$segment];
        }

        return $data;
    }
}
