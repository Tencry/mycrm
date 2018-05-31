$(document).ready(function() {
//
// FORM SEARCH
//
	$('.searchForm').livequery(function() {
		var table = $(this).closest('div.table_grid');
		$(this).ajaxForm({
			success: function() {
				reloadgrid(table);
			}
		});
	});

	$(document).on('click','.clearsearch', function(){		var table = $(this).closest('div.table_grid');
		var form = $(this).closest('form');
		form.ajaxForm({
			success: function() {				reloadgrid(table);
			}
		});
	});


//
// FORM EDIT
//
	$('.editform').livequery(function() {
		var editform = this;
		$(this).validate();
		$(this).ajaxForm({
			success: function() {
				callback = $(editform).arcticmodal('callback');
				callback();
				$(editform).arcticmodal('close');
				//$('.arcticmodal-close:last').click();
			}
		});
	});//
// GRID EDIT
//
	//$.listen("click", ".grid_edit", function(){
	//$('.grid_edit').on("click", function() {	$(document).on('click', '.grid_edit', function(){		var link = this.rel;
		var tr = $(this).closest('tr');
    	openDialog(link,function()
		{
			reloadtr(tr,link);
		});
    });


//
// GRID SELECT
//
	$(document).on('click', '.grid_select', function(){		var link = this.rel;
		callback = $(this).arcticmodal('callback');
		callback(link);
		$(this).arcticmodal('close');
		//$('.arcticmodal-close:last').click();
	});


//
// GRID ADD
//
	$(document).on('click', '.grid_add', function(){
		var table = $(this).closest('div.table_grid');
		var link = this.rel;
		openDialog(link,function()
		{			reloadgrid(table);
		});
	});


//
// GRID PAGE
//
	$(document).on('click', '.page', function(){
				var table = $(this).closest('div.table_grid');
		var link = this.rel;
		reloadgrid(table,link);
	});


//
// GRID SORTBY
//
	$(document).on('click', '.sortby', function(){
		var table = $(this).closest('div.table_grid');
		var link = this.rel;
		reloadgrid(table,link);
	});


//
// REFERENCE FIND
//
	$(document).on('click', '.find_reference', function(){		var link = this.rel;
		var field = $(this).closest('div.input-append').find('select');
    	openDialog(link,function(value)
		{			field.load(value);
		});
    });


//
// HASMANY FIND
//
	$(document).on('click', '.find_hasmany', function(){
		var link = this.rel;
		var field = $(this).closest('div.input-append').find('select');
    	openDialog(link,function(value)
		{			field.load(value);
		});
    });


//
// HASMANY DELETE
//
	$(document).on('click', '.del_hasmany', function(){		$(this).closest('div.input-append').remove();
    });


//
// HASMANY ADD FIELD
//
	$(document).on('click', '.add_hasmany', function() {
		var div = $(this).closest('fieldset').find('div.hasmany');
		var link = this.rel;
    	addField(div,link);
    });


//
// DATEPICKER
//
	$.datepicker.setDefaults( $.datepicker.regional[ "ru" ] );
	$('.datepicker').livequery(function() {
		$(this).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd",
			firstDay: 1,
			showAnim: 'slideDown'
		});
	});


});



////////////////////////////////////////////////////////////////////////////////

   	function openDialog(page,page_callback)
   	{   		$.arcticmodal(
   		{
			type: 'ajax',
			url: page,
			callback: page_callback,
			ajax:
			{
				type: 'GET',
				cache: false,
				success: function(data, el, responce)
				{
					var h = $('<div class="b-modal">' +
					'<div class="b-modal_close arcticmodal-close">X</div>' +
					'<p>' + responce + '</p>' +
					'</div>');
     				data.body.html(h);
				}
			},
		    afterClose: function(data, el) {
		    	//page_callback();
		    	//alert('close');
		    }
		});
   	}

	function reloadgrid(table,page)
	{
		link = table.attr('rel');
		//alert(link+'&'+page);
		table.load(link,page);
   	}

   	function reloadtr(tr,link)
   	{   		var tds = tr.find('td');
		$.getJSON(link + '&tr=1', {}, function(json){			if (json[0] == undefined)
			{				tr.remove();			}
			else {
	            var i = 0;
	            $.each(json[0], function() {
	            	var value = this;
	            	if (value == '[object Window]') value = '';
	            	var td = tds[i++];
	            	var span = $(td).find('a:first').find('span:first');
	            	if (span.length){	            		span.html(value);
	            	}
	            	else {
	            		td.innerHTML = value;
	            	}
	            });
	        }
        });
   	}

   	function addField(div,link)
   	{
  	    var count = div.find('select').length+1;
		$.get(link + '&index=' + count, function(data) {
			div.append(data);
		});
	}
