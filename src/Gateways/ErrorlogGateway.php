<?php

/*
 * This file is part of the overtrue/easy-sms.
 * (c) overtrue <i@overtrue.me>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Overtrue\EasySms\Gateways;

use Overtrue\EasySms\Contracts\MessageInterface;
use Overtrue\EasySms\Support\Config;

/**
 * Class ErrorlogGateway.
 */
class ErrorlogGateway extends Gateway
{
    /**
     * @param array|int|string                             $to
     * @param \Overtrue\EasySms\Contracts\MessageInterface $message
     * @param \Overtrue\EasySms\Support\Config             $config
     *
     * @return bool
     */
    public function send($to, MessageInterface $message, Config $config)
    {
        if (is_array($to)) {
            $to = join(',', $to);
        }

        $message = sprintf(
            "[%s] to: %s | message: \"%s\"  | template: \"%s\" | data: %s\n",
            date('Y-m-d H:i:s'),
            $to,
            $message->getContent(),
            $message->getTemplate(),
            json_encode($message->getData())
        );

        return error_log($message, 3, $this->config->get('file', ini_get('error_log')));
    }
}
