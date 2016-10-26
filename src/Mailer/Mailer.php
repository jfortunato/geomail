<?php

namespace Geomail\Mailer;

use Geomail\Email;

interface Mailer
{
    /**
     * @param Message $message
     * @param Email $to
     */
    public function sendHtml(Message $message, Email $to);
}
