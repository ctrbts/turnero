<?php

/*
 * Copyright (C) 2021 Fernando Merlo
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

namespace Com\Notifications;

use Com\Interfaces\INotification;
use Config;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

final class EmailNotification implements INotification
{
    /**
     * Configuracion
     *
     * @var Config
     */
    private $config = null;

    private $Addresses = array();
    private $from = "";
    private $fromName = "";
    private $htmlBody = "";
    private $subject = "";
    private $TLSEncription = true;
    private $debugOutput = false;
    private $host = "";
    private $SMTPAuth = true;
    private $user = "";
    private $password = "";
    private $port = 465;

    public function __construct()
    {
        $this->loadConfiguration();

        if (!empty($this->config->smtpFrom)) {
            $this->from = $this->config->smtpFrom;
        }
    }

    public function send()
    {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            if ($this->debugOutput) {
                $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output
            }

            $mail->isSMTP();   // Send using SMTP
            $mail->Host     = (!empty($this->config)) ? $this->config->smtpHost : $this->host;
            $mail->SMTPAuth = (!empty($this->config)) ? $this->config->smtpAuth : $this->SMTPAuth;
            $mail->Username = (!empty($this->config)) ? $this->config->smtpUserName : $this->user;
            $mail->Password = (!empty($this->config)) ? $this->config->smtpPassword : $this->password;
            if ($this->TLSEncription) {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged ENCRYPTION_STARTTLS
            }

            $mail->Port = (!empty($this->config)) ? $this->config->smtpPort : $this->port;

            $mail->setFrom($this->from, $this->fromName);
            $mail->CharSet = 'UTF-8';

            foreach ($this->Addresses as $address) {
                $mail->addAddress($address);
            }

            $mail->isHTML(true);
            $mail->Subject = $this->subject;
            $mail->Body = $this->htmlBody;

            $mail->send();
        } catch (Exception $th) {
            throw $th;
        }

        return $this;
    }

    public function loadConfiguration()
    {
        try {
            $Config = new Config();
            $this->config = $Config;
        } catch (\Throwable $th) {
        }

        return $this;
    }

    /**
     * Set the value of Addresses
     *
     * @return  self
     */
    public function setAddresses(array $Addresses)
    {
        $this->Addresses = $Addresses;

        return $this;
    }

    /**
     * Set the value of from
     *
     * @return  self
     */
    public function setFrom(string $from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Set the value of htmlBody
     *
     * @return  self
     */
    public function setHtmlBody(string $htmlBody)
    {
        $this->htmlBody = $htmlBody;

        return $this;
    }

    /**
     * Set the value of subject
     *
     * @return  self
     */
    public function setSubject(string $subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Set the value of TLSEncription
     *
     * @return  self
     */
    public function setTLSEncription(bool $TLSEncription)
    {
        $this->TLSEncription = $TLSEncription;

        return $this;
    }

    /**
     * Set the value of debugOutput
     *
     * @return  self
     */
    public function setDebugOutput($debugOutput)
    {
        $this->debugOutput = $debugOutput;

        return $this;
    }

    /**
     * Set the value of fromName
     *
     * @return  self
     */
    public function setFromName(string $fromName)
    {
        $this->fromName = $fromName;

        return $this;
    }

    /**
     * Set the value of host
     *
     * @return  self
     */
    public function setHost(string $host)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * Set the value of SMTPAuth
     *
     * @return  self
     */
    public function setSMTPAuth(bool $SMTPAuth)
    {
        $this->SMTPAuth = $SMTPAuth;

        return $this;
    }

    /**
     * Set the value of user
     *
     * @return  self
     */
    public function setUser(string $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set the value of port
     *
     * @return  self
     */
    public function setPort($port)
    {
        $this->port = $port;

        return $this;
    }
}
