<?php

namespace Geomail\Mailer;

interface Mailer
{
    /**
     * @param Message $message
     */
    public function sendHtml(Message $message);
}
