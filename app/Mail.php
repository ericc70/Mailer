<?php

// namespace app;



class Mailer
{

    // array of destinataires
    protected $destinataire = array();
    // array of header
    protected $headers = array();



    /**
     * add to adreese email
     * it is possible to call the method several times 
     *
     * @param string $email
     * @return void
     */
    public function addTo(string $email): ?string
    {


        try {
            $this->destinataire['To'][] = $email;
        } catch (Exception $e) {
            $this->exeption[] = $e->getMessage();
            return $e->getMessage();
        } finally {
            return 0;
        }
    }

    /**
     * add many adress email with one method
     *
     * @param array $email
     * @return void
     */
    public function addManyTo(array $email): ?string
    {

        try {
            foreach ($email as $value) {
                $this->destinataire['To'][] = $value;
            }
        } catch (Exception $e) {
            $this->exeption[] = $e->getMessage();
            return $e->getMessage();
        } finally {
            return 0;
        }
    }

    /**
     * Add adress email in CC
     * it is possible to call the method several times 
     *
     * @param string $email
     * @return void
     */
    public function addCC(string $email): ?string
    {

        try {
            $this->destinataire['Cc'][] = $email;
        } catch (Exception $e) {
            $this->exeption[] = $e->getMessage();
            return $e->getMessage();
        } finally {
            return 0;
        }
    }
    /**
     * add many email in cc
     *
     * @param array $email
     * @return void
     */
    public function addManyCC(array $email): ?string
    {

        try {

            foreach ($email as $value) {
                $this->destinataire['Cc'][] = $value;
            }
        } catch (Exception $e) {
            $this->exeption[] = $e->getMessage();
            return $e->getMessage();
        } finally {
            return 0;
        }
    }

    /**
     * Add adress email in BCC
     * it is possible to call the method several times 
     *
     * @param string $email
     * @return void
     */
    public function addBCC(string $email): ?string
    {
        try {
            $this->destinataire['Bcc'][] = $email;
        } catch (Exception $e) {
            $this->exeption[] = $e->getMessage();
            return $e->getMessage();
        } finally {
            return 0;
        }
    }

    /**
     * add many BCC in one method
     *
     * @param array $email
     * @return void
     */
    public function addManyBCC(array $email): ?string
    {
        try {
            foreach ($email as $value) {
                $this->destinataire['Bcc'][] = $value;
            }
        } catch (Exception $e) {
            $this->exeption[] = $e->getMessage();
            return $e->getMessage();
        } finally {
            return 0;
        }
    }

    /**
     * Add object to email
     *
     * @param string $object
     * @return void
     */
    public function addObject(string $object = "Nouveau mail"): ?string
    {
        try {
            $this->object = htmlentities( $object);
        } catch (Exception $e) {
            $this->exeption[] = $e->getMessage();
            return $e->getMessage();
        } finally {
            return 0;
        }
    }

    /**
     * Return the value of Object email
     *
     * @return string
     */
    public function getObject(): string
    {
        return $this->object;
    }

    /**
     * Add value of message to email
     *
     * @param string $content
     * @return void
     */
    public function addBody(string $content): ?string
    {
        try{
        $this->content = $content;
        }catch (Exception $e) {
            $this->exeption[] = $e->getMessage();
            return $e->getMessage();
        } finally {
            return 0;
        }
        
    
    }

    /**
     * Return value of body (message)
     *
     * @return string
     */
    public function getBody(): string
    {
        return $this->content;
    }


    /**
     * build email header 
     *
     * @param [type] $header
     * @param [type] $value
     * @return void
     */
    public function setHeader(string $header, string $value): void
    {
        $this->headers[$header] = $value;
    }

