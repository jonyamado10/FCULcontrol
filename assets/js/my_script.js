
$(document).ready(function(){

    $("#navGraficos").click(function(){
	    if ( $( "#collapseComponents" ).is( ":visible" )) {
	      
	  			sessionStorage.setItem("navGrafico", 0);	 
	    }
	    else{

			sessionStorage.setItem("navGrafico", 1);

	    }
    });
   	var state = sessionStorage.getItem("navGrafico") ;
     if(state == 1 ){
    	$('#navGraficos').click();
    }


     $("#navTabelas").click(function(){
	     if ( $( "#collapseComponents2" ).is( ":visible" )) {
	      
	  			sessionStorage.setItem("navTabela", 0);
	  			 

	    }
	    else{

			sessionStorage.setItem("navTabela", 1);

	    }
    });
   	var state1 = sessionStorage.getItem("navTabela") ;
     if(state1 == 1 ){
    	$('#navTabelas').click();
    }


     $("#navFerramentas").click(function(){
	     if ( $( "#collapseComponents3" ).is( ":visible" )) {
	      
	  			sessionStorage.setItem("navFerramenta", 0);
	  			 

	    }
	    else{

			sessionStorage.setItem("navFerramenta", 1);
			

	    }
    });
   	var state2 = sessionStorage.getItem("navFerramenta") ;
     if(state2 == 1 ){
    	$('#navFerramentas').click();
    }
});

