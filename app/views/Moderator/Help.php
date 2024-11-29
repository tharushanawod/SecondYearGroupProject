<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Moderator/Help.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
</head>
<body>
   <?php require 'sidebar.php';?>
       
    <div class="container">
        
   <div class="header">
    <h2>
     Inbox
    </h2>
    <img width="30" height="30" src="https://img.icons8.com/ios/50/messages-mac.png" alt="messages-mac"/>
   </div>
   <div class="main">
   <div class="chatsidebar">
     <h2>
      Recent Chats
     </h2>
     <ul class="chat-list">
      <li class="active">
       <div class="icon">
        <img alt="Farmer icon" height="30" src="https://storage.googleapis.com/a1aa/image/cYSYXS4DgCYiLNLI4C2pKZM4UIpm7Fe3kNjvw6Z8TeZHBeqnA.jpg" width="30"/>
       </div>
       <div class="details">
        <div class="name">
         Hi I'm asking
        </div>
        <div class="role">
         Farmer
        </div>
       </div>
      </li>
      <li>
       <div class="icon">
        <img alt="Buyer icon" height="30" src="https://storage.googleapis.com/a1aa/image/WvjiJQmt2YYUARGL4L3UgxURyiLfB5Bb2xeNoWPf80hJC8qnA.jpg" width="30"/>
       </div>
       <div class="details">
        <div class="name">
         Business model canvas
        </div>
        <div class="role">
         Buyer
        </div>
       </div>
      </li>
      <li>
       <div class="icon">
        <img alt="Supplier icon" height="30" src="https://storage.googleapis.com/a1aa/image/fDEgwc6T5N1TXKnF1L6sp9geYeHaY1lxRUI0tjdWFUyNC8qnA.jpg" width="30"/>
       </div>
       <div class="details">
        <div class="name">
         UX researcher Q&amp;A
        </div>
        <div class="role">
         Supplier
        </div>
       </div>
      </li>
     </ul>
    </div>
    <div class="chat-window">
     <div class="messages">
      <div class="message">
       <div class="avatar">
        <img alt="User avatar" height="40" src="https://storage.googleapis.com/a1aa/image/hHhUGwKIh7KNANKpF3kEIUnoRYVtNEBRbePXih9JYMiiAv6JA.jpg" width="40"/>
       </div>
       <div class="text">
        <p>
         Hello! I've been thinking about developing some new skills. Any suggestions on where to start?
        </p>
       </div>
      </div>
      <div class="message user">
       <div class="text">
        <p>
         Hi there! That's great to hear. The first step is to identify your interests. What areas are you passionate about or curious to explore?
        </p>
       </div>
       <div class="avatar">
        <img alt="Responder avatar" height="40" src="https://storage.googleapis.com/a1aa/image/xXxlrw3VyKaGGRzyfcf5bzfUabDry8mCV2G5euJwUeYbIwreE.jpg" width="40"/>
       </div>
      </div>
      <div class="message">
       <div class="avatar">
        <img alt="User avatar" height="40" src="https://storage.googleapis.com/a1aa/image/hHhUGwKIh7KNANKpF3kEIUnoRYVtNEBRbePXih9JYMiiAv6JA.jpg" width="40"/>
       </div>
       <div class="text">
        <p>
         I've always been interested in graphic design, but I'm not sure where to begin.
        </p>
       </div>
      </div>
      <div class="message user">
       <div class="text">
        <p>
         Graphic design is a fantastic choice! To start, you might want to learn the basics of design principles and software tools. There are many online platforms offering courses like Adobe Creative Cloud tutorials or design fundamentals. What specific aspects of graphic design are you interested in?
        </p>
       </div>
       <div class="avatar">
        <img alt="Responder avatar" height="40" src="https://storage.googleapis.com/a1aa/image/xXxlrw3VyKaGGRzyfcf5bzfUabDry8mCV2G5euJwUeYbIwreE.jpg" width="40"/>
       </div>
      </div>
     </div>
     <div class="input-area">
      <input placeholder="Message" type="text"/>
      <button>
       <i class="fas fa-paper-plane">
       </i>
      </button>
     </div>
    </div>
   </div>
  </div>
</body>
</html>