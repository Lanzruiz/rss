<div class="row container" style="text-align:center; margin: 0 auto; padding-top: 30px; padding-bottom: 30px;" >
  @if(Session::has('error'))
      <div class="alert alert-danger">{{Session::get('error')}}</div>
  @endif

  @if(Session::has('success'))
      <div class="alert alert-success">{{Session::get('success')}}</div>
  @endif


  <div class="alert alert-warning">NEED MORE DATA? SUBSCRIBE NOW!</div>

    <div class="col-sm-3 col-xs-12">
              <div class="card">
                    <div class="card__side card__side--front">
                        <div class="card__picture card__picture--1">
                           &nbsp;
                        </div>
                        <h4 class="card__heading">
                           <span class="card__heading-span card__heading-span--1">
                               Bronze
                           </span>


                        </h4>
                        <div class="card__details">
                            <ul>
                                <li>1 Month Subscription</li>
                                <li>Up to 1GB of Data Storage</li>
                                <li>Real time streaming</li>
                                <li>Video Live Streaming</li>
                                <li>Archived Data Storage</li>

                            </ul>
                        </div>
                    </div>
                    <div class="card__side card__side--back card__side--back-1">
                         <div class="card__cta">
                            <div class="card__price-box">
                                <p class="card__price-only">Only</p>
                                <p class="card__price-value">$1.99</p>
                            </div>
                            <a  href="{{url('subscription/process/1')}}" class="btnsubscription btnsubscription--white">Subscribe Now!</a>
                         </div>
                    </div>

                 </div>
    </div>
    <div class="col-sm-3 col-xs-12">
      <div class="card">
            <div class="card__side card__side--front">
                <div class="card__picture card__picture--2">
                   &nbsp;
                </div>
                <h4 class="card__heading">
                   <span class="card__heading-span card__heading-span--2">
                       Silver
                   </span>


                </h4>
                <div class="card__details">
                    <ul>
                        <li>1 Month Subscription</li>
                        <li>Up to 10GB of Data Storage</li>
                        <li>Real time streaming</li>
                        <li>Video Live Streaming</li>
                        <li>Archived Data Storage</li>

                    </ul>
                </div>
            </div>
            <div class="card__side card__side--back card__side--back-2">
                 <div class="card__cta">
                    <div class="card__price-box">
                        <p class="card__price-only">Only</p>
                        <p class="card__price-value">$14.99</p>
                    </div>
                    <a  href="{{url('subscription/process/2')}}" class="btnsubscription btnsubscription--white">Subscribe Now!</a>
                 </div>
            </div>

         </div>
    </div>
    <div class="col-sm-3 col-xs-12">
      <div class="card">
            <div class="card__side card__side--front">
                <div class="card__picture card__picture--3">
                   &nbsp;
                </div>
                <h4 class="card__heading">
                   <span class="card__heading-span card__heading-span--3">
                       gold
                   </span>


                </h4>
                <div class="card__details">
                    <ul>
                        <li>1 Month Subscription</li>
                        <li>Up to 50GB of Data Storage</li>
                        <li>Real time streaming</li>
                        <li>Video Live Streaming</li>
                        <li>Archived Data Storage</li>

                    </ul>
                </div>
            </div>
            <div class="card__side card__side--back card__side--back-3">
                 <div class="card__cta">
                    <div class="card__price-box">
                        <p class="card__price-only">Only</p>
                        <p class="card__price-value">$59.99</p>
                    </div>
                    <a  href="{{url('subscription/process/3')}}" class="btnsubscription btnsubscription--white">Subscribe Now!</a>
                 </div>
            </div>

         </div>
    </div>
    <div class="col-sm-3 col-xs-12">
      <div class="card">
            <div class="card__side card__side--front">
                <div class="card__picture card__picture--4">
                   &nbsp;
                </div>
                <h4 class="card__heading">
                   <span class="card__heading-span card__heading-span--4">
                       platinum
                   </span>


                </h4>
                <div class="card__details">
                    <ul>
                        <li>1 Month Subscription</li>
                        <li>Up to 100GB of Data Storage</li>
                        <li>Real time streaming</li>
                        <li>Video Live Streaming</li>
                        <li>Archived Data Storage</li>

                    </ul>
                </div>
            </div>
            <div class="card__side card__side--back card__side--back-4">
                 <div class="card__cta">
                    <div class="card__price-box">
                        <p class="card__price-only">Only</p>
                        <p class="card__price-value">$99.99</p>
                    </div>
                    <a  href="{{url('subscription/process/4')}}" class="btnsubscription btnsubscription--white">Subscribe Now!</a>
                 </div>
            </div>

         </div>
    </div>
</div>
