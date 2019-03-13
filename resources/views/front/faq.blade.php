@extends('layouts.front.index')

@section('content')

<style type="text/css">
  
  .download-buttons{
      display: block;
      width: 300px;
  }

</style>

 
   <div class="container">

      <div class="panel panel-default ">

      <h2> Frequently Asked Questions </h2>
    
      </div>
          
           <div class="panel panel-default ">
            <div class="panel-heading accordion-toggle collapsed question-toggle" data-toggle="collapse" data-parent="#faqAccordion" data-target="#question1">
                 <h4 class="panel-title">
                    <a href="#" class="ing">Q: How do I get started?</a>
              </h4>

            </div>
            <div id="question1" class="panel-collapse collapse" style="height: 0px;">
                <div class="panel-body">
                     <h5><span class="label label-primary">Answer</span></h5>

                    <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                </div>
            </div>
        </div>
        
    </div>


<!-- <div class="row" style="margin-top: 20px;">
   <div class="col-md-12 col-sm-12 col-xs-12">
     <div class="bg-video">
             <video class="bg-video__content col-md-12 col-sm-12 col-xs-12" autoplay muted controls>
                 <source src="{{url('public/assets/video/video.mp4')}}" type="video/mp4">
                  <source src="img/video.webm" type="video/webm">  -->
               <!--   Your browser is not supported! -->
            <!--  </video>
     </div>
   </div>
</div> -->


@stop

@section('headercodes')

   <style type="text/css">
       .download-buttons{
            width: 20%;
       }
       @media (max-width:480px){
          .download-buttons{
              width: 70%;
          }
       }

   </style>

   <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
   <script src="https://www.gstatic.com/firebasejs/3.2.1/firebase.js"></script>
   <script src="{{url('public/assets/js/firebase_conf.js')}}"></script>

@stop
