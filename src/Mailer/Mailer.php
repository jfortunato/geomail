<?php

namespace Fortunato\Geomail\Mailer;

use Fortunato\Geomail\Email;

interface Mailer
{
    /**
     * @param Message $message
     * @param Email $to
     */
    public function sendHtml(Message $message, Email $to);
}