    /**
     * return value of header
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }


    public function formatHtml(bool $value = true): void
    {
        if ($value == true) {
            if (!isset($this->mime_boundary)) {
                $this->setHeader('MIME-Version', '1.0');
                $this->setHeader('Content-Type', 'text/html; charset=UTF-8');
            }
        } else {
            $this->setBoundary();
        }
    }

    /**
     * 
     *Encode header email for use function mail()
     * @return array
     */
    public function encodeHeaders(): array
    {
        $headers = [];
        if (isset($this->headers)) {
            foreach ($this->headers as $header => $value) {
                $headers[$header] = $value;
            }
        }
        return $headers;
    }

    /**
     * contruct boundary for email attachement
     *
     * @return void
     */
    private function setBoundary(): void
    {

        $semi_rand = md5(time());
        $this->mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

        $this->setHeader('NIME-Version', '1.0');
        $this->setHeader('Content-Type', " 
        multipart/mixed;\n" . " boundary=\"{$this->mime_boundary}\"
        ");
    }

    /**
     * 
     * Add file in email
     *
     * @param string $file
     * @return void
     */
    public function addAttachement(string $file): void
    {
        if (!isset($this->mime_boundary)) $this->setBoundary();
        if (!isset($this->backupBody)) $this->backupBody = $this->getBody();

        // $this->mime_boundary = $this->setBoundary();

        if (!isset($this->messageHead)) {
            $this->messageHead = "--{$this->mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
                "Content-Transfer-Encoding: Content-Transfer-Encoding\n\n";
        }

        $this->messageAttachment = $this->file($file);

        $message = $this->messageHead . $this->backupBody . "\n\n" . $this->messageAttachment . "--{$this->mime_boundary}--";
        //    $message = $this->messageHead . $this->backupBody . "\n\n". $this->messageAttachment .  $this->message .= "--{$this->mime_boundary}--";

        $this->addBody($message);
        // echo $this->addBody($message);


    }

    /**
     * Construt the message with boundary
     *
     * @param string $file
     * @return string
     */
    protected function file(string $file): string
    {
        if (!empty($file) > 0) {
            if (is_file($file)) {

                if (!isset($this->message)) {
                    $this->message = "--{$this->mime_boundary}\n";
                } else {
                    $this->message .= "--{$this->mime_boundary}\n";
                }

                $fp =    @fopen($file, "rb");
                $data =  @fread($fp, filesize($file));

                @fclose($fp);
                $data = chunk_split(base64_encode($data));

                $this->message .= "Content-Type: application/octet-stream; name=\"" . basename($file) . "\"\n" .
                    "Content-Description: " . basename($file) . "\n" .
                    "Content-Disposition: attachment;\n" . " filename=\"" . basename($file) . "\"; size=" . filesize($file) . ";\n" .
                    "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
            }
        }
        //  $this->message .= "--{$this->mime_boundary}--" ."\n\n";
        return $this->message;
    }
    /**
     * send to email
     *
     * @return void
     */
    public function send(): bool
    {

        if (isset($this->destinataire['Cc'])) {
            $this->setHeader('Cc', implode(', ', $this->destinataire['Cc']));
        }

        if (isset($this->destinataire['Bcc'])) {
            $this->setHeader('Bcc', implode(', ', $this->destinataire['Bcc']));
        }

        // echo "<pre>";
        // print_r($this->encodeHeaders());
        // echo "<br>";
        // echo implode(', ', $this->destinataire['Cc']);
        // echo "</pre>";

        $to = implode(', ', $this->destinataire['To']);
        $subject = $this->getObject();

        $body = $this->getBody();

        $headers = $this->encodeHeaders();


        //  return @mail($to, $subject, $body,  $headers);
        return true; // for test raison risk of spam adress ip/email
    }


    /***
     * function __get pour test avec PHPunit
     */
    public function __get($name)
    {
        switch ($name) {
            case 'destinataire':
                return  $this->destinataire;
            break;
                // case 'header':
                //   return  $this->headesr;
                // break;
            default:
                //  throw new Exception("Propriety not found or forbidden");
            return false;
        }
    }
}
