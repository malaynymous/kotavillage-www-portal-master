<?php

// Plugin file for dummy payment gateway. Shows 1 page allowing you to cancel or pay, and then payment succeeds as long as you click pay
class PG_Dummy extends PaymentGatewayPlugin
{

        function getPageContents($page = '')
        {
            if($page == '') $page = $this->currentPage();
            switch($page)
            {
                case "default":
                    return "
                <h1>This is the dummy payment gateway</h1>
                
                <p>All of this will be displayed between form tags, so we just need to worry about setting our buttons, as there will be a hidden input that tells us the form has been submitted</p>
                
                <input name='restartwizard' type='submit' value='Cancel'/>
                <input name='paysubmission' type='submit' value='Pay'/>        
                
                ";
                    break;
                case "finished":
                    return "<h1>Payment Successful</h1>The payment has been sucessfully processed and your account is now active with the following details...<br/>" .
                    "Username: " . $this->useraccount['Username']. "<br/>Password: " . $this->useraccount['Password'] .
                    "<br/><input name='restartwizard' type='submit' value='Restart Wizard'/>";
                    break;
            }
        }

        function processPage($page = '')
        {
            if($page == '') $page = $this->currentPage();
            echo "Processing page $page";
            $this->state['paid'] = false;
            if($_POST['paysubmission'] == 'Pay')
            {
                    // Set payment to done
                    $this->state['paid'] = true;
                    $page = "finished";
                    $this->setCurrentPage('finished');
            }
            return ($page);
        }
        
        
        // payment_details returns details to be stored along in the payment gateway
        function getPaymentDetails()
        {
                return 'Dummy payment: '. date('c') . "<br/>" . $this->useraccount['Username'];
        }
        
        // Function that lets us know when the payment has completed successfully
        function isPaymentCompleted()
        {
                return $this->state['paid'];
        }

}

?>
