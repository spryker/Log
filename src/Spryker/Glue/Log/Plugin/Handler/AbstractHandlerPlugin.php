<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\Log\Plugin\Handler;

use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\HandlerInterface;
use Spryker\Glue\Kernel\AbstractPlugin;
use Spryker\Shared\Log\Dependency\Plugin\LogHandlerPluginInterface;

/**
 * @method \Spryker\Glue\Log\LogFactory getFactory()
 */
abstract class AbstractHandlerPlugin extends AbstractPlugin implements LogHandlerPluginInterface
{
    /**
     * @var \Monolog\Handler\HandlerInterface|null
     */
    protected $handler;

    /**
     * @return \Monolog\Handler\HandlerInterface
     */
    abstract protected function getHandler(): HandlerInterface;

    /**
     * @param array $record
     *
     * @return bool
     */
    public function isHandling(array $record): bool
    {
        return $this->getHandler()->isHandling($record);
    }

    /**
     * @param array $record
     *
     * @return bool
     */
    public function handle(array $record): bool
    {
        return $this->getHandler()->handle($record);
    }

    /**
     * @param array $records
     *
     * @return void
     */
    public function handleBatch(array $records): void
    {
        $this->getHandler()->handleBatch($records);
    }

    /**
     * @param callable $callback
     *
     * @return \Monolog\Handler\HandlerInterface
     */
    public function pushProcessor($callback): HandlerInterface
    {
        /** @var \Monolog\Handler\ProcessableHandlerInterface $handler */
        $handler = $this->getHandler();

        return $handler->pushProcessor($callback);
    }

    /**
     * @return callable
     */
    public function popProcessor(): callable
    {
        /** @var \Monolog\Handler\ProcessableHandlerInterface $handler */
        $handler = $this->getHandler();

        return $handler->popProcessor();
    }

    /**
     * @param \Monolog\Formatter\FormatterInterface $formatter
     *
     * @return \Monolog\Handler\HandlerInterface
     */
    public function setFormatter(FormatterInterface $formatter): HandlerInterface
    {
        /** @var \Monolog\Handler\FormattableHandlerInterface $handler */
        $handler = $this->getHandler();

        return $handler->setFormatter($formatter);
    }

    /**
     * @return \Monolog\Formatter\FormatterInterface
     */
    public function getFormatter(): FormatterInterface
    {
        /** @var \Monolog\Handler\FormattableHandlerInterface $handler */
        $handler = $this->getHandler();

        return $handler->getFormatter();
    }

    /**
     * @return void
     */
    public function close(): void
    {
        $handler = $this->getHandler();

        if (method_exists($handler, 'close')) {
            $this->getHandler()->close();
        }
    }
}
