<?php if(!defined("APP")) die()?>
<div class="panel panel-default">
  <div class="panel-heading">
    Help &amp; Documentation
  </div>      
  <div class="panel-body settings">
  	<div class="row">
  		<div class="col-sm-3 sub-sidebar">
        <ul class="nav tabs">
          <li class="active"><a href="#main">Script Configuration</a></li>
          <li><a href="#mem">Membership</a></li>
        </ul>
  		</div>
  		<div class="col-sm-9">
  			<div class="tabbed" id="main">
  				<p>Current Version: <strong><?php echo _VERSION ?></strong> (<a href="http://gempixel.com/update.php?token=<?php echo md5("poll") ?>&amp;current=<?php echo _VERSION ?>">Check for Update</a>)</p>

  				<h3>Introduction</h3>
  				<p>This script allows you to run your own poll platform and gives you the ability monetize it by offering premium features. This script is fairly easy to setup and use.</p>

          <h4>Setting up</h4>
          <p>To set up this script, go to the settings page and fill out the fields with your info.</p>
          
          <h4>Adding Fonts</h4>
          <p>This script gives you the possibility to add fonts to your site. It uses <a href="https://www.google.com/fonts">Google Fonts'</a> directory. To add fonts, go to the site, find your fonts and then simply copy the name. For example if you would like to add '<a href="https://www.google.com/fonts#QuickUsePlace:quickUse/Family:">Open Sans</a>', simply copy and paste the name as is 'Open Sans' and paste in the textarea. You should add one font per line. Below is a sample of what the textarea should look like:</p>
          <pre>Open Sans <br />Droid Sans Mono <br />Cambo</pre>
  			</div>
        <div id="mem" class="tabbed">
          <h3>Membership Settings</h3>
          <p>This script offers a premium membership option that will unlock many advanced features. Currently the membership system works with PayPal. The configure this option, go the membership tab and fill the fields. Below is a list of features that will be unlocked once the user gets a premium membership.</p>

          <ol>
            <li>Advanced Statistics</li>
            <li>Possibility to reset polls daily or monthly</li>
            <li>Possibility to add a password</li>
            <li>Custom Google Analytics</li>
            <li>No Advertisements</li>
            <li>Brand-Free Polls</li>
            <li>Ability to Export Data to CSV</li>
          </ol>
          <h4>PayPal</h4>
          <p>Payments are made through PayPal. Please note that users will need to come back to site for payments to be recorded. Users who don't come back to site following the payment will not be upgraded however this can be done manually.</p>

          <h4>Membership Price</h4>
          <p>You can set the membership price under the settings. You have the ability to add it for both monthly and yearly. Discounts on the yearly membership will be calculated automatically based on the monthly membership, if any.</p>
        </div>        
  		</div>
  	</div>
  </div>