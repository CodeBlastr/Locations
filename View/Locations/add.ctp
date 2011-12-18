<div class="locations form">
<?php echo $this->Form->create('Location');?>
	<fieldset>
 		<legend><?php echo __('Add Location'); ?></legend>
	<?php
		echo $this->Form->input('zip');
		echo $this->Form->select('model', $model, null, null);
		echo $this->Form->input('foreign_key');
		echo $this->Form->input('creator_id');
		echo $this->Form->input('modifier_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Locations', true), array('action' => 'index'));?></li>
	</ul>
</div>

<html>
<head>
<script type="text/javascript">
//IPInfoDB javascript JSON query example
//Tested with FF 3.5, Opera 10, Chome 5 and IE 8
//Geolocation data is stored as serialized JSON in a cookie
//Bug reports : http://forum.ipinfodb.com/viewforum.php?f=7
function geolocate(timezone, cityPrecision, objectVar) {
 
  var api = (cityPrecision) ? "ip-city" : "ip-country";
  var domain = 'api.ipinfodb.com';
  var url = "http://" + domain + "/" + api + "/?key=989f5aa44ad0d14ee67b3aae454fd284816b94202fa52d52d9fe3b33037dad87&format=json" + "&callback=" + objectVar + ".setGeoCookie";
  var geodata;
  var callbackFunc;
  var JSON = JSON || {};
 
  // implement JSON.stringify serialization
  JSON.stringify = JSON.stringify || function (obj) {
    var t = typeof (obj);
    if (t != "object" || obj === null) {
      // simple data type
      if (t == "string") obj = '"'+obj+'"';
        return String(obj);
    } else {
    // recurse array or object
      var n, v, json = [], arr = (obj && obj.constructor == Array);
      for (n in obj) {
        v = obj[n]; t = typeof(v);
        if (t == "string") v = '"'+v+'"';
        else if (t == "object" && v !== null) v = JSON.stringify(v);
        json.push((arr ? "" : '"' + n + '":') + String(v));
      }
      return (arr ? "[" : "{") + String(json) + (arr ? "]" : "}");
    }
  };
 
  // implement JSON.parse de-serialization
  JSON.parse = JSON.parse || function (str) {
    if (str === "") str = '""';
      eval("var p=" + str + ";");
      return p;
  };
 
  //Check if cookie already exist. If not, query IPInfoDB
  this.checkcookie = function(callback) {
    geolocationCookie = getCookie('geolocation');
    callbackFunc = callback;
    if (!geolocationCookie) {
      getGeolocation();
    } else {
      geodata = JSON.parse(geolocationCookie);
      callbackFunc();
    }
  }
 
  //API callback function that sets the cookie with the serialized JSON answer
  this.setGeoCookie = function(answer) {
    if (answer['statusCode'] == 'OK') {
      JSONString = JSON.stringify(answer);
      setCookie('geolocation', JSONString, 365);
      geodata = answer;
      callbackFunc();
    }
  }
 
  //Return a geolocation field
  this.getField = function(field) {
    try {
      return geodata[field];
    } catch(err) {}
  }
 
  //Request to IPInfoDB
  function getGeolocation() {
    try {
      script = document.createElement('script');
      script.src = url;
      document.body.appendChild(script);
    } catch(err) {}
  }
 
  //Set the cookie
  function setCookie(c_name, value, expire) {
    var exdate=new Date();
    exdate.setDate(exdate.getDate()+expire);
    document.cookie = c_name+ "=" +escape(value) + ((expire==null) ? "" : ";expires="+exdate.toGMTString());
  }
 
  //Get the cookie content
  function getCookie(c_name) {
    if (document.cookie.length > 0 ) {
      c_start=document.cookie.indexOf(c_name + "=");
      if (c_start != -1){
        c_start=c_start + c_name.length+1;
        c_end=document.cookie.indexOf(";",c_start);
        if (c_end == -1) {
          c_end=document.cookie.length;
        }
        return unescape(document.cookie.substring(c_start,c_end));
      }
    }
    return '';
  }
}
</script>
</head>
 
<body>
<script type="text/javascript">
//function geolocate(timezone, cityPrecision, objectVar).
//If you rename your object name, you must rename 'visitorGeolocation' in the function
var visitorGeolocation = new geolocate(false, true, 'visitorGeolocation');
 
//Check for cookie and run a callback function to execute after geolocation is read either from cookie or IPInfoDB API
var callback = function(){
				alert('jhhhhh');
                alert('Visitor country code : ' + visitorGeolocation.getField('countryCode'))
               };
visitorGeolocation.checkcookie(callback);
</script>
</body>
</html>
