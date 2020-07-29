 $(function(){
	 var name = $("#_name");
	 name.keyup(function(e){
		 e.preventDefault();
		 name.val($(this).val().toUpperCase());
	 });
	 
	 var rs = $("#_rs");
	 rs.keyup(function(e){
		 e.preventDefault();
		 rs.val($(this).val().toUpperCase());
	 });

	 var cargo = $("#_cargo");
	 cargo.keyup(function(e){
		 e.preventDefault();
		 cargo.val($(this).val().toUpperCase());
	 });
		 
 });
 