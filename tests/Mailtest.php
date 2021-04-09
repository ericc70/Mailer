<?php


require './app/Mail.php';

use app\Mailer;
use PHPUnit\Framework\TestCase;



class Mailtest extends TestCase
{

    public function testObject()
    {
        $pp= new Mailer;
        $pp->addObject('toto@to.ml');
      
        $this->assertEquals('toto@to.ml', $pp->getObject() );
    }

    

    public function testSend()
    {
        $class= new Mailer;
        $class->addTo('mail@mail.lo');
        $class->addObject("Subject to email");
        $class->addBody("Lorem op cxjxnh jdfsm kdfj ùmsfr jdfnb sùpqosf ksmdqgjkldf ");
        $this->assertTrue($class->send() == 1);
    }

    public function testDestinataire()
    {
        $class= new Mailer;
           $class->addCC('mail@un.ok');
           $class->addCC('mail@deux.ok');
           $class->addManyCC(['mail@trois.sf','mail@quatre.df'] );
           $class->addBCC('mailbcc@un.ok');
    
           $result = Array(   
            'Cc' => Array ( 'mailto@un.fr' ),
            'Cc'=>Array('mail@un.ok','mail@deux.ok', 'mail@trois.sf','mail@quatre.df'),
            'Bcc'=>Array('mailbcc@un.ok')
           );

            $this->assertEquals($class->destinataire , $result);

    }

    public function testBody()
    {
        $class = new Mailer;
        $class->addBody("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eu fermentum erat. Donec magna dui, tristique quis porta quis, malesuada ac orci. Aliquam erat volutpat. Integer ac erat eu neque pretium iaculis. Aliquam et facilisis magna. Aliquam erat volutpat. Suspendisse convallis pharetra laoreet. Ut tellus mi, vehicula quis sodales nec, ornare eget nibh. Vivamus quis ipsum dignissim, egestas enim sed, imperdiet elit. ");
        $result ='Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eu fermentum erat. Donec magna dui, tristique quis porta quis, malesuada ac orci. Aliquam erat volutpat. Integer ac erat eu neque pretium iaculis. Aliquam et facilisis magna. Aliquam erat volutpat. Suspendisse convallis pharetra laoreet. Ut tellus mi, vehicula quis sodales nec, ornare eget nibh. Vivamus quis ipsum dignissim, egestas enim sed, imperdiet elit. ';
        $this->assertEquals($class->getBody() , $result);
    }


    
    
}