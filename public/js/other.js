function setCookie(name, value) {
	var today = new Date();
	var expire = new Date();
	expire.setTime(today.getTime() + 3600000*24*365);
	document.cookie= name + "=" + escape(value) +";expires=" + expire.toGMTString() + ";path=/";
	// +	";domain=/galerie/"
}


function showMenu(item){
         
	var Item = document.getElementById (item);
	if(menu_visible[item]){
		Item.style.display='none';
		menu_visible[item]=0;
		setCookie(item,0);
	}else{
		Item.style.display='block';
		menu_visible[item]=1;
		setCookie(item,1);
  }
}

/*
window.onload=show;

function show(id) {
var d = document.getElementById(id);
	for (var i = 1; i<=10; i++) {
		if (document.getElementById('smenu'+i)) {document.getElementById('smenu'+i).style.display='none';}
	}
 if (d) {d.style.display='block';}
}

*/

function hide(item){
	var Item = document.getElementById (item);
	
	Item.style.display='none';
}

function setVisibility(id, visibility) {

	document.getElementById(id).style.display = visibility;	
	//document.getElementById(id).style.top = 10+curY + document.body.scrollTop +  \'px\';
	//document.getElementById(id).style.left = curX - 10 + document.body.scrollLeft +  \'px\';
		
	document.getElementById(id).style.top = 10+curY  +  'px';
	document.getElementById(id).style.left = curX - 10 +  'px';
	

}

function listener( e )
{
   var docX, docY;
   if( e )
   {
      if( typeof( e.pageX ) == 'number' )
      {
         docX = e.pageX;
         docY = e.pageY;
      }
      else
      {
         docX = e.clientX;
         docY = e.clientY;
      }
   }
   else
   {
      e = window.event;
      docX = e.clientX;
      docY = e.clientY;
      if( document.documentElement
        && ( document.documentElement.scrollTop
            || document.documentElement.scrollLeft ) )
      {
         docX += document.documentElement.scrollLeft;
         docY += document.documentElement.scrollTop;
      } 
      else if( document.body
         && ( document.body.scrollTop
             || document.body.scrollLeft ) )
      {
         docX += document.body.scrollLeft;
         docY += document.body.scrollTop;
      }
   }
   
   curX = docX;
   curY = docY;
}

