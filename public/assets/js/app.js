(function(b,c){var a=b(".inner a.btn");c.metisButton=function(){b.each(a,function(){b(this).popover({placement:"bottom",title:this.innerHTML,content:this.outerHTML,trigger:(c.isTouchDevice)?"touchstart":"hover"})})};return c})(jQuery,Metis||{});(function(d,j){var a=[[0,3],[1,8],[2,5],[3,13],[4,1]],p=[[0,12],[2,2],[3,9],[4,4]],m=[],i=[],b=[],e=[],o=[],h=d("#human"),f=d("#eye"),g=d("#bar"),n=d("#heart"),c=d("#bernoilli");function l(q){return Math.sqrt(2)*Math.cos(q)/(Math.pow(Math.sin(q),2)+1)}function k(q){return Math.sqrt(2)*Math.cos(q)*Math.sin(q)/(Math.pow(Math.sin(q),2)+1)}j.MetisChart=function(){if(!d().plot){throw new Error("flot plugin require form MetisChart")}d.plot(h,[{data:a,label:"MAN"},{data:p,label:"WOMAN"}],{clickable:true,hoverable:true,series:{lines:{show:true,fill:true,fillColor:{colors:[{opacity:0.5},{opacity:0.15}]}},points:{show:true}}});d.plot(g,[{data:a,label:"BAR"}],{clickable:true,hoverable:true,series:{bars:{show:true,barWidth:0.6},points:{show:true}}});for(var r=-5;r<=5;r+=0.5){m.push([r,Math.pow(r,2)-25]);i.push([r,-Math.pow(r,2)+25])}for(var s=-2;s<=2.1;s+=0.1){b.push([s,Math.sqrt(400-s*s*100)]);b.push([s,-Math.sqrt(400-s*s*100)])}d.plot(f,[{data:i,lines:{show:true,fill:true}},{data:m,lines:{show:true,fill:true}},{data:b,lines:{show:true}}]);for(r=-2;r<=5;r+=0.01){e.push([16*Math.pow(Math.sin(r),3),13*Math.cos(r)-5*Math.cos(2*r)-2*Math.cos(3*r)-Math.cos(4*r)])}d.plot(d("#heart"),[{data:e,label:'<i class="fa fa-heart"></i>',color:"#9A004D"}],{series:{lines:{show:true,fill:true},points:{show:false}},yaxis:{show:true},xaxis:{show:true}});d("#heart .legendLabel").addClass("animated pulse");setInterval(function(){d("#heart .legendLabel .fa.fa-heart").toggleClass("fa-2x")},400);for(var q=0;q<=2*Math.PI;q+=0.01){o.push([l(q),k(q)])}d.plot(d("#bernoilli"),[{data:o,label:"Lemniscate of Bernoulli",lines:{show:true,fill:true}}])};return j})(jQuery,Metis||{});(function(a){Metis.dashboard=function(){a(".inlinesparkline").sparkline();var b=[10,8,5,7,4,4,1];a(".dynamicsparkline").sparkline(b);a(".dynamicbar").sparkline(b,{type:"bar",barColor:"green"});a(".inlinebar").sparkline("html",{type:"bar",barColor:"red"});a(".sparkline.bar_week").sparkline([5,6,7,2,0,-4,-2,4],{type:"bar",height:"40",barWidth:5,barColor:"#4d6189",negBarColor:"#a20051"});a(".sparkline.line_day").sparkline([5,6,7,9,9,5,4,6,6,4,6,7],{type:"line",height:"40",drawNormalOnTop:false});a(".sparkline.pie_week").sparkline([1,1,2],{type:"pie",width:"40",height:"40"});a(".sparkline.stacked_month").sparkline(["0:2","2:4","4:2","4:1"],{type:"bar",height:"40",barWidth:10,barColor:"#4d6189",negBarColor:"#a20051"});var c=new Date();var k=c.getDate();var e=c.getMonth();var n=c.getFullYear();var h=a("#calendar").fullCalendar({header:{left:"prev,today,next,",center:"title",right:"month,agendaWeek,agendaDay"},selectable:true,selectHelper:true,select:function(q,d,i){var m=prompt("Event Title:");if(m){h.fullCalendar("renderEvent",{title:m,start:q,end:d,allDay:i},true)}h.fullCalendar("unselect")},editable:true,events:[{title:"All Day Event",start:new Date(n,e,1),className:"label label-success"},{title:"Long Event",start:new Date(n,e,k-5),end:new Date(n,e,k-2),className:"label label-info"},{id:999,title:"Repeating Event",start:new Date(n,e,k-3,16,0),allDay:false,className:"label label-warning"},{id:999,title:"Repeating Event",start:new Date(n,e,k+4,16,0),allDay:false,className:"label label-inverse"},{title:"Meeting",start:new Date(n,e,k,10,30),allDay:false,className:"label label-important"},{title:"Lunch",start:new Date(n,e,k,12,0),end:new Date(n,e,k,14,0),allDay:false},{title:"Birthday Party",start:new Date(n,e,k+1,19,0),end:new Date(n,e,k+1,22,30),allDay:false},{title:"Click for Google",start:new Date(n,e,28),end:new Date(n,e,29),url:"http://google.com/"}]});var l=[],p=[];for(var g=0;g<14;g+=0.5){l.push([g,Math.sin(g)]);p.push([g,Math.cos(g)])}var j=a.plot(a("#trigo"),[{data:l,label:"sin(x)",points:{fillColor:"#4572A7",size:5},color:"#4572A7"},{data:p,label:"cos(x)",points:{fillColor:"#333",size:35},color:"#AA4643"}],{series:{lines:{show:true},points:{show:true}},grid:{hoverable:true,clickable:true},yaxis:{min:-1.2,max:1.2}});function o(d,m,i){a('<div id="tooltip">'+i+"</div>").css({position:"absolute",display:"none",top:m+5,left:d+5,border:"1px solid #fdd",padding:"2px","background-color":"#000",color:"#fff"}).appendTo("body").fadeIn(200)}var f=null;a("#trigo").bind("plothover",function(m,r,i){a("#x").text(r.x.toFixed(2));a("#y").text(r.y.toFixed(2));if(i){if(f!==i.dataIndex){f=i.dataIndex;a("#tooltip").remove();var d=i.datapoint[0].toFixed(2),q=i.datapoint[1].toFixed(2);o(i.pageX,i.pageY,i.series.label+" of "+d+" = "+q)}}else{a("#tooltip").remove();f=null}});a(".sortableTable").tablesorter()};return Metis})(jQuery);(function(a){Metis.formGeneral=function(){a(".with-tooltip").tooltip({selector:".input-tooltip"});if(a("#autosize").length){a("#autosize").autosize()}a("#limiter").inputlimiter({limit:140,remText:"You only have %n character%s remaining...",limitText:"You're allowed to input %n character%s into this field."});a("#tags").tagsInput();a(".chzn-select").chosen();a(".chzn-select-deselect").chosen({allow_single_deselect:true});a(".uniform").uniform();a("#validVal").validVal();a("#cp1").colorpicker({format:"hex"});a("#cp2").colorpicker();a("#cp3").colorpicker();a("#cp4").colorpicker().on("changeColor",function(d){a("#colorPickerBlock").css("background-color",d.color.toHex())});a("#dp1").datepicker({format:"mm-dd-yyyy"});a("#dp2").datepicker();a("#dp3").datepicker();a("#dp3").datepicker();a("#dpYears").datepicker();a("#dpMonths").datepicker();var b=new Date(2014,1,20);var c=new Date(2014,1,25);a("#dp4").datepicker().on("changeDate",function(d){if(d.date.valueOf()>c.valueOf()){a("#alert").show().find("strong").text("The start date can not be greater then the end date")}else{a("#alert").hide();b=new Date(d.date);a("#startDate").text(a("#dp4").data("date"))}a("#dp4").datepicker("hide")});a("#dp5").datepicker().on("changeDate",function(d){if(d.date.valueOf()<b.valueOf()){a("#alert").show().find("strong").text("The end date can not be less then the start date")}else{a("#alert").hide();c=new Date(d.date);a("#endDate").text(a("#dp5").data("date"))}a("#dp5").datepicker("hide")});a("#reservation").daterangepicker();a("#reportrange").daterangepicker({ranges:{Today:[moment(),moment()],Yesterday:[moment().subtract("days",1),moment().subtract("days",1)],"Last 7 Days":[moment().subtract("days",6),moment()],"Last 30 Days":[moment().subtract("days",29),moment()],"This Month":[moment().startOf("month"),moment().endOf("month")],"Last Month":[moment().subtract("month",1).startOf("month"),moment().subtract("month",1).endOf("month")]}},function(e,d){a("#reportrange span").html(e.format("MMMM D, YYYY")+" - "+d.format("MMMM D, YYYY"))});a("#datetimepicker4").datetimepicker({pickDate:false});a.each(a(".make-switch"),function(){a(this).bootstrapSwitch({onText:a(this).data("onText"),offText:a(this).data("offText"),onColor:a(this).data("onColor"),offColor:a(this).data("offColor"),size:a(this).data("size"),labelText:a(this).data("labelText")})})};return Metis})(jQuery);(function(a){Metis.formValidation=function(){a("#popup-validation").validationEngine();a("#inline-validate").validate({rules:{required:"required",email:{required:true,email:true},date:{required:true,date:true},url:{required:true,url:true},password:{required:true,minlength:5},confirm_password:{required:true,minlength:5,equalTo:"#password"},agree:"required",minsize:{required:true,minlength:3},maxsize:{required:true,maxlength:6},minNum:{required:true,min:3},maxNum:{required:true,max:16}},errorClass:"help-block col-lg-6",errorElement:"span",highlight:function(d,b,c){a(d).parents(".form-group").removeClass("has-success").addClass("has-error")},unhighlight:function(d,b,c){a(d).parents(".form-group").removeClass("has-error").addClass("has-success")}});a("#block-validate").validate({rules:{required2:"required",email2:{required:true,email:true},date2:{required:true,date:true},url2:{required:true,url:true},password2:{required:true,minlength:5},confirm_password2:{required:true,minlength:5,equalTo:"#password2"},agree2:"required",digits:{required:true,digits:true},range:{required:true,range:[5,16]}},errorClass:"help-block",errorElement:"span",highlight:function(d,b,c){a(d).parents(".form-group").removeClass("has-success").addClass("has-error")},unhighlight:function(d,b,c){a(d).parents(".form-group").removeClass("has-error").addClass("has-success")}})};return Metis})(jQuery);(function(a,b){b.formWizard=function(){a("#fileUpload").uniform();a("#uploader").pluploadQueue({runtimes:"html5,html4",url:"form-wysiwyg.html",max_file_size:"128kb",unique_names:true,filters:[{title:"Image files",extensions:"jpg,gif,png"}]});a("#wizardForm").formwizard({formPluginEnabled:true,validationEnabled:true,focusFirstInput:true,formOptions:{beforeSubmit:function(c){a.gritter.add({title:"data sent to the server",text:a.param(c),sticky:false});return false},dataType:"json",resetForm:true},validationOptions:{rules:{server_host:"required",server_name:"required",server_user:"required",server_password:"required",table_prefix:"required",table_collation:"required",username:{required:true,minlength:3},usermail:{required:true,email:true},pass:{required:true,minlength:6},pass2:{required:true,minlength:6,equalTo:"#pass"}},errorClass:"help-block",errorElement:"span",highlight:function(e,c,d){a(e).parents(".form-group").removeClass("has-success").addClass("has-error")},unhighlight:function(e,c,d){a(e).parents(".form-group").removeClass("has-error").addClass("has-success")}}})};return b})(jQuery,Metis||{});(function(a){Metis.formWysiwyg=function(){a("#wysihtml5").wysihtml5();var c=Markdown.getSanitizingConverter();var b=new Markdown.Editor(c);b.run();var d={basePath:"//cdnjs.cloudflare.com/ajax/libs/epiceditor/0.2.2"};var e=new EpicEditor(d).load()};return Metis})(jQuery);(function(a){Metis.MetisCalendar=function(){var c=new Date();var g=c.getDate();var b=c.getMonth();var i=c.getFullYear();var h={};if(a(window).width()<=767){h={left:"title",center:"month,agendaWeek,agendaDay",right:"prev,today,next"}}else{h={left:"",center:"title",right:"prev,today,month,agendaWeek,agendaDay,next"}}var f=function(j){var d={title:a.trim(j.text()),className:a.trim(j.children("span").attr("class"))};j.data("eventObject",d);j.draggable({zIndex:999,revert:true,revertDuration:0})};var e=function(k,j){k=k.length===0?"Untitled Event":k;j=j.length===0?"label label-default":j;var d=a('<li class="external-event"><span class="'+j+'">'+k+"</span></li>");jQuery("#external-events").append(d);f(d)};a("#external-events li.external-event").each(function(){f(a(this))});a("#add-event").click(function(){var j=a("#title").val();var d=a("input:radio[name=priority]:checked").val();e(j,d)});a("#calendar").fullCalendar({header:h,editable:true,droppable:true,drop:function(k){var j=a(this).data("eventObject");var d=a.extend({},j);d.start=k;a("#calendar").fullCalendar("renderEvent",d,true);if(a("#drop-remove").is(":checked")){a(this).remove()}},windowResize:function(d,j){a("#calendar").fullCalendar("render")}})};return Metis})(jQuery);(function(a){Metis.MetisFile=function(){var b=a("#elfinder").elfinder({url:"assets/elfinder-2.0-rc1/php/connector.php"}).elfinder("instance")};return Metis})(jQuery);(function(a){Metis.MetisMaps=function(){var i,h,f,e,c,b,g,d;i=new GMaps({el:"#gmaps-basic",lat:-12.043333,lng:-77.028333,zoomControl:true,zoomControlOpt:{style:"SMALL",position:"TOP_LEFT"},panControl:false,streetViewControl:false,mapTypeControl:false,overviewMapControl:false});h=new GMaps({el:"#gmaps-marker",lat:-12.043333,lng:-77.028333});h.addMarker({lat:-12.043333,lng:-77.03,title:"Lima",details:{database_id:42,author:"HPNeo"},click:function(j){if(console.log){console.log(j)}alert("You clicked in this marker")},mouseover:function(j){if(console.log){console.log(j)}}});h.addMarker({lat:-12.042,lng:-77.028333,title:"Marker with InfoWindow",infoWindow:{content:"<p>HTML Content</p>"}});f=new GMaps({el:"#gmaps-geolocation",lat:-12.043333,lng:-77.028333});GMaps.geolocate({success:function(j){f.setCenter(j.coords.latitude,j.coords.longitude)},error:function(j){alert("Geolocation failed: "+j.message)},not_supported:function(){alert("Your browser does not support geolocation")},always:function(){}});e=new GMaps({el:"#gmaps-polylines",lat:-12.043333,lng:-77.028333,click:function(j){console.log(j)}});g=[[-12.044012922866312,-77.02470665341184],[-12.05449279282314,-77.03024273281858],[-12.055122327623378,-77.03039293652341],[-12.075917129727586,-77.02764635449216],[-12.07635776902266,-77.02792530422971],[-12.076819390363665,-77.02893381481931],[-12.088527520066453,-77.0241058385925],[-12.090814532191756,-77.02271108990476]];e.drawPolyline({path:g,strokeColor:"#131540",strokeOpacity:0.6,strokeWeight:6});c=new GMaps({el:"#gmaps-route",lat:-12.043333,lng:-77.028333});c.drawRoute({origin:[-12.044012922866312,-77.02470665341184],destination:[-12.090814532191756,-77.02271108990476],travelMode:"driving",strokeColor:"#131540",strokeOpacity:0.6,strokeWeight:6});d=new GMaps({el:"#gmaps-geocoding",lat:-12.043333,lng:-77.028333});a("#geocoding_form").submit(function(j){j.preventDefault();GMaps.geocode({address:a("#address").val().trim(),callback:function(l,k){if(k==="OK"){var m=l[0].geometry.location;d.setCenter(m.lat(),m.lng());d.addMarker({lat:m.lat(),lng:m.lng()})}}})})};return Metis})(jQuery);(function(a,c){if(!a().sortable){return}var b=a(".inner [class*=col-]");c.metisSortable=function(){b.sortable({placeholder:"ui-state-highlight"}).disableSelection()};return c})(jQuery,Metis||{});(function(a){Metis.MetisTable=function(){a(".sortableTable").tablesorter();a("#dataTable").dataTable({})};return Metis})(jQuery);(function(a,c){var b=function(d,e){d.removeClass("primary success danger warning info default").addClass(e)};c.MetisPricing=function(){var d=a("ul.dark li.active"),e=a("ul#light li.active");a("#dark-toggle label").on(c.buttonPressedEvent,function(){var f=a(this);b(d,f.find("input").val())});a("#light-toggle label").on(c.buttonPressedEvent,function(){var f=a(this);b(e,f.find("input").val())})};return c})(jQuery,Metis||{});(function(a,b){b.MetisProgress=function(){var c=a(".progress .progress-bar");a.each(c,function(){var d=a(this);d.animate({width:a(this).attr("aria-valuenow")+"%"}).popover({placement:"bottom",title:"Source",content:this.outerHTML})})};return b})(jQuery,Metis);