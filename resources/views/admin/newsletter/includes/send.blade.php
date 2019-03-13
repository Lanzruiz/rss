<div class="form-group">
  <label for="name">To</label></br>
  <input type="radio" name="to" value="all" checked> All User
  <input type="radio" name="to" value="commander" style="margin-left:15px;"> All Commander
  <input type="radio" name="to" value="agent" style="margin-left:15px;"> All Agent
  <input type="radio" name="to" value="transport" style="margin-left:15px;"> All Transport
</div>



<div class="form-group">
  <label for="name">From</label>
  <input type="text" class="form-control" id="from" name="from" value="info@0321technologies.com">
</div>

<div class="form-group">
  <label for="name">Subject</label>
  <input type="text" class="form-control" id="subject" name="subject" value="">
</div>

<div class="row">
    <div class="col-md-12">
        {!! $newsletter->fldNewsletterDescription !!}
    </div>
</div>


<div class="form-group">
    <input type="submit" class="btn btn-warning" value="Send Newsletter">
</div>
