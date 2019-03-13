
$(function(){

  $("#intro_start").click(function(){
        
      var introguide = introJs();
 
 
          introguide.setOptions({
          steps: [    

              { 
                intro: "Welcome to RSS!"
              },
 
              {
                element: '#dashboard',
                intro: 'This the Dashboard Page, where you can add accounts (assets/transports) .',
                position: 'bottom'
              },

              {
                element: '#archive',
                intro: 'This the Archive Page, where you can view all the archived videos .',
                position: 'bottom'
              },

              {
                element: '#sms',
                intro: 'This the SMS Page, where you can send SMS to the accounts you have created .',
                position: 'bottom'
              },
 

              {
                element: '#dashboard',
                intro: 'This the Dashboard Page, where you can add accounts (assets/transports) .',
                position: 'bottom'
              },

              {
                element: '#archive',
                intro: 'This the Archive Page, where you can view all the archived videos .',
                position: 'bottom'
              },

              {
                element: '#sms',
                intro: 'This the SMS Page, where you can send SMS to the accounts you have created .',
                position: 'bottom'
              },
 
              {
                element: '.readtutorial a',
                intro: 'Click this orange button to view the tutorial article in a new tab.',
                position: 'right'
              },
 
              {
                element: '.nav-menu',
                intro: "Each demo will link to the previous & next entries.",
                position: 'bottom'
              }
          ]
 
      });   

      introguide.start();
 
      });      
 
  });

 