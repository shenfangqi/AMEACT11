function getRequester()
{
  try
  {
      if(window.XMLHttpRequest) 
      {
          return new XMLHttpRequest();
      } 
      else if(window.ActiveXObject)
      {
         try 
         {
               return new ActiveXObject("Microsoft.XMLHTTP");
         } catch (e) 
         {
               try {
                    return new ActiveXObject("Msxml2.XMLHTTP");
               } catch (e) {return false;}
         }          
      }
  }
  catch (e) 
  {
          alert("ajax getRequester error.");
	  return false;
  }
}


function Ajax(cb,loads)
{
  
  var me = this;
  
  
  if(cb)
  {
	
    this.callback = cb;
  }
  else
    this.callback = function(req)
    {
      return eval(req.responseText);
    }
  if(loads)
    this.Loads = loads;
  else
    this.Loads = function(readyState)
    {
      return readyState;
    }

 

  this.state = function()
  {
    return me.requester.readyState;
  }

  this.readystatechange = function()
  {
  	//alert(me.requester.readyState);
  	switch(me.requester.readyState)
    {
      case 1:
	     me.Loads(me.requester.readyState,me.value);
		 break;
      case 2:
      case 3:
	    
        break;
      case 4:
	    
	    if(me.requester.status == 200)
		{
			 var response = me.callback(me.requester,me.value);
		}
        break;
      default:
        alert("Error");
        break;
    }
	
  }

  this.process = function(url, parameters,method){
	//alert(url);
	if(method=="POST")
	{
		delete this.requester;
		this.requester = getRequester();
		this.requester.onreadystatechange = this.readystatechange;
		me.value = parameters;
		me.requester.open("POST", url, true);
	    me.requester.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	    //me.requester.setRequestHeader("Content-type", "text/html; charset=GB2312");
        me.requester.setRequestHeader("Content-length", parameters.length);
        me.requester.setRequestHeader("Connection", "close");
        me.requester.send(parameters);
	    
		
	}
	else
	{
		url = url+"?"+parameters;
		//alert(url);
		me.value = parameters;
		me.requester.open("GET", url, true);
		me.requester.send(null);
	    
	}
	
  }
}

