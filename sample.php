<?php



require 'app/Mail.php';


   $sender = new Mailer;
    
    
   $sender->addTo("mailto@un.fr");
    // solution one
   $sender->addCC('mail@mail.com');
   
   //  $sender->addCC('mail@local.home');
   
   // Solution two
   // $sender->addManyCC(['mail@mail.com','mail@mail.com'] );
   
   // sapmle with soluce one
   // while(...){
   //     $sender->addCC($data);
   // }

   // $sender->addBcc('mail@mail.com');
    
   $sender->addObject('Test class Mailler');
   $sender->addBody("In pretium erat ligula, quis fringilla massa luctus sed. Mauris faucibus scelerisque dapibus. Duis nisl lacus, porttitor a tortor non, posuere finibus quam. Mauris id dolor eget enim lacinia vulputate. Suspendisse potenti. Suspendisse accumsan turpis et leo cursus ultricies. In non massa risus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos");
   // $sender->addBody("<div><p>In pretium erat ligula, quis fringilla massa luctus sed. Mauris faucibus scelerisque dapibus. Duis nisl lacus, porttitor a tortor non, posuere finibus quam. Mauris id dolor eget enim lacinia vulputate. Suspendisse potenti. Suspendisse accumsan turpis et leo cursus ultricies. In <i>non massa risus</i>. Class aptent taciti sociosqu ad litora torquent per <b>conubia</b> nostra, per inceptos</p></div>");
   // $sender->addAttachement("test.txt");
   // $sender->addAttachement("front.js");
   // $sender->addAttachement("test2.html");
   $sender->formatHtml();
   $sender->send();





?>


