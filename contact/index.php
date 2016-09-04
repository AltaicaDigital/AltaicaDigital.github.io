<!DOCTYPE html>
<html lang='en'>
  <head>
    <meta charset='utf-8'>
    <meta content='nanoc 3.8.0' name='generator'>
    <meta content='width=device-width, initial-scale=1' name='viewport'>
    <title>
      Subcritical, Inc. - Contact
    </title>
    <link href='/css/style.css' rel='stylesheet'>
    <script src='/js/jquery.js' type='text/javascript'></script>
    <script src='/js/bootstrap.js' type='text/javascript'></script>
  </head>
  <body>
    <div class='container' id='container'>
      <div class='row' id='banner'>
        Altaica Digital
      </div>
      <div class='row' id='navbar'>
        <ul class='nav nav-pills'>
          <li>
            <a href='/'>Home</a>
          </li>
          <li class='dropdown'>
            <a class='dropdown-toggle' data-toggle='dropdown' href='/products/'>
              Products
              <span class='caret'></span>
            </a>
            <ul class='dropdown-menu'>
              <li>
                <a href='/products/ljwb'>LR-JET Weight & Balance</a>
              </li>
              <li>
                <a href='/products/gwb'>Gulfstream Weight & Balance</a>
              </li>
            </ul>
          </li>
          <li>
            <a href='/contact'>Contact</a>
          </li>
        </ul>
      </div>
      
      <?php
      
      	require_once 'HTML/QuickForm.php';
      	require_once 'Mail.php';
      
      	function check_email($email)
      	{
      		$validEmailExpr = "^[0-9a-z~!#$%&_-]([.]?[0-9a-z~!#$%&_-])*" . "@[0-9a-z~!#$%&_-]([.]?[0-9a-z~!#$%&_-])*$";
      		$maildomain = substr(strstr($email, '@'), 1);
      		if (empty($email)) {return false;}
      		elseif (!eregi($validEmailExpr, $email)) {return false;}
      		elseif(strlen($email) > 30) {return false;}
      		elseif(function_exists("getmxrr") && function_exists("gethostbyname"))
      		{
      			$maildomain = substr(strstr($email, '@'), 1);
      			if(!(getmxrr($maildomain, $temp) || gethostbyname($maildomain) != $maildomain)) return false;
      		}
      		return true;
      	}
      	
      ?>
      <div id="mailform">
      <?php
      
      	$form = new HTML_QuickForm('contactForm');
      	
      	$form->setJsWarnings('There is a problem with your submission:', null);
      	$form->registerRule('valid_email', 'callback', 'check_email');
      	
      	$address = '';
      	$message = '';
      	$subject = 'Altaica Digital contact form';
      	if(isset($_GET['email'])) $address = $_GET['email'];
      	if(isset($_GET['message'])) $message = $_GET['message'];
      	if(isset($_GET['subject'])) $subject = $_GET['subject'];
      	
      	$form->setDefaults(array('subject' => $subject,
      							 'email' => $address,
      							 'message' => $message));
      	//$form->addElement('header', null, 'Altaica Digital Contact Form');
      	$form->addElement('text', 'name', 'Name:', 'size=50');
      	$form->addElement('text', 'email', 'E-mail Address:', 'size=50');
      	$form->addElement('text', 'subject', 'Subject:', 'size=50');
      	$form->addElement('textarea', 'message', 'Message:', 'cols=47 rows=8');
      	$form->addElement('submit', null, 'Send');
      	
      	$form->applyFilter('name', 'trim');
      //	$form->applyFilter('email', 'trim');
      	$form->applyFilter('subject', 'trim');
      	$form->applyFilter('message', 'trim');
      	
      	$form->addRule('email', 'The e-mail address field is blank.', 'required', null, 'client');
      	$form->addRule('email', 'The e-mail address is invalid.', 'email', null, 'client');
      	$form->addRule('email', 'The e-mail address is invalid.', 'valid_email', null, 'server');
      	$form->addRule('subject', 'The subject field is blank.', 'required', null, 'client');
      	$form->addRule('message', 'The message field is blank.', 'required', null, 'client');
      
      	if($form->validate()) {
      	
      ?>	
      		<div id="success_message">Thank you. Your message has been sent to Altaica Digital support.</div>
      		</div>
      
      	
      <?php
      		//Send the message
      		$values = $form->exportValues();
      		$headers = array(
      							'From' 	=> 	$values['email'],
      							//'To'	=>	'support@subcritical.com',
      							'Subject' =>	$values['subject']);
      		$body = $values['message'];
      		
      		$mail =& Mail::factory('mail');
      		$mail->send('support@subcritical.com', $headers, $body);
      		exit;
      	}
      ?>
      
      <?php
      	
      	$form->display();
      ?>
      </div>
      <div class='footer' id='footer'>
        <p class='small'>
          Copyright Altaica Digital, Inc. 2016
          &nbsp;
          <a href='/legal'>Legal Notices</a>
          &nbsp;
          <a href='/privacy'>Privacy Notice</a>
        </p>
      </div>
    </div>
  </body>
</html>
