<html>
<body>
  <div style='width: 100%; background-color:#070f71; padding:5px;'>
      <img src='https://raptorsecuritysoftware.com/public/assets/images/main-logo.png' width='200px'>
  </div>
  <p>Dear {{$fullname}}</p>
  <p>Commander {{$commander->fldUsersFullname}} has registered an account for you as {{$userLevel}} at {{PRODUCT_TITLE}}. You will receive a text message shortly with your activation
    code to download and install the {{PRODUCT_TITLE}} app directly from your phone. Simply follow the instructions to install and use {{PRODUCT_TITLE}}.</p>
  <p>Here is the contact information that was provided by Commander {{$commander->fldUsersFullname}}:</p>
  <ul>
      <li>Name: {{$commander->fldUsersUserName}}</li>
      <li>Mobile Number: {{$commander->fldUsersMobile}}</li>
      <li>Email Address: {{$commander->fldUsersEmail}}</li>
      
  </ul>

 

<p>NOTE: If any part of your contact information is incorrect, please contact Commander {{$commander->fldUsersFullname}} @ {{$commander->fldUsersEmail}}</p>
<p>Please retain the below authorized user credentials for your records:</p>
 <p>Username: {{$username}}</p>
  <p>Password: {{$password}}</p>
<p>Your activation code is: {{$user->fldUsersAccessCode}} <br> App installation link: <a href='https://raptorsecuritysoftware.com/dllp'>Download</a> and install the app</p>
<p>Any questions, please email client support services here: info@0321technologies.com</p>
<p style='background-color:#CCC; text-align:left; padding:5px; border:1px solid #999'>NOTICE: This email and any attachments contain confidential information intended only for the individual(s) named above. You are strictly prohibited from any unauthorized use, disclosure, distribution, broadcasting, web site posting, hyperlinking to, saving to disk or forwarding this email. If you have received this email in error, please notify the sender immediately and delete/destroy any and all copies of the original message. If you are not the intended recipient you are further notified that disclosing, copying, distributing, broadcasting, web site posting, hyperlinking to, saving to disk or forwarding this email or taking any action in reliance upon the contents of this information is strictly prohibited.</p>
</body>
</html>
