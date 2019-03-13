<div class="form-group">
  <label for="name">Name</label>
  <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" value="{{isset($newsletter) ? $newsletter->fldNewsletterName : Request::old('name')}}">
  @if($errors->newsletter->first('name'))
    <div class="text-danger">{!!$errors->newsletter->first('name')!!}</div>
 @endif
</div>

<div class="form-group">
  <label for="name">description</label>
  <textarea id="description" name="description" placeholder="Enter text ...">{{isset($newsletter) ? $newsletter->fldNewsletterDescription : Request::old('description')}}</textarea>
  @if($errors->newsletter->first('description'))
    <div class="text-danger">{!!$errors->newsletter->first('description')!!}</div>
 @endif
</div>
